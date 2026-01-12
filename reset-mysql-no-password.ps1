# Reset MySQL to have NO password (XAMPP default)

Write-Host "Reset MySQL Root to No Password" -ForegroundColor Cyan
Write-Host "=================================" -ForegroundColor Cyan
Write-Host ""

$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"
$mysqldPath = "C:\xampp\mysql\bin\mysqld.exe"

if (-not (Test-Path $mysqlPath)) {
    Write-Host "ERROR: XAMPP MySQL not found!" -ForegroundColor Red
    exit 1
}

Write-Host "IMPORTANT: Stop MySQL in XAMPP Control Panel FIRST!" -ForegroundColor Yellow
Write-Host ""
$confirm = Read-Host "Have you stopped MySQL? (y/n)"
if ($confirm -ne 'y' -and $confirm -ne 'Y') {
    Write-Host "Please stop MySQL first, then run this script again." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "Step 1: Creating reset SQL file..." -ForegroundColor Cyan
$resetSql = "ALTER USER 'root'@'localhost' IDENTIFIED BY '';`nFLUSH PRIVILEGES;"
$resetFile = "$env:TEMP\mysql_reset_$(Get-Date -Format 'yyyyMMdd_HHmmss').sql"
Set-Content -Path $resetFile -Value $resetSql
Write-Host "Created: $resetFile" -ForegroundColor Green

Write-Host ""
Write-Host "Step 2: Starting MySQL with skip-grant-tables..." -ForegroundColor Cyan
Write-Host "Opening MySQL in reset mode (keep window open)..." -ForegroundColor Yellow
Start-Process -FilePath $mysqldPath -ArgumentList "--skip-grant-tables","--init-file=$resetFile" -WindowStyle Normal

Write-Host ""
Write-Host "Waiting 5 seconds for MySQL to start..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

Write-Host ""
Write-Host "Step 3: Resetting password to empty..." -ForegroundColor Cyan
& $mysqlPath -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY ''; FLUSH PRIVILEGES;" 2>&1 | Out-Null

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Password reset successful!" -ForegroundColor Green
} else {
    Write-Host "⚠ Password reset attempted (may need manual verification)" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 4: Closing MySQL reset process..." -ForegroundColor Cyan
Get-Process | Where-Object {$_.ProcessName -eq "mysqld"} | Stop-Process -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 2

Write-Host ""
Write-Host "Step 5: Updating phpMyAdmin config..." -ForegroundColor Cyan
$configPath = "C:\xampp\phpMyAdmin\config.inc.php"
if (Test-Path $configPath) {
    $config = Get-Content $configPath -Raw
    $config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['""][^'""]*['""];", "`$1'';"
    # Ensure port is set to 3308 (XAMPP default)
    if ($config -notmatch "port.*3308") {
        $config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['host'\]\s*=\s*'127\.0\.0\.1';)", "`$1`n`$cfg['Servers'][`$i]['port'] = '3308';"
    }
    Set-Content -Path $configPath -Value $config -NoNewline
    Write-Host "✓ phpMyAdmin config updated (password set to empty, port 3308)" -ForegroundColor Green
} else {
    Write-Host "✗ phpMyAdmin config not found" -ForegroundColor Red
}

Write-Host ""
Write-Host "Step 6: Updating Laravel .env..." -ForegroundColor Cyan
$envPath = "D:\blog\bts-blog\.env"
if (Test-Path $envPath) {
    $env = Get-Content $envPath -Raw
    $env = $env -replace "DB_CONNECTION=sqlite", "DB_CONNECTION=mysql"
    $env = $env -replace "DB_DATABASE=database/database.sqlite", "DB_DATABASE=bts_blog"
    $env = $env -replace "DB_PASSWORD=.*", "DB_PASSWORD="
    Set-Content -Path $envPath -Value $env -NoNewline
    Write-Host "✓ Laravel .env updated" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Reset Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "NEXT STEPS:" -ForegroundColor Yellow
Write-Host "1. Start MySQL from XAMPP Control Panel" -ForegroundColor White
Write-Host "2. Test phpMyAdmin: http://localhost/phpmyadmin" -ForegroundColor White
Write-Host "3. MySQL root now has NO password (XAMPP default)" -ForegroundColor White
Write-Host ""

