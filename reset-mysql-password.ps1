# MySQL Root Password Reset Script
# This script helps reset MySQL root password

Write-Host "MySQL Root Password Reset" -ForegroundColor Cyan
Write-Host "=========================" -ForegroundColor Cyan
Write-Host ""

# Find MySQL installation
$mysqlPath = $null
$mysqldPath = $null
$possiblePaths = @(
    @{mysql = "C:\xampp\mysql\bin\mysql.exe"; mysqld = "C:\xampp\mysql\bin\mysqld.exe"},
    @{mysql = "C:\wamp64\bin\mysql\mysql*\bin\mysql.exe"; mysqld = "C:\wamp64\bin\mysql\mysql*\bin\mysqld.exe"},
    @{mysql = "C:\Program Files\MySQL\MySQL Server *\bin\mysql.exe"; mysqld = "C:\Program Files\MySQL\MySQL Server *\bin\mysqld.exe"},
    @{mysql = "C:\Program Files (x86)\MySQL\MySQL Server *\bin\mysql.exe"; mysqld = "C:\Program Files (x86)\MySQL\MySQL Server *\bin\mysqld.exe"}
)

foreach ($path in $possiblePaths) {
    $mysql = Get-ChildItem -Path $path.mysql -ErrorAction SilentlyContinue | Select-Object -First 1
    $mysqld = Get-ChildItem -Path $path.mysqld -ErrorAction SilentlyContinue | Select-Object -First 1
    if ($mysql -and $mysqld) {
        $mysqlPath = $mysql.FullName
        $mysqldPath = $mysqld.FullName
        break
    }
}

if (-not $mysqlPath) {
    Write-Host "ERROR: Could not find MySQL installation." -ForegroundColor Red
    Write-Host ""
    Write-Host "Manual Reset Instructions:" -ForegroundColor Yellow
    Write-Host "1. Stop MySQL service" -ForegroundColor White
    Write-Host "2. Start MySQL with --skip-grant-tables option" -ForegroundColor White
    Write-Host "3. Connect: mysql -u root" -ForegroundColor White
    Write-Host "4. Run: ALTER USER 'root'@'localhost' IDENTIFIED BY 'newpassword';" -ForegroundColor White
    Write-Host "5. Run: FLUSH PRIVILEGES;" -ForegroundColor White
    Write-Host "6. Restart MySQL normally" -ForegroundColor White
    exit 1
}

Write-Host "Found MySQL at: $mysqlPath" -ForegroundColor Green
Write-Host ""

# Prompt for new password
Write-Host "Enter NEW password for MySQL root user:" -ForegroundColor Yellow
$newPassword = Read-Host -AsSecureString
$newPasswordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($newPassword)
)

if ([string]::IsNullOrWhiteSpace($newPasswordPlain)) {
    Write-Host "Password cannot be empty. Exiting." -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "WARNING: This will reset MySQL root password." -ForegroundColor Yellow
Write-Host "Make sure MySQL service is stopped before proceeding." -ForegroundColor Yellow
Write-Host ""
$confirm = Read-Host "Continue? (y/n)"
if ($confirm -ne 'y' -and $confirm -ne 'Y') {
    Write-Host "Cancelled." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "To reset MySQL password, follow these steps:" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Stop MySQL service:" -ForegroundColor White
Write-Host "   - XAMPP: Stop MySQL from XAMPP Control Panel" -ForegroundColor Gray
Write-Host "   - WAMP: Stop MySQL from WAMP menu" -ForegroundColor Gray
Write-Host "   - Service: Stop-Service MySQL (or MySQL80, etc.)" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Create a SQL file with password reset commands:" -ForegroundColor White
$resetSql = @"
ALTER USER 'root'@'localhost' IDENTIFIED BY '$newPasswordPlain';
FLUSH PRIVILEGES;
"@
$resetFile = "D:\blog\bts-blog\mysql-reset.sql"
Set-Content -Path $resetFile -Value $resetSql
Write-Host "   Created: $resetFile" -ForegroundColor Green
Write-Host ""
Write-Host "3. Start MySQL with skip-grant-tables:" -ForegroundColor White
Write-Host "   $mysqldPath --skip-grant-tables --init-file=$resetFile" -ForegroundColor Gray
Write-Host ""
Write-Host "4. In another terminal, connect and verify:" -ForegroundColor White
Write-Host "   $mysqlPath -u root -p" -ForegroundColor Gray
Write-Host "   (Enter password: $newPasswordPlain)" -ForegroundColor Gray
Write-Host ""
Write-Host "5. Update Laravel .env file:" -ForegroundColor White
$envFile = "D:\blog\bts-blog\.env"
$envContent = Get-Content $envFile -Raw
$envContent = $envContent -replace "DB_PASSWORD=.*", "DB_PASSWORD=$newPasswordPlain"
Set-Content $envFile -Value $envContent -NoNewline
Write-Host "   Updated .env file with new password" -ForegroundColor Green
Write-Host ""
Write-Host "6. Restart MySQL normally" -ForegroundColor White
Write-Host ""
Write-Host "Alternative: Use phpMyAdmin or MySQL Workbench to reset password if available." -ForegroundColor Yellow

