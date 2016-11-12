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
         username VARCHAR (60) NOT NULL UNIQUE,
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
            url TEXT NOT NULL, FOREIGN KEY(user_id) REFERENCES users(id)
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS profile(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT NOT NULL,
            profile_pic TEXT NOT NULL,
            gender VARCHAR(20) NOT NULL,
            age INT NOT NULL,
            agefrom INT NOT NULL,
            toage INT NOT NULL,
            sexual_pref TEXT NOT NULL,
            biography TEXT NOT NULL,
            interests TEXT NOT NULL,
            update_date DATETIME ,
            fame INT NOT NULL,
	    notif INT NOT NULL,
	    views INT NOT NULL,
            likes INT NOT NULL,
			location TEXT,
			FOREIGN KEY(user_id) REFERENCES users(id)
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS likes(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            liker_id INT NOT NULL,
            liked_id INT NOT NULL,
			liked_date DATETIME DEFAULT CURRENT_TIMESTAMP
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS views(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           viewer_id INT NOT NULL,
           viewed_id INT NOT NULL,
           view_date DATETIME DEFAULT CURRENT_TIMESTAMP
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
           CREATE TABLE IF NOT EXISTS notifications(
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            type VARCHAR(100) NOT NULL,
            from_user_id INT NOT NULL,
            to_user_id INT NOT NULL,
            status INT DEFAULT 0,
		notification_msg TEXT NOT NULL,
			notification_date DATETIME DEFAULT CURRENT_TIMESTAMP,
			FOREIGN KEY(from_user_id) REFERENCES users(id),
			FOREIGN KEY(to_user_id) REFERENCES users(id)
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS messages(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           to_user_id INT NOT NULL,
           from_user_id INT NOT NULL,
           message TEXT,
           message_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		   FOREIGN KEY(to_user_id) REFERENCES users(id),
			FOREIGN KEY(from_user_id) REFERENCES users(id)
		);")
		or die(print_r($pdo->errorInfo(), true));

$pdo->query("
          CREATE TABLE IF NOT EXISTS blocking(
           id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
           user_id INT NOT NULL,
           blocked INT NOT NULL,
		   block_date DATETIME DEFAULT CURRENT_TIMESTAMP,
		   FOREIGN KEY(user_id) REFERENCES users(id)
	   );")
	   or die(print_r($pdo->errorInfo(), true));
?>
