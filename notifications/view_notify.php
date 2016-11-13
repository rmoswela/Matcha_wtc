<?php

require_once('../config/init.php');

/*check if the user is connected or not
if (isset($_SESSION['username'] == "")
{
	header('Location: index.php');
}*/

if (true)//isset($_POST['view_profile']) == 'view_profile' && isset($_POST['profile_owner']))
{
	/*initialize vars*/
	$stalked_person = 'tmg21'; //$_POST['profile_owner'];
	$stalker_person = 'reuben21'; //$_SESSION['username'];
	$notification = 'views';
	$notification_msg = 'Your profile was viewed by ' . $stalker_person;
	echo $notification_msg . PHP_EOL;

	/*retrieve user ids using usernames*/
	$stalked = $conn->prepare("SELECT id FROM users WHERE username = :stalked");
	$stalked->bindParam(":stalked", $stalked_person);
	$stalked->execute();
	$stalked_ret = $stalked->fetch(PDO::FETCH_ASSOC);
	$stalked_ret = $stalked_ret['id'];
	echo $stalked_ret . PHP_EOL;

	$stalker = $conn->prepare("SELECT id FROM users WHERE username = :stalker");
	$stalker->bindParam(":stalker", $stalker_person);
	$stalker->execute();
	$stalker_ret = $stalker->fetch(PDO::FETCH_ASSOC);
	$stalker_ret = $stalker_ret['id'];
	echo $stalker_ret . PHP_EOL;

	/*insert data into relative tables*/
	$views = $conn->prepare("INSERT INTO views (viewer_id, viewed_id) VALUES (?, ?)");
	$views->bindParam("1", $stalker_ret);
	$views->bindParam("2", $stalked_ret);
	$views->execute();

	$notify = $conn->prepare ("INSERT INTO notifications(type, from_user_id, to_user_id, notification_msg) values (?, ?, ?, ?)");
	$notify->bindParam("1", $notification);
	$notify->bindParam("2", $stalker_ret, PDO::PARAM_INT);
	$notify->bindParam("3", $stalked_ret, PDO::PARAM_INT);
	$notify->bindParam("4", $notification_msg);
	$notify->execute();

	/*update the user profile with the view count and notifications*/
	$profile = $conn->prepare("UPDATE profile SET views = views + 1, notif = notif + 1 WHERE user_id = ?");
	$profile->bindParam("1", $stalked_ret, PDO::PARAM_INT);
	$profile->execute();
}


?>
