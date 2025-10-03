# MBC Website - Database Export Files

## Overview
This directory contains various database export files for the MBC website project.

## Export Files

### 1. `database_export.sql` (13.6 KB)
**Complete database export with data and structure**
- Contains all tables with their structure
- Includes all data (blog posts, users, categories, etc.)
- Includes stored procedures and triggers
- Ready for full database restoration
- **Use this for**: Complete backup or migration

### 2. `database_schema_only.sql` (6.0 KB)
**Database structure only (no data)**
- Contains table structures, indexes, and constraints
- Includes stored procedures and triggers
- No data included
- **Use this for**: Setting up new database structure

### 3. `database_structure.sql` (4.1 KB)
**Compact database structure**
- Minimal structure export
- No comments or formatting
- **Use this for**: Quick structure reference

### 4. `database_data_only.sql` (9.3 KB)
**Data only (no structure)**
- Contains only INSERT statements
- No table creation
- **Use this for**: Data migration to existing structure

### 5. `database_schema.sql` (4.9 KB)
**Original schema file**
- Manual schema definition
- Used for initial database setup
- **Use this for**: Reference or manual setup

## Database Tables

### Core Tables
- `users` - User accounts and authentication
- `blog_posts` - Blog articles and content
- `blog_categories` - Blog post categories
- `blog_post_categories` - Many-to-many relationship
- `contact_submissions` - Contact form submissions
- `newsletter_subscriptions` - Newsletter subscribers

### Table Relationships
```
users (1) → (many) blog_posts
blog_categories (many) → (many) blog_posts (via blog_post_categories)
```

## Usage Instructions

### For Production Deployment
1. **First time setup**: Use `database_schema_only.sql`
2. **Data migration**: Use `database_data_only.sql`
3. **Complete restore**: Use `database_export.sql`

### For Development
1. **Fresh install**: Use `database_schema.sql`
2. **Backup**: Use `database_export.sql`
3. **Structure only**: Use `database_structure.sql`

## Import Commands

### MySQL Command Line
```bash
# Complete database
mysql -u username -p database_name < database_export.sql

# Structure only
mysql -u username -p database_name < database_schema_only.sql

# Data only
mysql -u username -p database_name < database_data_only.sql
```

### phpMyAdmin
1. Select database
2. Go to Import tab
3. Choose file
4. Click Go

## Production Server Import
```bash
# For InfinityFree server
mysql -h sql100.infinityfree.com -u if0_40083220 -p if0_40083220_mbc < database_export.sql
```

## Security Notes
- These files contain sensitive data
- Do not commit to public repositories
- Store securely and limit access
- Remove before production deployment

## File Sizes
- `database_export.sql`: 13.6 KB (212 lines)
- `database_schema_only.sql`: 6.0 KB (153 lines)
- `database_structure.sql`: 4.1 KB
- `database_data_only.sql`: 9.3 KB
- `database_schema.sql`: 4.9 KB (113 lines)

## Last Updated
- Export Date: October 3, 2025
- Database: mbc_website
- MySQL Version: 8.0.43
- Server: localhost
