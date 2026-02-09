# TravSavers

Travel savings and benefits platform.

## Project Setup

This project was extracted from a backup zip file and set up as a new GitHub repository.

## Version History

### Version 1.0.0 - 2025-02-09
- **Date**: February 9, 2025
- **Time**: Initial setup
- **Changes**: 
  - Extracted project from backup zip file
  - Initialized git repository
  - Created GitHub repository: https://github.com/ferfortini/TravSavers
  - Removed sensitive files (API keys, secrets) from version control
  - Set up .gitignore for security

## Repository

- **GitHub**: https://github.com/ferfortini/TravSavers
- **Main Branch**: main

## Project Structure

- `public_html/` - Main application files (PHP, CSS, JS)
- `mysql/` - Database backup files
- `.gitignore` - Git ignore rules (includes sensitive files)

## Security Notes

The following files contain sensitive information and are excluded from version control:
- `public_html/google_ads_php.ini` - Google OAuth credentials
- `public_html/secrets.php` - Stripe API keys
- `public_html/travbenefits/travis2.php` - OpenAI API keys
- `public_html/inc/db_connect.php` - Database connection details

These files should be configured locally or through environment variables.

## Setup Instructions

1. Clone the repository
2. Configure database connection in `public_html/inc/db_connect.php`
3. Set up API keys in the excluded files (see Security Notes)
4. Configure web server to point to `public_html/` directory
