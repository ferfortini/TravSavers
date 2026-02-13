# Hero Images Setup Guide

## Overview
The hero image system automatically displays destination-specific images in the search results page. It uses a two-tier approach:
1. **Curated Images**: Pre-downloaded high-quality images for popular destinations
2. **Hotel API Fallback**: Automatically uses the first hotel image if no curated image exists

## How It Works

### 1. Dynamic Hero Image Mapping
The system checks the destination city and maps it to a hero image:
- **Las Vegas, NV** → `vegas.jpg`
- **Orlando, FL** → `orlando.jpg`
- **Miami, FL** → `miami.jpg`
- **Myrtle Beach, SC** → `myrtle-beach.jpg`
- **Branson, MO** → `branson.jpg`
- **Default** → `default.jpg` (or hotel image if available)

### 2. Automatic Fallback
If no curated image exists for a destination, the system automatically uses the first hotel's image from the search results.

## Setting Up Hero Images

### Option 1: Use Unsplash API (Recommended)

1. **Get a Free Unsplash API Key:**
   - Go to https://unsplash.com/developers
   - Create a free account
   - Click "New Application"
   - Copy your "Access Key"

2. **Update the Download Script:**
   - Open `download_hero_images.php`
   - Replace `YOUR_UNSPLASH_ACCESS_KEY_HERE` with your actual key

3. **Run the Download Script:**
   ```bash
   # Via command line:
   php download_hero_images.php
   
   # Or via browser:
   http://localhost:8000/download_hero_images.php
   ```

4. **Verify Images:**
   - Check `assets/images/heros/` folder
   - Should see: `miami.jpg`, `myrtle-beach.jpg`, `branson.jpg`

### Option 2: Manual Download

1. **Download Images:**
   - Go to https://unsplash.com or https://pexels.com
   - Search for destination images (e.g., "Miami Beach skyline")
   - Download high-quality landscape images (1920x1080 or larger)

2. **Save Images:**
   - Save to `assets/images/heros/` folder
   - Use exact filenames: `miami.jpg`, `myrtle-beach.jpg`, `branson.jpg`

### Option 3: Use Hotel API Images (Automatic)

No setup needed! The system automatically uses hotel images as fallback if no curated image exists.

## Adding More Destinations

To add more destinations:

1. **Add to Download Script:**
   ```php
   // In download_hero_images.php
   'New Destination, ST' => [
       'search_query' => 'New Destination cityscape',
       'filename' => 'new-destination.jpg'
   ],
   ```

2. **Add to Mapping:**
   ```php
   // In search-destinations.php
   'New Destination' => 'new-destination.jpg',
   ```

3. **Run Download Script** or manually add the image

## File Structure

```
public_html/
├── assets/
│   └── images/
│       └── heros/
│           ├── default.jpg
│           ├── orlando.jpg
│           ├── vegas.jpg
│           ├── miami.jpg
│           ├── myrtle-beach.jpg
│           └── branson.jpg
├── download_hero_images.php
└── search-destinations.php
```

## Troubleshooting

### Images Not Showing
- Check that images exist in `assets/images/heros/`
- Verify filenames match exactly (case-sensitive)
- Check browser console for errors

### Using Default Image
- This is normal for destinations without curated images
- System will automatically use hotel image as fallback
- Add destination to mapping to use curated image

### Unsplash API Errors
- Verify API key is correct
- Check API rate limits (50 requests/hour for free tier)
- System will fall back to hotel images if API fails

## Notes

- Images are cached by the browser
- Hotel API images are used as fallback automatically
- No API key needed if using hotel images only
- Unsplash images are free and don't require attribution
