<?php
session_start();

$_SESSION['username'] = "";
unset($_SESSION['username']);
header("Location: login.php");

?>
