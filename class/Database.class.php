<?php

class Database
{
  private $report;
  private $DB_DSN;
  private $DB_USER;
  private $DB_PASSWORD;

  function __construct($DB_DSN, $DB_USER, $DB_PASSWORD)
  {
    $this->DB_DSN = $DB_DSN;
    $this->DB_USER = $DB_USER;
    $this->DB_PASSWORD = $DB_PASSWORD;
  }

  function __setReport($message)
  {
    $this->report = $message;
  }

  function __getReport()
  {
    return ($this->report);
  }

  function server_connect()
  {
    $conn = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
    try
    {
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->report = "connection success<br>";
    }
    catch(PDOException $error) {
        $this->report = $error->getMessage();
    }
    return ($conn);
  }

  function dropdb($conn)
  {
    $sql = "DROP DATABASE IF EXISTS accounts";
    if ($conn->query($sql))
      return TRUE;
    return FALSE;
  }

  function insert($conn, $tb_name, $sql_query)
  {
    $sql = $conn->prepare($sql_query);
    $sql->bindParam(":table", $tb_name);
    if ($sql->execute())
    {
      $this->report = "data inserted successfully";
      print $this->__getReport();
    }
    else
      $this->report = "insertion error: ". $sql_query;
      print $this->__getReport();
  }

  function create_schema($pdo)
  {
<<<<<<< HEAD
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
             password VARCHAR (255) NOT NULL,
             active INT (1) NOT NULL  DEFAULT 0,
             code VARCHAR(255) NOT NULL,
             online INT NOT NULL DEFAULT 0,
             last_seen DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
             reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
             PRIMARY KEY (id));"
    )
    or die(print_r($pdo->errorInfo(), true));
    try {
    $pdo->query("CREATE TABLE IF NOT EXISTS photos(
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                user_id INT NOT NULL,
                upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                url TEXT NOT NULL
               );")or die(print_r($pdo->errorInfo(), true));
=======
    $sql  = "CREATE DATABASE IF NOT EXISTS db_vicinity;USE db_vicinity;";
    if ($conn->query($sql))
    {
      $this->report = "Database created successfully<br>";
      print $this->__getReport();
    }
    else
    {
      $this->report = "couldn't create DATABASE<br>";
      print $this->__getReport();
      return;
    }
    $sql  = "CREATE TABLE IF NOT EXISTS users(
	        `user_id`	 INT(8) PRIMARY KEY AUTO_INCREMENT NOT NULL,
          `active` INT(1) NOT NULL DEFAULT 0,
          `signed-in` INT(1) NOT NULL DEFAULT 0,
	        `firstname` VARCHAR(255) NOT NULL,
	        `lastname`  VARCHAR(255) NOT NULL,
	        `username` 	 VARCHAR(80),
	        `email` VARCHAR(80) NOT NULL,
	        `password` VARCHAR(255) NOT NULL,
          `gender` VARCHAR(25),
          `interests` VARCHAR(255),
          `sex-preference` VARCHAR(80),
          `biography` TEXT)";


    $profile_sql  = "CREATE TABLE IF NOT EXISTS users(
	        `user_id`	 INT(8) PRIMARY KEY AUTO_INCREMENT NOT NULL,
          `gender` VARCHAR(25),
          `interests` VARCHAR(255),
          `sex-preference` VARCHAR(80),
          `biography` TEXT)";

    try
    {
      if ($conn->query($sql))
      {
        $this->report = "Users table created successfully<br>";
        print $this->__getReport();
      }
      else
      {
        $this->report = "couldn't create table<br>";
        print $this->__getReport();
      }

      //Create table for profile
      if ($conn->query($profile_sql))
      {
        $this->report = "Users table created successfully<br>";
        print $this->__getReport();
      }
      else
      {
        $this->report = "couldn't create table<br>";
        print $this->__getReport();
      }
    }
    catch(PDOException $error)
    {
      $this->report = $error->getMessage();
      print $this->__getReport();
    }
>>>>>>> origin/mohale

    $pdo->query("CREATE TABLE IF NOT EXISTS profile(
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
         		location TEXT
            );")or die(print_r($pdo->errorInfo(), true));

    $pdo->query("CREATE TABLE IF NOT EXISTS likes(
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                likes_id INT NOT NULL,
                liked_id INT NOT NULL,
                liked_date DATETIME DEFAULT CURRENT_TIMESTAMP
               );")or die(print_r($pdo->errorInfo(), true));

    $pdo->query("CREATE TABLE IF NOT EXISTS views(
               id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
               username VARCHAR(200),
               profile_id INT NOT NULL,
               view_date DATETIME DEFAULT CURRENT_TIMESTAMP,
               notified VARCHAR(10) NOT NULL
              );")or die(print_r($pdo->errorInfo(), true));

    $pdo->query("CREATE TABLE IF NOT EXISTS notifications(
              id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
              `type` VARCHAR(100) NOT NULL,
              `from` INT NOT NULL,
              `to` INT NOT NULL,
              `status` INT DEFAULT 0,
              notification_date DATETIME DEFAULT CURRENT_TIMESTAMP
              );")or die(print_r($pdo->errorInfo(), true));

    $pdo->query("CREATE TABLE IF NOT EXISTS messages(
               id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
               to_user_id INT NOT NULL,
               from_user_id INT NOT NULL,
               message TEXT,
               message_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    		       FOREIGN KEY(to_user_id) REFERENCES users(id),
    			     FOREIGN KEY(from_user_id) REFERENCES users(id)
    		      );")or die(print_r($pdo->errorInfo(), true));

    $pdo->query("CREATE TABLE IF NOT EXISTS blocking(
               id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
               user_id INT NOT NULL,
               blocked INT NOT NULL,
               block_date DATETIME DEFAULT CURRENT_TIMESTAMP
             );")or die(print_r($pdo->errorInfo(), true));
           } catch (PDOException $e) {
      print $e->getMessage();
    }
    $conn = null;
  }
}

?>
