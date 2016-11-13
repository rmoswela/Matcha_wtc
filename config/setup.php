<?php

require_once ('database.php');

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$pdo->query("DROP DATABASE IF EXISTS db_vicinity;");

$pdo->query("CREATE DATABASE IF NOT EXISTS db_vicinity;")
or die(print_r($pdo->errorInfo(), true));

$pdo->query("USE db_vicinity;")
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
         online INT NOT NULL DEFAULT 0,
         last_seen DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
         reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY (id));"
)
or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS photos(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT NOT NULL,
            upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            url TEXT NOT NULL
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
            update_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            fame INT NOT NULL,
            likes INT NOT NULL,
            location TEXT
           );")or die(print_r($pdo->errorInfo(), true));


$pdo->query("
           CREATE TABLE IF NOT EXISTS likes(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            likes_id INT NOT NULL,
            liked_id INT NOT NULL,
            liked_date DATETIME DEFAULT CURRENT_TIMESTAMP
           );")or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS views(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           username VARCHAR(200),
           profile_id INT NOT NULL,
           view_date DATETIME DEFAULT CURRENT_TIMESTAMP,
           notified VARCHAR(10) NOT NULL
          );")or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS notifications(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            type VARCHAR(100) NOT NULL,
            from_id INT NOT NULL,
            to_id INT NOT NULL,
            status INT NOT NULL,
            notification_date DATETIME DEFAULT CURRENT_TIMESTAMP
           );")or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS messages(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           to_id INT NOT NULL,
           from_id INT NOT NULL,
           message TEXT,
           message_date DATETIME DEFAULT CURRENT_TIMESTAMP
          );")or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS blocking(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           user_id INT NOT NULL,
           blocked INT NOT NULL,
           block_date DATETIME DEFAULT CURRENT_TIMESTAMP
          );")or die(print_r($pdo->errorInfo(), true));
?>
