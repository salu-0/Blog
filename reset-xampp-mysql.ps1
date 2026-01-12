# Reset XAMPP MySQL Root Password

Write-Host "XAMPP MySQL Password Reset" -ForegroundColor Cyan
Write-Host "=========================" -ForegroundColor Cyan
Write-Host ""

$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"
$mysqldPath = "C:\xampp\mysql\bin\mysqld.exe"

if (-not (Test-Path $mysqlPath)) {
    Write-Host "ERROR: XAMPP MySQL not found at expected location." -ForegroundColor Red
    Write-Host "Expected: C:\xampp\mysql\bin\" -ForegroundColor Yellow
    exit 1
}

Write-Host "Found XAMPP MySQL installation" -ForegroundColor Green
Write-Host ""

# Prompt for new password
Write-Host "Enter NEW password for MySQL root user (or press Enter for no password):" -ForegroundColor Yellow
$newPassword = Read-Host -AsSecureString
$newPasswordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($newPassword)
)

Write-Host ""
Write-Host "WARNING: This will reset MySQL root password." -ForegroundColor Yellow
Write-Host "Make sure MySQL is STOPPED in XAMPP Control Panel first!" -ForegroundColor Red
Write-Host ""
$confirm = Read-Host "Have you stopped MySQL? Continue? (y/n)"
if ($confirm -ne 'y' -and $confirm -ne 'Y') {
    Write-Host "Cancelled. Please stop MySQL first, then run this script again." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "Step 1: Creating password reset SQL file..." -ForegroundColor Cyan
$resetSql = @"
ALTER USER 'root'@'localhost' IDENTIFIED BY '$newPasswordPlain';
FLUSH PRIVILEGES;
"@
$resetFile = "C:\xampp\mysql-reset-$(Get-Date -Format 'yyyyMMdd_HHmmss').sql"
Set-Content -Path $resetFile -Value $resetSql
Write-Host "Created: $resetFile" -ForegroundColor Green

Write-Host ""
Write-Host "Step 2: Starting MySQL with skip-grant-tables..." -ForegroundColor Cyan
Write-Host "Run this command in a NEW terminal window (keep it open):" -ForegroundColor Yellow
Write-Host "  $mysqldPath --skip-grant-tables --init-file=$resetFile" -ForegroundColor White
Write-Host ""
Write-Host "Step 3: In another terminal, connect and verify:" -ForegroundColor Cyan
if ([string]::IsNullOrWhiteSpace($newPasswordPlain)) {
    Write-Host "  $mysqlPath -u root" -ForegroundColor White
} else {
    Write-Host "  $mysqlPath -u root -p" -ForegroundColor White
    Write-Host "  (Enter password: $newPasswordPlain)" -ForegroundColor Gray
}
Write-Host ""

# Update phpMyAdmin config
Write-Host "Step 4: Updating phpMyAdmin config..." -ForegroundColor Cyan
$phpmyadminConfig = "C:\xampp\phpMyAdmin\config.inc.php"
if (Test-Path $phpmyadminConfig) {
    $config = Get-Content $phpmyadminConfig -Raw
    $config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['""][^'""]*['""];", "`$1'$newPasswordPlain';"
    Set-Content -Path $phpmyadminConfig -Value $config -NoNewline
    Write-Host "Updated: $phpmyadminConfig" -ForegroundColor Green
} else {
    Write-Host "Warning: phpMyAdmin config not found at: $phpmyadminConfig" -ForegroundColor Yellow
}

# Update Laravel .env
Write-Host ""
Write-Host "Step 5: Updating Laravel .env..." -ForegroundColor Cyan
$envFile = "D:\blog\bts-blog\.env"
if (Test-Path $envFile) {
    $envContent = Get-Content $envFile -Raw
    $envContent = $envContent -replace "DB_CONNECTION=sqlite", "DB_CONNECTION=mysql"
    $envContent = $envContent -replace "DB_DATABASE=database/database.sqlite", "DB_DATABASE=bts_blog"
    $envContent = $envContent -replace "DB_PASSWORD=.*", "DB_PASSWORD=$newPasswordPlain"
    Set-Content -Path $envFile -Value $envContent -NoNewline
    Write-Host "Updated: $envFile" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "IMPORTANT: Follow these steps manually:" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Stop MySQL in XAMPP Control Panel" -ForegroundColor White
Write-Host "2. Open a NEW PowerShell window as Administrator" -ForegroundColor White
Write-Host "3. Run: $mysqldPath --skip-grant-tables --init-file=$resetFile" -ForegroundColor Yellow
Write-Host "   (Keep this window open)" -ForegroundColor Gray
Write-Host "4. In another terminal, test connection:" -ForegroundColor White
if ([string]::IsNullOrWhiteSpace($newPasswordPlain)) {
    Write-Host "   $mysqlPath -u root -e `"SELECT 1;`"" -ForegroundColor Yellow
} else {
    Write-Host "   $mysqlPath -u root -p$newPasswordPlain -e `"SELECT 1;`"" -ForegroundColor Yellow
}
Write-Host "5. Close the mysqld window and restart MySQL normally from XAMPP" -ForegroundColor White
Write-Host "6. Test phpMyAdmin in browser" -ForegroundColor White
Write-Host ""
Write-Host "Password has been set to: " -NoNewline -ForegroundColor Cyan
if ([string]::IsNullOrWhiteSpace($newPasswordPlain)) {
    Write-Host "(empty - no password)" -ForegroundColor White
} else {
    Write-Host "$newPasswordPlain" -ForegroundColor White
}
Write-Host ""
Write-Host "Config files have been updated with this password." -ForegroundColor Green

