# Update phpMyAdmin Configuration Script

param(
    [string]$ConfigPath = "",
    [string]$Password = ""
)

Write-Host "phpMyAdmin Configuration Updater" -ForegroundColor Cyan
Write-Host "=================================" -ForegroundColor Cyan
Write-Host ""

# If config path not provided, search for it
if ([string]::IsNullOrEmpty($ConfigPath)) {
    Write-Host "Searching for config.inc.php..." -ForegroundColor Yellow
    
    $searchPaths = @(
        "C:\xampp\phpMyAdmin\config.inc.php",
        "C:\wamp64\apps\phpmyadmin*\config.inc.php",
        "C:\wamp\apps\phpmyadmin*\config.inc.php",
        "C:\Program Files\phpMyAdmin\config.inc.php",
        "C:\phpMyAdmin\config.inc.php",
        "C:\inetpub\wwwroot\phpmyadmin\config.inc.php"
    )
    
    foreach ($path in $searchPaths) {
        $found = Get-ChildItem -Path $path -ErrorAction SilentlyContinue | Select-Object -First 1
        if ($found) {
            $ConfigPath = $found.FullName
            break
        }
    }
}

if ([string]::IsNullOrEmpty($ConfigPath) -or -not (Test-Path $ConfigPath)) {
    Write-Host "ERROR: config.inc.php not found!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please provide the path to config.inc.php:" -ForegroundColor Yellow
    Write-Host "  .\update-phpmyadmin-config.ps1 -ConfigPath 'C:\path\to\config.inc.php' -Password 'your_password'" -ForegroundColor White
    Write-Host ""
    Write-Host "Or search manually for 'config.inc.php' in your phpMyAdmin folder." -ForegroundColor White
    exit 1
}

Write-Host "Found config file: $ConfigPath" -ForegroundColor Green
Write-Host ""

# Backup original
$backupPath = "$ConfigPath.backup.$(Get-Date -Format 'yyyyMMdd_HHmmss')"
Copy-Item $ConfigPath $backupPath
Write-Host "Backup created: $backupPath" -ForegroundColor Green
Write-Host ""

# Read config
$config = Get-Content $ConfigPath -Raw

# Update password
if ([string]::IsNullOrEmpty($Password)) {
    Write-Host "No password provided. Setting to empty string (no password)." -ForegroundColor Yellow
    $Password = ""
}

# Update password line
$config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['""][^'""]*['""];", "`$1'$Password';"

# Comment out controluser if it exists (to avoid pma errors)
$config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['controluser'\])", "// `$1"
$config = $config -replace "(\$cfg\['Servers'\]\[\$i\]\['controlpass'\])", "// `$1"

# Write updated config
Set-Content -Path $ConfigPath -Value $config -NoNewline

Write-Host "Configuration updated successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "Changes made:" -ForegroundColor Cyan
Write-Host "  - Updated MySQL root password" -ForegroundColor White
Write-Host "  - Commented out controluser (pma) to avoid errors" -ForegroundColor White
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Refresh phpMyAdmin in your browser" -ForegroundColor White
Write-Host "2. You should now be able to connect" -ForegroundColor White
Write-Host "3. If it still doesn't work, the password might be incorrect" -ForegroundColor White
Write-Host "   Run: php test-mysql.php to find the correct password" -ForegroundColor Gray

