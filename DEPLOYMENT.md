# MBC Website - Deployment Guide

## Production Server Configuration

### FTP Details
- **Host**: ftpupload.net
- **Port**: 21
- **Username**: if0_40083220
- **Password**: Pzgvz4HSB6XU

### MySQL Details
- **Host**: sql100.infinityfree.com
- **Port**: 3306
- **Username**: if0_40083220
- **Password**: Pzgvz4HSB6XU
- **Database**: if0_40083220_mbc

## Deployment Steps

### 1. Upload Files via FTP
```bash
# Upload all project files to public_html directory
# Keep local config/database.php safe (don't overwrite)
```

### 2. Configure Production Database
```php
// Update config/database.php with production settings
// Or use config/database.production.php as reference
```

### 3. Set Up .htaccess
```bash
# Rename .htaccess.production to .htaccess
# This enables security headers and file protection
```

### 4. Create Database Tables
```sql
-- Import database_schema.sql to create all tables
-- Tables: users, blog_posts, contact_submissions, etc.
```

### 5. Set File Permissions
```bash
# Directories: 755
# PHP files: 644
# media/ directory: 777
```

### 6. Create Admin User
```sql
-- Insert admin user in users table
INSERT INTO users (username, email, password_hash, full_name, role) 
VALUES ('admin', 'admin@mbc-expertcomptable.fr', '$2y$10$...', 'Admin User', 'admin');
```

### 7. Configure Domain
- Update APP_URL in config/database.php
- Configure SSL certificate
- Set up domain DNS

## Security Features

### File Protection
- Database config files are protected
- SQL files are not accessible
- Config and includes directories are protected

### Security Headers
- X-Content-Type-Options: nosniff
- X-Frame-Options: DENY
- X-XSS-Protection: enabled
- Referrer-Policy: strict-origin-when-cross-origin

### Session Security
- HTTP-only cookies
- Secure cookies (HTTPS)
- Strict mode enabled

## Performance Optimizations

### Caching
- Static files cached for 1 month
- CSS, JS, images cached
- PDF files cached

### Compression
- Gzip compression enabled
- Text files compressed
- JavaScript and CSS compressed

## Troubleshooting

### Common Issues
1. **Database Connection Error**
   - Check MySQL credentials
   - Verify database exists
   - Check host and port

2. **File Upload Issues**
   - Check media/ directory permissions (777)
   - Verify PHP upload limits
   - Check .htaccess configuration

3. **Admin Login Issues**
   - Verify admin user exists in database
   - Check password hash
   - Clear browser cache

### Log Files
- Check server error logs
- Monitor PHP error logs
- Check database connection logs

## Local Development

### Keep Local Config Safe
- Don't commit production credentials
- Use separate config files
- Test locally before deployment

### Development vs Production
- Local: config/database.php
- Production: config/database.production.php
- Different .htaccess files for each environment

## Support

For deployment issues:
1. Check this guide
2. Verify server requirements
3. Check file permissions
4. Test database connection
5. Review error logs

## Server Requirements

### PHP
- PHP 7.4 or higher
- PDO MySQL extension
- GD extension (for image processing)
- File upload support

### MySQL
- MySQL 5.7 or higher
- UTF-8 support
- InnoDB engine

### Apache
- mod_rewrite enabled
- mod_headers enabled
- mod_deflate enabled
- mod_expires enabled
