# Fix phpMyAdmin Connection Error

## The Problem
phpMyAdmin cannot connect to MySQL because:
- MySQL root password is not configured correctly in phpMyAdmin config
- The error shows: `Access denied for user 'root'@'localhost' (using password: NO)`

## Solution Steps

### Step 1: Find phpMyAdmin Configuration File

The config file is usually named `config.inc.php` and located in:

**Common Locations:**
- **XAMPP**: `C:\xampp\phpMyAdmin\config.inc.php`
- **WAMP**: `C:\wamp64\apps\phpmyadmin[version]\config.inc.php`
- **Standalone**: Wherever you installed phpMyAdmin
- **IIS**: `C:\inetpub\wwwroot\phpmyadmin\config.inc.php`

**Quick Search:**
1. Open File Explorer
2. Search for `config.inc.php` in `C:\`
3. Look for files in folders containing "phpmyadmin" or "phpMyAdmin"

### Step 2: Edit the Configuration File

Open `config.inc.php` in a text editor (Notepad++, VS Code, or even Notepad).

**Find this section** (usually around line 20-40):
```php
/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';
```

**Update the password line:**

**If MySQL root has NO password:**
```php
$cfg['Servers'][$i]['password'] = '';
```

**If MySQL root HAS a password:**
```php
$cfg['Servers'][$i]['password'] = 'your_mysql_password_here';
```

### Step 3: Find Your MySQL Root Password

Since we don't know your MySQL password, try these:

1. **Check if it's empty** (common for XAMPP/WAMP):
   - Try leaving password as `''` (empty string)
   - If that doesn't work, MySQL requires a password

2. **Common default passwords:**
   - Empty (no password)
   - `root`
   - `password`
   - `123456`

3. **Check MySQL installation:**
   - XAMPP: Usually no password by default
   - WAMP: Usually no password by default
   - Standalone MySQL: Check installation notes

4. **Reset the password** (if needed):
   - See `reset-mysql-password.ps1` script
   - Or use MySQL command line

### Step 4: Fix the 'pma' User Error

The error also mentions user 'pma' - this is for phpMyAdmin's advanced features. You can disable it:

**Find this section:**
```php
/* User for advanced features */
$cfg['Servers'][$i]['controluser'] = 'pma';
$cfg['Servers'][$i]['controlpass'] = '';
```

**Either:**
1. **Comment it out** (recommended if you don't need advanced features):
   ```php
   // $cfg['Servers'][$i]['controluser'] = 'pma';
   // $cfg['Servers'][$i]['controlpass'] = '';
   ```

2. **Or create the pma user** in MySQL (advanced)

### Step 5: Save and Test

1. Save the `config.inc.php` file
2. Refresh phpMyAdmin in your browser
3. You should now be able to connect

## Quick Fix Template

Here's what your config should look like (minimal setup):

```php
<?php
/* Server parameters */
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = '';  // ← Change this to your password
$cfg['Servers'][$i]['auth_type'] = 'config';

// Comment out controluser if you get pma errors
// $cfg['Servers'][$i]['controluser'] = 'pma';
// $cfg['Servers'][$i]['controlpass'] = '';
```

## Alternative: Use MySQL Command Line

If phpMyAdmin still doesn't work, you can manage MySQL via command line:

1. **Find MySQL executable:**
   - XAMPP: `C:\xampp\mysql\bin\mysql.exe`
   - WAMP: `C:\wamp64\bin\mysql\mysql[version]\bin\mysql.exe`

2. **Connect:**
   ```bash
   mysql -u root -p
   # Enter password when prompted
   ```

3. **Create database:**
   ```sql
   CREATE DATABASE bts_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

## Still Having Issues?

1. **Verify MySQL is running:**
   ```powershell
   netstat -an | findstr ":3306"
   ```
   Should show LISTENING

2. **Test connection with PHP:**
   ```bash
   php test-mysql.php
   ```

3. **Check MySQL error logs:**
   - XAMPP: `C:\xampp\mysql\data\*.err`
   - WAMP: Check MySQL logs in WAMP menu

4. **Try resetting MySQL password:**
   - Run `reset-mysql-password.ps1`

## Need Help?

If you can't find the config file or password:
1. Tell me where phpMyAdmin is installed
2. Or share the path to `config.inc.php`
3. I can help you update it directly

