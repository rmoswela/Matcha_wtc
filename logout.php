<?php
session_start();

if ($_SESSION['logged-out'] = false)
{
  $_SESSION['username'] = "";
  unset($_SESSION['username']);
  header("Location: login.php");
  $_SESSION['logged-out'] = true;
}
else
{
  header("Location: index.php");
}
?>
