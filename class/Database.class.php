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

  function whoami()
  {
    print "Database class<br>";
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

  function create_schema($conn)
  {
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
    }
    catch(PDOException $error)
    {
      $this->report = $error->getMessage();
      print $this->__getReport();
    }

    $conn = null;
  }
}

?>
