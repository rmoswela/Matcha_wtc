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
	$person_liking = 'ot21';//$_SESSION['username'];
	$person_liked = 'bone21';//$POST['person_liked'];
	$notification = 'like';
	$notification_msg = 'You are liked by ' . $person_liking;
	echo $notification_msg . PHP_EOL;

	/*validate where the user has liked this person before or not*/
	$checking = $conn->prepare("SELECT notification_msg, notification_date, from_user_id, to_user_id FROM notifications 
		WHERE notification_msg = :notification_msg");
	$checking->bindParam (":notification_msg", $notification_msg);
	$ret = $checking->execute();
	$checking_result = $checking->fetch(PDO::FETCH_ASSOC);
	$checking_date = $checking_result['notification_date'];
	$checking_msg = $checking_result['notification_msg'];
	$checking_liked = $checking_result['to_user_id'];
	$checking_liker = $checking_result['from_user_id'];
	echo "cheking liked" . $checking_liked . PHP_EOL;
	echo "cheking liker" . $checking_liker . PHP_EOL;

	//	if ($checking_msg == NULL || $checking_liked != $liked_result && $checking_liker != $liking_result)
	//	{
	/*convert usernames to user ids*/
	$liking = $conn->prepare("SELECT id FROM users WHERE username = :person_liking");
	$liking->bindParam (":person_liking", $person_liking);
	$liking->execute();
	$liking_result = $liking->fetch(PDO::FETCH_ASSOC);
	$liking_result = $liking_result['id'];
	echo "liking result" . $liking_result . "\n";

	$liked = $conn->prepare("SELECT id FROM users WHERE username = :person_liked");
	$liked->bindParam (":person_liked", $person_liked);
	$liked->execute();
	$liked_result = $liked->fetch(PDO::FETCH_ASSOC);
	$liked_result = $liked_result['id'];
	echo "liked result" . $liked_result . "\n";

	/*retrieved the liked persons whom the user has liked before*/
	$liked_id = $conn->prepare("SELECT liked_id FROM likes WHERE liker_id = :person_liking");
	$liked_id->bindParam (":person_liking", $liking_result);
	$liked_id->execute();
	$liked_id_result = $liked_id->fetchAll(PDO::FETCH_ASSOC);

	/*loop throught the liked table*/
	foreach ($liked_id_result as $liked_id)
	{
		foreach ($liked_id as $key => $value)
		{
			echo "liked id: " . $value . PHP_EOL;
			/*compare the liked value from the table with the one now liked*/
			if ($value == $liked_result)
			{
				$match = $liked_result;
				echo "match: " . $person_liked . PHP_EOL;
				break 2;
			}
		}
	}

	/*check if the match exists or not*/
	if (!$match)
	{
		echo $checking_liked . " != " . $liked_result . PHP_EOL;
		echo $checking_liker . " != " . $liking_result . PHP_EOL;

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
