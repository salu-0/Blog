@echo off
echo ========================================
echo XAMPP MySQL Password Reset
echo ========================================
echo.

set MYSQL_DIR=C:\xampp\mysql\bin
set MYSQLD=%MYSQL_DIR%\mysqld.exe
set MYSQL=%MYSQL_DIR%\mysql.exe

echo Step 1: Please STOP MySQL in XAMPP Control Panel first!
echo Press any key after you have stopped MySQL...
pause >nul

echo.
echo Step 2: Enter NEW password for MySQL root (or press Enter for no password):
set /p NEW_PASSWORD="Password: "

echo.
echo Step 3: Creating reset SQL file...
echo ALTER USER 'root'@'localhost' IDENTIFIED BY '%NEW_PASSWORD%'; > %TEMP%\mysql_reset.sql
echo FLUSH PRIVILEGES; >> %TEMP%\mysql_reset.sql

echo.
echo Step 4: Starting MySQL with skip-grant-tables...
echo This will open a new window. Keep it open!
start "MySQL Reset" cmd /k "%MYSQLD% --skip-grant-tables --init-file=%TEMP%\mysql_reset.sql"

echo.
echo Waiting 5 seconds for MySQL to start...
timeout /t 5 /nobreak >nul

echo.
echo Step 5: Resetting password...
if "%NEW_PASSWORD%"=="" (
    "%MYSQL%" -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY ''; FLUSH PRIVILEGES;"
) else (
    "%MYSQL%" -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '%NEW_PASSWORD%'; FLUSH PRIVILEGES;"
)

echo.
echo Step 6: Closing MySQL reset window...
taskkill /FI "WindowTitle eq MySQL Reset*" /F >nul 2>&1

echo.
echo Step 7: Updating phpMyAdmin config...
powershell -Command "$config = Get-Content 'C:\xampp\phpMyAdmin\config.inc.php' -Raw; $config = $config -replace \"(\$cfg\['Servers'\]\[\$i\]\['password'\]\s*=\s*)['\`"][^'\`"]*['\`"];\", \"`$1'%NEW_PASSWORD%';\"; Set-Content 'C:\xampp\phpMyAdmin\config.inc.php' -Value $config -NoNewline"

echo.
echo Step 8: Updating Laravel .env...
powershell -Command "$env = Get-Content 'D:\blog\bts-blog\.env' -Raw; $env = $env -replace 'DB_CONNECTION=sqlite', 'DB_CONNECTION=mysql'; $env = $env -replace 'DB_DATABASE=database/database.sqlite', 'DB_DATABASE=bts_blog'; $env = $env -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=%NEW_PASSWORD%'; Set-Content 'D:\blog\bts-blog\.env' -Value $env -NoNewline"

echo.
echo ========================================
echo Password reset complete!
echo ========================================
echo.
echo IMPORTANT: Now restart MySQL from XAMPP Control Panel
echo.
echo Password has been set to: %NEW_PASSWORD%
echo Config files have been updated.
echo.
echo Test phpMyAdmin: http://localhost/phpmyadmin
echo.
pause

