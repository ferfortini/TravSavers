# Google Maps API Setup Guide

## Current API Key
The project is currently using: `AIzaSyAy1L4SogCeS9kwHHK8n_0LKVGCtcDwUs4`

## Error: "This page can't load Google Maps correctly"

This error typically occurs due to one of the following issues:

### 1. **API Key Not Valid or Expired**
- Check if the API key is still active in Google Cloud Console
- Verify the key hasn't been deleted or regenerated

### 2. **Maps JavaScript API Not Enabled**
**Steps to enable:**
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Select your project
3. Navigate to **APIs & Services** > **Library**
4. Search for "Maps JavaScript API"
5. Click on it and press **Enable**

### 3. **Billing Not Enabled**
**Steps to enable billing:**
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Navigate to **Billing**
3. Link a billing account to your project
4. Note: Google provides $200 free credit per month for Maps usage

### 4. **API Key Restrictions**
If your API key has HTTP referrer restrictions, you need to add localhost:

**For Development (localhost):**
1. Go to **APIs & Services** > **Credentials**
2. Click on your API key
3. Under **Application restrictions**, select **HTTP referrers (web sites)**
4. Add these referrers:
   - `http://localhost:8000/*`
   - `http://127.0.0.1:8000/*`
   - `http://localhost/*` (for general localhost access)

**For Production:**
- Add your production domain: `https://yourdomain.com/*`
- Add `https://www.yourdomain.com/*` if you use www

### 5. **Required APIs**
Make sure these APIs are enabled:
- ✅ **Maps JavaScript API** (required)
- ✅ **Places API** (if using Places library - currently used in search-destinations.php)

### 6. **Check API Quotas**
1. Go to **APIs & Services** > **Dashboard**
2. Check if you've exceeded any quotas
3. Verify your billing account is active

## Testing the API Key

You can test if your API key works by visiting:
```
https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY
```

If it returns JavaScript code, the key is valid. If it returns an error, check the error message.

## Quick Fix Checklist

- [ ] Verify API key is correct in `search-destinations.php` (line 240)
- [ ] Enable Maps JavaScript API in Google Cloud Console
- [ ] Enable Places API (if using Places library)
- [ ] Enable billing account
- [ ] Add localhost to API key restrictions (if restrictions are enabled)
- [ ] Check API quotas haven't been exceeded
- [ ] Verify the API key hasn't been deleted or regenerated

## Alternative: Use a New API Key

If the current key can't be fixed, you can create a new one:

1. Go to **APIs & Services** > **Credentials**
2. Click **Create Credentials** > **API Key**
3. Copy the new key
4. Update `search-destinations.php` line 240 with the new key
5. Restrict the key to HTTP referrers and add localhost/production domains

## Current Usage in Code

The API key is used in:
- `public_html/search-destinations.php` (line 240)
- `public_html/inc/map_scripts.php` (line 34)

Make sure to update both if you change the API key.
