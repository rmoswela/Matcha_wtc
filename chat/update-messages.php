<?php
session_start();
$frm = $_SESSION["from_id"];

//echo "string". $frm;

$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));
$to_id = stripslashes(htmlspecialchars($_GET['to_id']));

//echo "string" . $to_id;



//echo "stjhgjh\n";
/*
if ($message == "") {
	die();
}*/

require_once "../db_object.php";

$conn = $start->server_connect();
$conn->query("
    USE db_vicinity;
");

$sql2 = $conn->query("SELECT id FROM users WHERE username = '$to_id'");

$logged_on2 = $sql2->fetch(PDO::FETCH_ASSOC);
$to_id = $logged_on2['id'];

//echo "kljfsljdfd " . PHP_EOL;
$ret = $conn->prepare("USE db_vicinity");
$ret->execute();

$return = $conn->prepare("SELECT id FROM users WHERE username = ?");
$return->bindParam("1", $username);
$return->execute();
$return_id = $return->fetch(PDO::FETCH_ASSOC);
//print_r($return_id);
$id_return = $return_id['id'];
//echo $id_return;

$msg_result = $conn->prepare("INSERT INTO messages(from_id, to_id, message)
VALUES(:usrid, :to_id, :msg)");
$msg_result->bindParam(":usrid", $id_return); /*$_SESSION["from_id"]);*/
$msg_result->bindParam(":to_id", $to_id);
$msg_result->bindParam(":msg", $message);
$msg_result->execute();

?>
