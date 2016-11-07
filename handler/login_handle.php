<?php
session_start();
require_once "db_object.php";

if (!empty($_SESSION['username'])) {
	header("Location: index.php");
}
if(isset($_POST['submit']))
{
  try
	{
    $email = $_POST['email'];
    $passw = $_POST['passwd'];//hash('whirlpool', $_POST['passwd']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
      $start->__setReport("email is not valid");
      print $start->__getReport();
      header("refresh : 3; login.php");
      return;
    }
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT active, username, password, email FROM users
					 WHERE email = :email AND password = :passwd");
		$sql->bindParam(":email", $email);
		$sql->bindParam(":passwd", $passw);
    $sql->execute();
		$res = $sql->fetch();
		if ($sql->rowCount() > 0 && $res['active'] == 0)
		{
			header("Location: notverified.php");
		}
    if($sql->rowCount() > 0 && $res['active'] == 1) {
			$_SESSION['username'] = $uname;
			header("Location: index.php");
		}
		else {
			$start->__setReport("<strong>unknown user</strong>". PHP_EOL);
      print $start->__getReport();
		}
	}
	catch (PDOException $err) {
		$start->__setReport($sql ."". $err->getMessage());
    print $start->__getReport();
	}
}
$conn = null;

?>
