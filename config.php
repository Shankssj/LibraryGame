<?php
try {
    $dsn = 'mysql:host=localhost;dbname=gaming_library;charset=utf8mb4';
    $username = 'root';
    $password = '';

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie<br>';

} catch (PDOException $e) {
    echo 'Err: ' . $e->getMessage();
}
