<?php
	require_once("../config/init.php");
//	var_dump($_SESSION);
//	if (isset($_POST['profileForm']))
  //$location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
	$location = array("city"=>"Maseru", "country"=>"Lesotho");
	if (filter_input(INPUT_POST, 'biography', FILTER_SANITIZE_STRING))
	{

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
		$user_id = $_SESSION['user_id'];
		if (profileExists($_SESSION['user_id'], $conn) === 0)
		{
			try {
				$loc = $location['city'];
				$sql = "INSERT INTO profile (`age`,`user_id`,`gender`,`sexual_preference`,`biography`,`interests`,`agefrom`,`toage`,`location`)"
				." VALUES ($userAge,$user_id, '$userGender','$lookingFor','$biography','$userPreference',$beginAge,$endAge, $loc)";
				$conn->exec($sql);
				//echo $_SESSION['user_id']."Last Inset ".$conn->lastInsertId();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		else {

			try {
				$stmt = $conn->prepare("UPDATE profile "
				."SET `age`=:age, `gender`=:gender,`sexual_preference`=:sexual_preference,"
				." `biography`=:biography,`interests`=:interests,`agefrom`=:agefrom,`toage`=:toage, `location`=:location WHERE `user_id`=$user_id");
				print_r($location);
				$loc = $location['city'];

				$stmt->bindParam(':age', $userAge);
				$stmt->bindParam(':gender', $userGender);
				$stmt->bindParam(':sexual_preference', $lookingFor);
				$stmt->bindParam(':biography', $biography);
				$stmt->bindParam(':interests', $userPreference);
				$stmt->bindParam(':agefrom', $beginAge);
				$stmt->bindParam(':toage', $endAge);
				$stmt->bindParam(':location', $loc);
				$stmt->execute();
				//$stmt->execute(array($_SESSION['user_id'], $userGender, $lookingFor,$biography, $userPreference, 0));
				$userId = $conn->lastInsertId();
				$username = $_SESSION['username'];
				$stmt = $conn->prepare("UPDATE users "
				."SET `firstname`=:firstname, `lastname`=:lastname,`email`=:email WHERE `username`=:username");
				$stmt->bindParam(':firstname', $firstname);
				$stmt->bindParam(':lastname', $lastname);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':username', $username);
				$stmt->execute();

				if ($stmt->rowCount() === 0 )
				{
					echo json_encode(array("error"=>1, "status"=>"failed", "message"=>"counld not update"));
				}
				else{
					echo json_encode(array("error"=>0, "status"=>"success", "message"=>"Profile info updated successfully"));
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

///////////////////////////////////////// UPLOAD IMAGES /////////////////
	else if (isset($_FILES['profile']))
	{
		$totalFiles = count($_FILES['photos']['name']);
		// Set perms with chmod()
	 //chmod("images/", 0777);
	 $user_id = $_SESSION['user_id'];
	 if ($totalFiles > 0)
	 {
		 $sql = "DELETE FROM `photos` WHERE `user_id`=$user_id";
		 $conn->exec($sql);
		 for ($i = 0; $i < $totalFiles; $i++) {
				$date = new DateTime();
				$date = $date->getTimestamp()+"";
				$uploadDir = "images/$date".$_FILES['photos']['name'][$i];
				if (move_uploaded_file($_FILES['photos']['tmp_name'][$i], $uploadDir))
				{
					//Insert Image to Database
					try{
						$imgUrl = "php/images/$date".$_FILES['photos']['name'][$i];
						$stmt = $conn->prepare("INSERT INTO `photos` (`user_id`, `url`) VALUES(?, ?)");
						$stmt->bindParam(1, $_SESSION['user_id']);
						$stmt->bindParam(2,$imgUrl);
						$stmt->execute();
						//echo "$imgUrl";
					}
					catch(Exception $e){
						echo $e->getMessage();
					}
				}
			}
		}

		//////// UPLOAD PROFILE picture ////////
		// Set perms with chmod()
	 //chmod("images/", 0777);
	  $date = new DateTime();
	  $date = $date->getTimestamp()."";
		$uploadDir = "images/$date".$_FILES['profile']['name'];
		if (move_uploaded_file($_FILES['profile']['tmp_name'], $uploadDir))
		{
			//Insert Image to Database
			try{
				$imgUrl = "php/images/$date".$_FILES['profile']['name'];
				$stmt = $conn->prepare("UPDATE `profile` SET `profile_picture`=:picurl WHERE `user_id`=:userid");
				$stmt->bindParam(':picurl', $imgUrl);
				$stmt->bindParam(':userid', $_SESSION['user_id']);
				$stmt->execute();
				if ($stmt->rowCount() > 0)
				{
						echo json_encode(array("error"=>0, "status"=>"success", "message"=>"profile picture uploaded successfully"));
				}
				else {
						echo json_encode(array("error"=>1, "status"=>"failed", "message"=>"could not upload profile picture"));
				}
				//echo "$imgUrl";
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
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

else if (isset($_GET['action']) && ($_GET['action'] == "getUserLikes"))
{
	try {
		$sql = "SELECT `likes`.`likes_id`,`users`.`username`
						FROM `users`,`likes`
						WHERE `likes`.`liked_id`=:userid
						AND `likes`.`likes_id` = `users`.`id`";
		$user_id = $_SESSION['user_id'];
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':userid', $user_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() > 0)
			echo json_encode($result);
		else {
			$res	=	array("errors"=>1, "message"=>$e->getMessage(), "status"=>"failed");
			echo json_encode($res);
		}
	} catch (Exception $e) {
		$res	=	array("errors"=>1, "message"=>$e->getMessage(), "status"=>"failed");
	}
}
else{
		echo json_encode(array("error"=>"1", "message"=>"no option selected", "status"=>"failed"));
	}

	function profileExists($user_id, $conn)
	{
		 $res =$conn->prepare("SELECT * FROM profile WHERE user_id=$user_id");
		 $res->execute();
		return($res->rowCount());
	}

?>
