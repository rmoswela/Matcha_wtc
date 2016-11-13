<?php

require_once('../config/init.php');

/*check if user is logged in
if (isset($_SESSION['username']) == "")
{
	header('Location: index.php');
}*/

$user = 'tmg21';

/*retrieve user id using username*/
$user_return = $conn->prepare("SELECT id FROM users WHERE username = :user");
$user_return->bindParam(":user", $user);
$user_return->execute();
$user_out = $user_return->fetch(PDO::FETCH_ASSOC);
$user_out = $user_out['id'];
echo $user_out . PHP_EOL;

/*selecting notifications related to user, using user id*/
$result = $conn->prepare("SELECT notification_msg, notification_date FROM notifications WHERE to_user_id = ?");
$result->bindParam("1", $user_out, PDO::PARAM_INT);
$result->execute();
$result_all = $result->fetchAll(PDO::FETCH_ASSOC);

/*loop to display all the notifications returned from the array*/
foreach ($result_all as $return)
{
	foreach ($return as $key => $value)
	{
		echo $value . ' ';
	}
	echo PHP_EOL;
}

?>
