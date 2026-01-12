# Auto-fix phpMyAdmin by testing passwords and updating config

Write-Host "Auto-Fix phpMyAdmin Password" -ForegroundColor Cyan
Write-Host "============================" -ForegroundColor Cyan
Write-Host ""

$configPath = "C:\xampp\phpMyAdmin\config.inc.php"
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

if (-not (Test-Path $configPath)) {
    Write-Host "ERROR: phpMyAdmin config not found!" -ForegroundColor Red
    exit 1
}

Write-Host "Testing common MySQL passwords..." -ForegroundColor Yellow
Write-Host ""

$passwords = @("", "root", "password", "123456", "admin", "xampp")
$found = $false

foreach ($pwd in $passwords) {
    $displayPwd = if ($pwd -eq "") { "(empty)" } else { $pwd }
    Write-Host "Testing: $displayPwd ... " -NoNewline
    
    $success = $false
    
    if ($pwd -eq "") {
        $null = & $mysqlPath -u root -e "SELECT 1;" 2>&1
        if ($LASTEXITCODE -eq 0) {
            $success = $true
        }
    } else {
        $null = & $mysqlPath -u root -p"$pwd" -e "SELECT 1;" 2>&1
        if ($LASTEXITCODE -eq 0) {
            $success = $true
        }
    }
    
    if ($success) {
        Write-Host "SUCCESS!" -ForegroundColor Green
        Write-Host ""
        Write-Host "Found working password: $displayPwd" -ForegroundColor Green
        Write-Host ""
        Write-Host "Updating phpMyAdmin config..." -ForegroundColor Yellow
        
        $config = Get-Content $configPath -Raw
        $config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['""][^'""]*['""];", "`$1'$pwd';"
        Set-Content -Path $configPath -Value $config -NoNewline
        
        Write-Host "✓ phpMyAdmin config updated!" -ForegroundColor Green
        Write-Host ""
        Write-Host "Updating Laravel .env..." -ForegroundColor Yellow
        
        $envPath = "D:\blog\bts-blog\.env"
        if (Test-Path $envPath) {
            $env = Get-Content $envPath -Raw
            $env = $env -replace "DB_CONNECTION=sqlite", "DB_CONNECTION=mysql"
            $env = $env -replace "DB_DATABASE=database/database.sqlite", "DB_DATABASE=bts_blog"
            $env = $env -replace "DB_PASSWORD=.*", "DB_PASSWORD=$pwd"
            Set-Content -Path $envPath -Value $env -NoNewline
            Write-Host "✓ Laravel .env updated!" -ForegroundColor Green
        }
        
        Write-Host ""
        Write-Host "========================================" -ForegroundColor Green
        Write-Host "SUCCESS! Configuration updated!" -ForegroundColor Green
        Write-Host "========================================" -ForegroundColor Green
        Write-Host ""
        Write-Host "Test phpMyAdmin: http://localhost/phpmyadmin" -ForegroundColor Cyan
        Write-Host "Password: $displayPwd" -ForegroundColor White
        $found = $true
        break
    } else {
        Write-Host "FAILED" -ForegroundColor Red
    }
}

if (-not $found) {
    Write-Host ""
    Write-Host "✗ None of the common passwords worked." -ForegroundColor Red
    Write-Host ""
    Write-Host "You need to reset MySQL password:" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "EASIEST METHOD:" -ForegroundColor Cyan
    Write-Host "1. Go to: http://localhost/security/" -ForegroundColor White
    Write-Host "2. Set MySQL root password" -ForegroundColor White
    Write-Host "3. Run: .\fix-mysql-now.ps1" -ForegroundColor White
    Write-Host ""
    Write-Host "OR use batch file:" -ForegroundColor Cyan
    Write-Host "  .\reset-mysql-simple.bat" -ForegroundColor White
    Write-Host ""
}
