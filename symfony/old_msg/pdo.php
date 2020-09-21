<?php
    $host = "127.0.0.1";
    $user = "root";
    $pass = "!Q2w3e4R";
    $db = "message";
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $conn = new PDO($dsn, $user, $pass);
?>
