<?php

//$username = stripslashes(htmlspecialchars($_GET['username']));
session_start();
//$gmojela_id = 2;
//$bdiale_id = 1;
$user = $_SESSION["username"];
$user1 = $_SESSION["username"];
echo "logged on as :".$user."<br />";


$to_id = stripslashes(htmlspecialchars($_GET['to_id']));


require_once "../db_object.php";

$conn = $start->server_connect();
$conn->query("
    USE db_vicinity;
");
$sql = $conn->query("SELECT id FROM users WHERE username = '$user'");

$logged_on = $sql->fetch(PDO::FETCH_ASSOC);
$user = $logged_on['id'];
//echo "checking id: " . $user . PHP_EOL;


$conn->query("
    USE db_vicinity;
");
$sql2 = $conn->query("SELECT id FROM users WHERE username = '$to_id'");

$logged_on2 = $sql2->fetch(PDO::FETCH_ASSOC);
$to_id = $logged_on2['id'];
//echo "checking to_id: " . $to_id . PHP_EOL;



$conn->query("
    USE db_vicinity;
");
$sql1 = $conn->query("
SELECT from_id,to_id, message FROM `messages` WHERE to_id = '$user' AND from_id = '$to_id' OR to_id = '$to_id' AND from_id = '$user'");

$ret1= $sql1->fetchAll();
//var_dump($ret1);


//print_r($ret2);


//$results = $sql->fetchAll();
 //print_r($ret1);
foreach ($ret1 as $r) {
	$from_id  = $r["from_id"];

	$sql3 = $conn->query("
		SELECT username FROM users WHERE id = $from_id");
	$my_user = $sql3->fetch();

	 $r["from_id"] = $my_user['username'];
	echo $r["from_id"];
	echo "\\";
	echo $r["message"];

	echo "\n";
}


$sql_friends = $conn->query("
    SELECT * FROM likes;
");
$result1 = $sql_friends->fetchAll();
//print_r($result1);

$array = array();

foreach ($result1 as $friends) {

	if($friends["likes_id"] ==  $_SESSION["user_id"]){
		$liker = $friends["likes_id"];
		$like_id = $friends["id"];
		$likee = $friends["liked_id"];

	//	echo $liker ."likes". $likee."<br />";
	}

	foreach ($result1 as $friends) {

		if($likee == $friends["likes_id"] ){
		//	echo "likee found! and they have liked someone<br />";



			if($friends["liked_id"] == $_SESSION["user_id"]){
			//	echo "friends made!! ";
				//echo "friend ->". $likee;

				if (!in_array($likee, $array)) {

					array_push($array, $likee);

    				$sql_username = $conn->query("
						SELECT username FROM users WHERE '$likee' = id");
    					$user_name = $sql_username->fetchAll();

				}
			}
		}
		else{
		echo "\n";
	}

	}


}

?>
