<?php

require_once('../config/init.php');

/*check if user is logged in
if (isset($_SESSION['username']) == "")
{
	header('Location: index.php');
}*/

$sending_person = 'tmg21'; //$_SESSIION['username'];
$receiving_person = 'reuben21'; //$_POST['friend'];


$sender = $conn->prepare("SELECT id FROM users WHERE username = :sender");
$sender->bindParam(":sender", $sending_person);
$sender->execute();
$sender_results = $sender->fetch(PDO::FETCH_ASSOC);
$sender_results = $sender_results['id'];
echo $sender_results . PHP_EOL;

$receiver = $conn->prepare("SELECT id FROM users WHERE username = :receiver");
$receiver->bindParam(":receiver", $receiving_person);
$receiver->execute();
$receiver_results = $receiver->fetch(PDO::FETCH_ASSOC);
$receiver_results = $receiver_results['id'];
echo $receiver_results . PHP_EOL;

$check_sender = $conn->prepare("SELECT liked_id FROM likes WHERE liked_id = :sender_results");
$check_sender->bindParam(":sender_results", $sender_results);
$check_sender->execute();
$check_sender_results = $check_sender->fetchAll(PDO::FETCH_ASSOC);
print_r($check_sender_results);

foreach($check_sender_results as $results)
{
	foreach($results as $key => $value)
	{
		echo $value . PHP_EOL;
	}
}
//$check_sender_results = $sender_results['id'];
//echo $check_sender_results . PHP_EOL;


?>
