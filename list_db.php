<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
// Try empty and 'root' as passwords
foreach (['', 'root'] as $pass) {
    try {
        $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
        $stmt = $pdo->query("SHOW DATABASES");
        echo "Found databases with password '$pass':\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo " - " . $row['Database'] . "\n";
        }
    } catch (Exception $e) {
        echo "Failed with password '$pass': " . $e->getMessage() . "\n";
    }
}
