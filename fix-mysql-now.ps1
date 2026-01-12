# Direct MySQL Password Fix for XAMPP

Write-Host "XAMPP MySQL Password Fix" -ForegroundColor Cyan
Write-Host "========================" -ForegroundColor Cyan
Write-Host ""

$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"
$mysqldPath = "C:\xampp\mysql\bin\mysqld.exe"

if (-not (Test-Path $mysqlPath)) {
    Write-Host "ERROR: XAMPP MySQL not found!" -ForegroundColor Red
    exit 1
}

Write-Host "Option 1: Use XAMPP Security Page (EASIEST)" -ForegroundColor Yellow
Write-Host "===========================================" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Open: http://localhost/security/" -ForegroundColor White
Write-Host "2. Set MySQL root password there" -ForegroundColor White
Write-Host "3. Then run this script again with: -Password 'your_password'" -ForegroundColor White
Write-Host ""
Write-Host "Opening security page now..." -ForegroundColor Cyan
Start-Process "http://localhost/security/"
Write-Host ""
Write-Host "Press any key after you've set the password in the security page..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

Write-Host ""
Write-Host "Enter the password you just set:" -ForegroundColor Cyan
$password = Read-Host -AsSecureString
$passwordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($password)
)

Write-Host ""
Write-Host "Updating phpMyAdmin config..." -ForegroundColor Yellow
$configPath = "C:\xampp\phpMyAdmin\config.inc.php"
if (Test-Path $configPath) {
    $config = Get-Content $configPath -Raw
    $config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['""][^'""]*['""];", "`$1'$passwordPlain';"
    Set-Content -Path $configPath -Value $config -NoNewline
    Write-Host "✓ phpMyAdmin config updated" -ForegroundColor Green
} else {
    Write-Host "✗ phpMyAdmin config not found" -ForegroundColor Red
}

Write-Host ""
Write-Host "Updating Laravel .env..." -ForegroundColor Yellow
$envPath = "D:\blog\bts-blog\.env"
if (Test-Path $envPath) {
    $env = Get-Content $envPath -Raw
    $env = $env -replace "DB_CONNECTION=sqlite", "DB_CONNECTION=mysql"
    $env = $env -replace "DB_DATABASE=database/database.sqlite", "DB_DATABASE=bts_blog"
    $env = $env -replace "DB_PASSWORD=.*", "DB_PASSWORD=$passwordPlain"
    Set-Content -Path $envPath -Value $env -NoNewline
    Write-Host "✓ Laravel .env updated" -ForegroundColor Green
} else {
    Write-Host "✗ Laravel .env not found" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Configuration updated!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Test phpMyAdmin: http://localhost/phpmyadmin" -ForegroundColor Cyan
Write-Host "Password set to: $passwordPlain" -ForegroundColor White
Write-Host ""

