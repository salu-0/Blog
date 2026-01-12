# Find phpMyAdmin Installation Script

Write-Host "Searching for phpMyAdmin installation..." -ForegroundColor Cyan
Write-Host ""

$found = $false
$searchPaths = @(
    "C:\xampp\phpMyAdmin",
    "C:\wamp64\apps\phpmyadmin*",
    "C:\wamp\apps\phpmyadmin*",
    "C:\Program Files\phpMyAdmin",
    "C:\Program Files (x86)\phpMyAdmin",
    "C:\phpMyAdmin",
    "C:\inetpub\wwwroot\phpmyadmin",
    "C:\inetpub\wwwroot\phpMyAdmin"
)

foreach ($path in $searchPaths) {
    $items = Get-ChildItem -Path $path -ErrorAction SilentlyContinue
    if ($items) {
        foreach ($item in $items) {
            $configFile = Join-Path $item.FullName "config.inc.php"
            if (Test-Path $configFile) {
                Write-Host "✓ Found phpMyAdmin at: $($item.FullName)" -ForegroundColor Green
                Write-Host "  Config file: $configFile" -ForegroundColor Yellow
                Write-Host ""
                $found = $true
                
                # Show current configuration
                Write-Host "Current configuration:" -ForegroundColor Cyan
                $config = Get-Content $configFile
                $userLine = $config | Select-String "Servers.*user"
                $passLine = $config | Select-String "Servers.*password"
                
                if ($userLine) {
                    Write-Host "  $userLine" -ForegroundColor White
                }
                if ($passLine) {
                    $displayPass = $passLine -replace "password.*=.*['\"](.*)['\"]", "password = '***'"
                    Write-Host "  $displayPass" -ForegroundColor White
                }
                Write-Host ""
            }
        }
    }
}

if (-not $found) {
    Write-Host "✗ phpMyAdmin not found in common locations." -ForegroundColor Red
    Write-Host ""
    Write-Host "Please provide the path to your phpMyAdmin installation, or:" -ForegroundColor Yellow
    Write-Host "1. Check your web server document root" -ForegroundColor White
    Write-Host "2. Check where you installed phpMyAdmin" -ForegroundColor White
    Write-Host "3. Look for 'config.inc.php' file manually" -ForegroundColor White
}

Write-Host ""
Write-Host "To fix phpMyAdmin, you need to:" -ForegroundColor Cyan
Write-Host "1. Find config.inc.php file" -ForegroundColor White
Write-Host "2. Update the password line:" -ForegroundColor White
Write-Host "   `$cfg['Servers'][1]['password'] = 'YOUR_MYSQL_PASSWORD';" -ForegroundColor Gray
Write-Host "3. If MySQL root has no password, use: ''" -ForegroundColor White

