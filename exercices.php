<?php

    $createTable = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255 ) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        passwd VARCHAR(255) NOT NULL,
        createAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP); ";


    $name = "amad khaly";
    $email = "amad@laplateforme.io";
    $mdp = "123456789";

    try {

        $pdo = new PDO("mysql:host=localhost;dbname=jour09", "root", "");

        //$pdo->exec($createTable);

        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //$adduser = "INSERT INTO users ( nom,email,passwd) VALUE (?,?,?)";
        //$stmt = $pdo->prepare($adduser);

        //$stmt->execute([$name,$email,$mdp]);

        //get user 
        $getUsers = "SELECT * FROM users";
        $stmt = $pdo->query($getUsers);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($users[0]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }