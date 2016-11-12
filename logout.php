<?php
session_start();
require_once "db_object.php";

try {
  $uname = htmlspecialchars(trim($_SESSION['username']));
  $conn = $start->server_connect();
  $conn->query("UPDATE users SET online = 0 WHERE username = '".$uname."'");
  $_SESSION['username'] = "";
  unset($_SESSION['username']);
  header("Location: login.php");
  $_SESSION['logged-out'] = true;
}
catch (PDOException $e)
{
  $start->__setReport($e->getMessage());
  print $start->__getReport();
}
$conn = null;

?>
