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
	$person_liking = 'pk21';//$_SESSION['username'];
	$person_liked = 'tmg21';//$POST['person_liked'];
	$notification = 'like';
	$notification_msg = 'You are liked by ' . $person_liking;
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
		$liking = $conn->prepare("SELECT id FROM users WHERE username = :person_liking");
		$liking->bindParam (":person_liking", $person_liking);
		$liking->execute();
		$liking_result = $liking->fetch(PDO::FETCH_ASSOC);
		$liking_result = $liking_result['id'];
		echo $liking_result . "\n";

		$liked = $conn->prepare("SELECT id FROM users WHERE username = :person_liked");
		$liked->bindParam (":person_liked", $person_liked);
		$liked->execute();
		$liked_result = $liked->fetch(PDO::FETCH_ASSOC);
		$liked_result = $liked_result['id'];
		echo $liked_result . "\n";

		/*insert data into tables*/
		$result_like = $conn->prepare("INSERT INTO likes (liker_id, liked_id) VALUES (?, ?)");
		$result_like->bindParam("1", $liking_result, PDO::PARAM_INT);
		$result_like->bindParam("2", $liked_result,PDO::PARAM_INT);
		$result_like->execute();

		$result_not = $conn->prepare("INSERT INTO notifications (type, from_user_id, to_user_id, notification_msg) VALUES (?, ?, ?, ?)");
		$result_not->bindParam("1", $notification);
		$result_not->bindParam("2", $liking_result, PDO::PARAM_INT);
		$result_not->bindParam("3", $liked_result,PDO::PARAM_INT);
		$result_not->bindParam("4", $notification_msg);
		$result_not->execute();

		/*update the users profile with notifications and likes*/
		$result_prof = $conn->prepare("UPDATE profile SET notif = notif + 1, likes = likes + 1, fame= fame + 1 WHERE user_id = ?");
		$result_prof->bindParam("1", $liked_result, PDO::PARAM_INT);
		$result_prof->execute();

		echo "You have successfully liked " . $person_liked . PHP_EOL;
	}
	else
	{
		/*alert to remind the user that they already liked the other user before*/
		echo "You have already liked " . $person_liked . " at this exact date and time: " . $checking_date . PHP_EOL;
	}
}


?>
