<?php
	require_once("../config/init.php");
	var_dump($_SESSION);
//	if (isset($_POST['profileForm']))
	if (filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_STRING))
	{
		// print_r($_POST);
		// //echo json_encode(count($_FILES["pictures"]["name"]));
		// echo("Uploaded files ".count($_FILES["pictures"]));
		// var_dump($_FILES);
		//
		// foreach ($_FILES['pictures'] as $key => $value) {
		// 	echo "\n\nFile = "+$value;
		// }
		//
		//

		$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
		$lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
		$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));

		$userAge = trim(filter_input(INPUT_POST, 'age', FILTER_SANITIZE_STRING));
		$userGender = trim(filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING));

		$lookingFor = trim(filter_input(INPUT_POST, 'lookingFor', FILTER_SANITIZE_STRING));
		$beginAge = trim(filter_input(INPUT_POST, 'beginAge', FILTER_SANITIZE_STRING));
		$endAge = trim(filter_input(INPUT_POST, 'toAge', FILTER_SANITIZE_STRING));

		$userPreference = trim(filter_input(INPUT_POST, 'preferences', FILTER_SANITIZE_STRING));
		$biography = trim(filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_STRING));

			echo profileExists($_SESSION['user_id'], $conn)." User Ex\n\n";
		if (profileExists($_SESSION['user_id'], $conn) != 0)
		{
			try {
				$sql = "INSERT INTO profile (`age`,`gender`,`sexual_preference`,`biography`,`interests`)"
				." VALUES ($userAge,'$userGender','$lookingFor','$biography','$userPreference')";
				$conn->exec($sql);
				echo $_SESSION['user_id']."Last Inset ".$conn->lastInsertId();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		else {

			try {
				$stmt = $conn->prepare("UPDATE profile "
				."SET `age`=:age, `gender`=:gender, `sexual_preference`=:sexual_preference,"
				." `biography`=:biography,`interests`=:interests WHERE `user_id`=1");

				$stmt->bindParam(':age', $userAge);
				$stmt->bindParam(':gender', $userGender);
				$stmt->bindParam(':sexual_preference', $lookingFor);
				$stmt->bindParam(':biography', $biography);
				$stmt->bindParam(':interests', $userPreference);
				$stmt->execute();
				//$stmt->execute(array($_SESSION['user_id'], $userGender, $lookingFor,$biography, $userPreference, 0));
				//$userId = $conn->lastInsertId();
				echo "Done success";
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

///////////////////////////////////////// UPLOAD IMAGES /////////////////
	else if (isset($_FILES['profile']))
	{
		$totalFiles = count($_FILES['photos']['name']);

		for ($i = 0; $i < $totalFiles; $i++) {
				$uploadDir = "../".$_FILES['photos']['name'][$i];
				echo __DIR__;
				move_uploaded_file($_FILES['photos']['tmp_name'][$i], $uploadDir);

				//Insert Image to Database
				try{
					$imgUrl = "".$_FILES['photos']['name'][$i];
					$stmt = $conn->prepare("INSERT INTO `photos` (`user_id`, `url`) VALUES(?, ?)");
					$stmt->bindParam(1, $_SESSION['user_id']);
					$stmt->bindParam(2, $imgUrl);
					$stmt->execute();
					//echo "$imgUrl";
				}
				catch(Exception $e){
					echo $e->getMessage();
				}
				//echo $i." - ".$_FILES['photos']['name'][$i]."\n";
				//move_uploaded_file($_FILES['photos']['tmp_name'][$i], $_SESSION['username'].$_FILES['photos']['name'][$i]);
		}
	}

////////////////////////// GET IMAGES ////////////////////////////////////

else if (isset($_GET['action']) && $_GET['action'] == 'getUserImages')
{
	$stmt = $conn->prepare("SELECT * FROM photos WHERE user_id=:userid LIMIT 5");
	$stmt->bindParam(':userid',$_SESSION['user_id']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$result['status'] = "success";
	echo json_encode($result);
}


///////////////////////// GET INITIAL USER PROFILE /////////////////////////
else if (isset($_GET['action']) && ($_GET['action'] == "userProfile"))
{
	try {
		$stmt = $conn->prepare("SELECT * FROM profile WHERE user_id=:userid");
		$stmt->bindParam(':userid',$_SESSION['user_id']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	} catch (Exception $e) {
		$res	=	array("errors"=>1, "message"=>$e->getMessage(), "status"=>"failed");
	}

}
else{
		echo json_encode(array("error"=>"1", "message"=>"no option selected", "status"=>"failed"));
	}


	function profileExists($user_id, $conn)
	{
		echo "$user_id === user_id";
		 $res =$conn->exec("SELECT * FROM profile WHERE user_id=$user_id");
		var_dump($res);
		return (1);
	}
?>
