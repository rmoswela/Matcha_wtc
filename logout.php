<?php
session_start();

  $_SESSION['username'] = "";
  unset($_SESSION['username']);
  header("Location: login.php");
  $_SESSION['logged-out'] = true;

?>
