<?php
$host = "localhost";
$db = "moduleconnexion";
$user = "root";
$password = "";


$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
