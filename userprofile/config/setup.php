<?php

require_once ('database.php');

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$pdo->query("DROP DATABASE IF EXISTS matcha;");

$pdo->query("CREATE DATABASE IF NOT EXISTS matcha;")
or die(print_r($pdo->errorInfo(), true));

$pdo->query("USE matcha;")
or die(print_r($pdo->errorInfo(), true));

$pdo->query("CREATE TABLE IF NOT EXISTS users(
         id INT AUTO_INCREMENT NOT NULL,
         firstname VARCHAR (60) NOT NULL,
         lastname VARCHAR (60) NOT NULL,
         email VARCHAR (60) NOT NULL UNIQUE ,
         username VARCHAR (60) NOT NULL,
         passwd VARCHAR (255) NOT NULL,
         active INT (1) NOT NULL  DEFAULT 0,
         code VARCHAR(255) NOT NULL,
         reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY (id));"
)
or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS photos(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT NOT NULL,
            upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            url TEXT NOT NULL,
            likes INT NOT NULL
           );")or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS profile(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT NOT NULL,
            profile_picture TEXT NOT NULL,
            gender VARCHAR(20) NOT NULL,
            age INT NOT NULL,
            agefrom INT NOT NULL,
            toage INT NOT NULL,
            sexual_preference TEXT NOT NULL,
            biography TEXT NOT NULL,
            interests TEXT NOT NULL,
            update_date DATETIME ,
            likes INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id)
           );")or die(print_r($pdo->errorInfo(), true));


$pdo->query("
           CREATE TABLE IF NOT EXISTS likes(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT NOT NULL,
            photo_id INT NOT NULL,
            proto_url TEXT NOT NULL,
            upload_date DATETIME ,
            FOREIGN KEY (user_id) REFERENCES users(id)
           );")or die(print_r($pdo->errorInfo(), true));

?>
