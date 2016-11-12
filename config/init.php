<?php
session_start();
require_once "database.php";

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn->query("USE matcha;")
or die(print_r($pdo->errorInfo(), true));
