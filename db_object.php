<?php
require_once "config/database.php";
require_once "class/Database.class.php";

$start = new Database($DB_DSN.$DB, $DB_USER, $DB_PASSWORD);

?>
