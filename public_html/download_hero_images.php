<?php
/**
 * Automated Hero Image Downloaderß
 * Downloads destination hero images from Unsplash API
 * 
 * Usage: Run once via browser or CLI: php download_hero_images.php
 * 
 * Note: You need a free Unsplash API key from https://unsplash.com/developers
 * Set it in the UNSPLASH_ACCESS_KEY constant below
 */

// Unsplash API Key (get free key from https://unsplash.com/developers)
// Application ID: 872252
define('UNSPLASH_ACCESS_KEY', 'Cb--pqC3K0QOr2PeuiRAXui3I5FJF0rgA7OWhTMTYSA');

// Top 5 destinations by state
$destinations = [
    'Miami, FL' => [
        'search_query' => 'Miami Beach skyline cityscape',
        'filename' => 'miami.jpg'
    ],
    'Myrtle Beach, SC' => [
        'search_query' => 'Myrtle Beach ocean boardwalk',
        'filename' => 'myrtle-beach.jpg'
    ],
    'Branson, MO' => [
        'search_query' => 'Branson Missouri shows',
        'filename' => 'branson.jpg'
    ],
    // Add more destinations as needed
];

$heroDir = __DIR__ . '/assets/images/heros/';

// Ensure directory exists
if (!is_dir($heroDir)) {
    mkdir($heroDir, 0755, true);
}

function downloadHeroImage($searchQuery, $filename, $savePath, $requestCount) {
    if (empty(UNSPLASH_ACCESS_KEY) || UNSPLASH_ACCESS_KEY === 'YOUR_UNSPLASH_ACCESS_KEY_HERE') {
        echo "⚠️  Warning: Unsplash API key not set. Using hotel API images as fallback instead.\n";
        echo "   To use Unsplash, get a free key from https://unsplash.com/developers\n";
        echo "   and set it in download_hero_images.php\n\n";
        return false;
    }
    
    // Rate limiting: max 50 requests per hour
    if ($requestCount >= 50) {
        echo "⚠️  Rate limit reached (50 requests/hour). Stopping downloads.\n";
        return false;
    }
    
    // Rate limiting: wait 1 second between requests
    if ($requestCount > 0) {
        echo "⏳ Waiting 1 second before next request...\n";
        sleep(1);
    }
    
    // Search Unsplash
    $url = 'https://api.unsplash.com/search/photos?' . http_build_query([
        'query' => $searchQuery,
        'per_page' => 1,
        'orientation' => 'landscape'
    ]);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Client-ID ' . UNSPLASH_ACCESS_KEY
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    if (function_exists('curl_close')) {
        @curl_close($ch);
    }
    
    if ($httpCode !== 200) {
        echo "❌ Error fetching image for {$searchQuery}: HTTP {$httpCode}\n";
        if ($curlError) {
            echo "   cURL Error: {$curlError}\n";
        }
        if ($response) {
            $errorData = json_decode($response, true);
            if (isset($errorData['errors'][0])) {
                echo "   API Error: " . $errorData['errors'][0] . "\n";
            } elseif (isset($errorData['error'])) {
                echo "   API Error: " . $errorData['error'] . "\n";
            }
        }
        if ($httpCode === 401) {
            echo "   ⚠️  Unauthorized: Check if your API key is correct.\n";
        } elseif ($httpCode === 403) {
            echo "   ⚠️  Forbidden: This might be a rate limit issue. Check your API key and rate limits.\n";
        }
        return false;
    }
    
    $data = json_decode($response, true);
    
    if (!isset($data['results'][0]['urls']['regular'])) {
        echo "❌ No image found for {$searchQuery}\n";
        return false;
    }
    
    $imageUrl = $data['results'][0]['urls']['regular'];
    echo "   Found image: {$imageUrl}\n";
    
    // Download image using cURL for better error handling
    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $imageData = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (function_exists('curl_close')) {
        @curl_close($ch);
    }
    
    if ($imageData === false || $httpCode !== 200) {
        echo "❌ Error downloading image for {$searchQuery}\n";
        if ($curlError) {
            echo "   cURL Error: {$curlError}\n";
        }
        if ($httpCode !== 200) {
            echo "   HTTP Code: {$httpCode}\n";
        }
        return false;
    }
    
    // Save to file
    $filePath = $savePath . $filename;
    $saved = file_put_contents($filePath, $imageData);
    
    if ($saved) {
        echo "✓ Downloaded: {$filename} ({$searchQuery})\n";
        return true;
    } else {
        echo "❌ Error saving {$filename}\n";
        return false;
    }
}

// Download images
echo "🚀 Starting hero image download...\n";
echo "📊 Rate limiting: 1 request/second, max 50 requests/hour\n\n";

$requestCount = 0;
$successCount = 0;

foreach ($destinations as $destination => $config) {
    $requestCount++;
    echo "[Request {$requestCount}/50] Processing: {$destination}...\n";
    
    $result = downloadHeroImage(
        $config['search_query'],
        $config['filename'],
        $heroDir,
        $requestCount - 1 // Pass previous count for rate limiting
    );
    
    if ($result) {
        $successCount++;
    }
    
    // Check rate limit
    if ($requestCount >= 50) {
        echo "\n⚠️  Reached rate limit (50 requests/hour). Stopping.\n";
        break;
    }
}

echo "\n✅ Done! Images saved to: {$heroDir}\n";
echo "📊 Summary: {$successCount} of " . count($destinations) . " images downloaded\n";
echo "💡 Note: If Unsplash API key is not set, the system will use hotel API images as fallback.\n";
?>
