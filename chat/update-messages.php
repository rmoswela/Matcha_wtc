<?php
session_start();


$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));


if ($message == "" || $username == "") {
	die();
}

require_once "connection.php";

$result = $conn->prepare("USE chat;INSERT INTO messages_tbl(user_id, messages) VALUES(:usrid, :msg)");
$result->bindParam(":usrid", $_SESSION["user_id"]);
$result->bindParam(":msg", $message);
$result->execute();