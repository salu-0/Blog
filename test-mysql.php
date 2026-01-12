<?php
// Test MySQL connection with different password options

$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$passwords = ['', 'root', 'password', '123456'];

echo "Testing MySQL connection...\n";
echo "Host: $host:$port\n";
echo "User: $user\n\n";

foreach ($passwords as $password) {
    $displayPassword = $password === '' ? '(empty)' : $password;
    echo "Trying password: $displayPassword ... ";
    
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$port",
            $user,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        echo "SUCCESS!\n";
        echo "\n✓ Connection successful with password: $displayPassword\n";
        echo "\nUpdate your .env file with:\n";
        if ($password === '') {
            echo "DB_PASSWORD=\n";
        } else {
            echo "DB_PASSWORD=$password\n";
        }
        exit(0);
    } catch (PDOException $e) {
        echo "FAILED\n";
    }
}

echo "\n✗ None of the common passwords worked.\n";
echo "\nYou need to either:\n";
echo "1. Find your MySQL root password\n";
echo "2. Reset MySQL root password\n";
echo "3. Set a new password for MySQL root\n";
echo "\nSee MYSQL_SETUP.md for detailed instructions.\n";

