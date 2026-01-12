# Fix MySQL Connection Issue

## Current Status
✅ **Application is now working with SQLite** (temporary solution)
❌ MySQL connection failed due to incorrect root password

## Quick Fix: Use SQLite (Current Setup)
Your application is currently configured to use SQLite and is working. The database file is at:
- `database/database.sqlite`

This is fine for development, but if you need MySQL features, follow the steps below.

## Fix MySQL Connection

### Option 1: Find Your MySQL Root Password

Check these common locations:
- **XAMPP**: Usually no password (empty), but check `C:\xampp\mysql\data\`
- **WAMP**: Usually no password (empty)
- **Standalone MySQL**: Check installation notes or MySQL configuration files
- **MySQL Workbench**: If installed, check saved connections

### Option 2: Reset MySQL Root Password

I've created a script to help: `reset-mysql-password.ps1`

**Quick Steps:**
1. Stop MySQL service
2. Start MySQL with `--skip-grant-tables`
3. Connect and reset password
4. Restart MySQL normally

**Or use the script:**
```powershell
cd D:\blog\bts-blog
.\reset-mysql-password.ps1
```

### Option 3: Create New MySQL User (Recommended)

Instead of using root, create a dedicated user for your Laravel app:

1. **Access MySQL** (if you can get in):
   ```sql
   CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON bts_blog.* TO 'laravel_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

2. **Update .env:**
   ```env
   DB_USERNAME=laravel_user
   DB_PASSWORD=your_secure_password
   ```

### Option 4: Use phpMyAdmin to Reset

1. If you can access phpMyAdmin (even with errors), try:
   - Go to "User accounts" tab
   - Edit root user
   - Change password
   - Update both `.env` and phpMyAdmin `config.inc.php`

## Switch Back to MySQL

Once you have the correct password:

1. **Update `.env` file:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bts_blog
   DB_USERNAME=root
   DB_PASSWORD=your_password_here
   ```

2. **Create the database** (if not exists):
   ```sql
   CREATE DATABASE bts_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Clear cache and test:**
   ```bash
   php artisan config:clear
   php artisan migrate:status
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## Test MySQL Connection

Use the test script:
```bash
php test-mysql.php
```

This will try common passwords and tell you which one works.

## Current Configuration

Your `.env` is currently set to SQLite:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

This works fine for development. Switch to MySQL when you're ready!

