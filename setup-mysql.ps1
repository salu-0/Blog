# MySQL Setup Script for Laravel Blog
# This script helps set up MySQL for your Laravel project

Write-Host "MySQL Setup for Laravel Blog" -ForegroundColor Cyan
Write-Host "=============================" -ForegroundColor Cyan
Write-Host ""

# Check if MySQL is running
$mysqlRunning = netstat -an | findstr ":3306"
if (-not $mysqlRunning) {
    Write-Host "ERROR: MySQL is not running on port 3306" -ForegroundColor Red
    Write-Host "Please start MySQL service first." -ForegroundColor Yellow
    exit 1
}

Write-Host "MySQL is running on port 3306" -ForegroundColor Green
Write-Host ""

# Prompt for MySQL root password
Write-Host "Enter MySQL root password (press Enter if no password):" -ForegroundColor Yellow
$mysqlPassword = Read-Host -AsSecureString
$mysqlPasswordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($mysqlPassword)
)

# Try to find MySQL executable
$mysqlPath = $null
$possiblePaths = @(
    "C:\xampp\mysql\bin\mysql.exe",
    "C:\wamp64\bin\mysql\mysql*\bin\mysql.exe",
    "C:\Program Files\MySQL\MySQL Server *\bin\mysql.exe",
    "C:\Program Files (x86)\MySQL\MySQL Server *\bin\mysql.exe"
)

foreach ($path in $possiblePaths) {
    $found = Get-ChildItem -Path $path -ErrorAction SilentlyContinue | Select-Object -First 1
    if ($found) {
        $mysqlPath = $found.FullName
        break
    }
}

if (-not $mysqlPath) {
    Write-Host "WARNING: Could not find MySQL executable automatically." -ForegroundColor Yellow
    Write-Host "Please manually create the database 'bts_blog' using phpMyAdmin or MySQL Workbench." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "To fix phpMyAdmin:" -ForegroundColor Cyan
    Write-Host "1. Find your phpMyAdmin config.inc.php file" -ForegroundColor White
    Write-Host "2. Update these lines:" -ForegroundColor White
    Write-Host "   `$cfg['Servers'][1]['user'] = 'root';" -ForegroundColor Gray
    Write-Host "   `$cfg['Servers'][1]['password'] = 'YOUR_PASSWORD';" -ForegroundColor Gray
    Write-Host ""
    
    # Update .env with the password
    if ($mysqlPasswordPlain) {
        $envContent = Get-Content "D:\blog\bts-blog\.env" -Raw
        $envContent = $envContent -replace "DB_PASSWORD=", "DB_PASSWORD=$mysqlPasswordPlain"
        Set-Content "D:\blog\bts-blog\.env" -Value $envContent -NoNewline
        Write-Host "Updated .env file with password" -ForegroundColor Green
    }
    exit 0
}

Write-Host "Found MySQL at: $mysqlPath" -ForegroundColor Green
Write-Host ""

# Create database
Write-Host "Creating database 'bts_blog'..." -ForegroundColor Yellow
if ($mysqlPasswordPlain) {
    & $mysqlPath -u root -p"$mysqlPasswordPlain" -e "CREATE DATABASE IF NOT EXISTS bts_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1
} else {
    & $mysqlPath -u root -e "CREATE DATABASE IF NOT EXISTS bts_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1
}

if ($LASTEXITCODE -eq 0) {
    Write-Host "Database 'bts_blog' created successfully!" -ForegroundColor Green
} else {
    Write-Host "Failed to create database. You may need to create it manually." -ForegroundColor Red
}

# Update .env file
Write-Host ""
Write-Host "Updating .env file..." -ForegroundColor Yellow
$envFile = "D:\blog\bts-blog\.env"
$envContent = Get-Content $envFile -Raw

if ($mysqlPasswordPlain) {
    $envContent = $envContent -replace "DB_PASSWORD=", "DB_PASSWORD=$mysqlPasswordPlain"
} else {
    $envContent = $envContent -replace "DB_PASSWORD=.*", "DB_PASSWORD="
}

Set-Content $envFile -Value $envContent -NoNewline
Write-Host ".env file updated!" -ForegroundColor Green

Write-Host ""
Write-Host "Setup complete! Next steps:" -ForegroundColor Cyan
Write-Host "1. If you're using phpMyAdmin, update config.inc.php with the same password" -ForegroundColor White
Write-Host "2. Run: php artisan migrate" -ForegroundColor White
Write-Host "3. Test connection: php artisan migrate:status" -ForegroundColor White

