# MySQL Setup Guide for Laravel Blog

## Problem
phpMyAdmin cannot connect to MySQL because the root password is not configured correctly.

## Solution Steps

### Step 1: Find Your MySQL Root Password

You need to know your MySQL root password. Common locations:

**If using XAMPP:**
- Default password is usually **empty** (no password)
- Check: `C:\xampp\mysql\data\` for any password files

**If using WAMP:**
- Default password is usually **empty** (no password)

**If using standalone MySQL:**
- Check your MySQL installation notes
- Or reset the password (see below)

### Step 2: Update phpMyAdmin Configuration

1. **Find phpMyAdmin config file:**
   - XAMPP: `C:\xampp\phpMyAdmin\config.inc.php`
   - WAMP: `C:\wamp64\apps\phpmyadmin\config.inc.php`
   - Or search for `config.inc.php` in your web server directory

2. **Edit the config file** and update these lines:
   ```php
   $cfg['Servers'][1]['user'] = 'root';
   $cfg['Servers'][1]['password'] = 'YOUR_PASSWORD_HERE'; // Put your password here
   ```

3. **If you don't have a password**, leave it empty:
   ```php
   $cfg['Servers'][1]['password'] = '';
   ```

### Step 3: Create the Database

**Option A: Using phpMyAdmin (after fixing config)**
1. Open phpMyAdmin in your browser (usually `http://localhost/phpmyadmin`)
2. Click "New" in the left sidebar
3. Database name: `bts_blog`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

**Option B: Using MySQL Command Line**
```bash
# If MySQL is in your PATH:
mysql -u root -p
# Enter your password when prompted
CREATE DATABASE bts_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**Option C: Using the setup script**
```powershell
cd D:\blog\bts-blog
.\setup-mysql.ps1
```

### Step 4: Update Laravel .env File

Edit `D:\blog\bts-blog\.env` and ensure these lines are correct:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bts_blog
DB_USERNAME=root
DB_PASSWORD=YOUR_PASSWORD_HERE
```

**If no password**, leave it empty:
```env
DB_PASSWORD=
```

### Step 5: Test the Connection

```bash
cd D:\blog\bts-blog
php artisan migrate:status
```

If successful, you should see your migration status.

### Step 6: Run Migrations

```bash
php artisan migrate
```

## Resetting MySQL Root Password (If Needed)

If you've forgotten your MySQL root password:

**For XAMPP:**
1. Stop MySQL service
2. Create a text file `reset.txt` with:
   ```
   ALTER USER 'root'@'localhost' IDENTIFIED BY '';
   ```
3. Start MySQL with: `mysqld --init-file=C:\path\to\reset.txt`
4. Delete the reset file

**For WAMP:**
1. Use WAMP menu → MySQL → MySQL Console
2. Follow password reset prompts

## Quick Fix Script

Run the PowerShell script provided:
```powershell
cd D:\blog\bts-blog
.\setup-mysql.ps1
```

This will guide you through the setup process.

