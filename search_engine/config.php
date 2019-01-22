<?php
ob_start();

try {

    $pdo = new PDO("mysql:dbname=search_me;host=localhost", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}catch(PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
?>
