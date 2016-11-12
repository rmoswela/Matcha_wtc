<?php

require_once('../config/init.php');
/*if not in session return the user to index page
if (isset($_SESSION['username'] == ""))
{
	header('Location: index.php')
}*/

/*check for like value*/
if (true)//isset($POST['like']) == 'like')// && isset($POST['person_liked']))
{
	/*initialize vars*/
	$person_unliking = 'pk21';//$_SESSION['username'];
	$person_unliked = 'tmg21';//$POST['person_liked'];
	$notification = 'unlike';
	$notification_msg = 'You were unliked by ' . $person_unliking;
	echo $notification_msg . PHP_EOL;

	/*validate where the user has liked this person before or not*/
	$checking = $conn->prepare("SELECT notification_msg, notification_date FROM notifications 
		WHERE notification_msg = :notification_msg");
	$checking->bindParam (":notification_msg", $notification_msg);
	$ret = $checking->execute();
	$checking_result = $checking->fetch(PDO::FETCH_ASSOC);
	$checking_date = $checking_result['notification_date'];
	$checking_msg = $checking_result['notification_msg'];

	if ($checking_msg == NULL)
	{
		/*convert usernames to user ids*/
		$unliking = $conn->prepare("SELECT id FROM users WHERE username = :person_unliking");
		$unliking->bindParam (":person_unliking", $person_unliking);
		$unliking->execute();
		$unliking_result = $unliking->fetch(PDO::FETCH_ASSOC);
		$unliking_result = $unliking_result['id'];
		echo $unliking_result . "\n";

		$unliked = $conn->prepare("SELECT id FROM users WHERE username = :person_unliked");
		$unliked->bindParam (":person_unliked", $person_unliked);
		$unliked->execute();
		$unliked_result = $unliked->fetch(PDO::FETCH_ASSOC);
		$unliked_result = $unliked_result['id'];
		echo $unliked_result . "\n";

		/*insert data into tables*/
		$result_unlike = $conn->prepare("INSERT INTO likes (liker_id, liked_id) VALUES (?, ?)");
		$result_unlike->bindParam("1", $unliking_result, PDO::PARAM_INT);
		$result_unlike->bindParam("2", $unliked_result,PDO::PARAM_INT);
		$result_unlike->execute();

		$result_not = $conn->prepare("INSERT INTO notifications (type, from_user_id, to_user_id, notification_msg) VALUES (?, ?, ?, ?)");
		$result_not->bindParam("1", $notification);
		$result_not->bindParam("2", $unliking_result, PDO::PARAM_INT);
		$result_not->bindParam("3", $unliked_result,PDO::PARAM_INT);
		$result_not->bindParam("4", $notification_msg);
		$result_not->execute();

		/*update the users profile with notifications and likes*/
		$result_prof = $conn->prepare("UPDATE profile SET notif = notif + 1, likes = likes - 1, fame= fame - 1 WHERE user_id = ?");
		$result_prof->bindParam("1", $unliked_result, PDO::PARAM_INT);
		$result_prof->execute();

		echo "You have successfully unliked " . $person_unliked . PHP_EOL;
	}
	else
	{
		/*alert to remind the user that they already liked the other user before*/
		echo "You have already unliked " . $person_unliked . " at this exact date and time: " . $checking_date . PHP_EOL;
	}
}


?>
