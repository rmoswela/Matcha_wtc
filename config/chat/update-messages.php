<?php
session_start();

$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));
$to_id = stripslashes(htmlspecialchars($_GET['to_id']));



require_once "connection.php";

$ret = $conn->prepare("USE db_vicinity");
$ret->execute();

$return = $conn->prepare("SELECT id FROM users WHERE username = ?");
$return->bindParam("1", $username);
$return->execute();
$return_id = $return->fetch(PDO::FETCH_ASSOC);
//print_r($return_id);
$id_return = $return_id['id'];

$msg_result = $conn->prepare("INSERT INTO messages(from_id, to_id, message)
VALUES(:usrid, :to_id, :msg)");
$msg_result->bindParam(":usrid", $id_return); 
$msg_result->bindParam(":to_id", $to_id);
$msg_result->bindParam(":msg", $message);
$msg_result->execute();

?>