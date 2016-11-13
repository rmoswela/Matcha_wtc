<?php
session_start();
require_once "database.php";
require_once "../class/Database.class.php";

try
{
	$start = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn = $start->server_connect();
	print $start->__getReport();
	$start->create_schema($conn);
}
catch(PDOException $e)
{
	print $e->getMessage();
}

?>
