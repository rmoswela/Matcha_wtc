<?php
session_start();
require_once "../db_object.php";

if (!empty($_SESSION['username'])) {
	header("Location: index.php");
}
if(isset($_POST['submit']))
{
  try
	{
    $uname = htmlspecialchars(trim($_POST['uname']));
    $passw = htmlspecialchars(trim($_POST['passwd']));
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT * FROM users WHERE username = :uname");
    $sql->bindParam(":uname", $uname);
    $sql->execute();
    $res = $sql->fetch();
    if (count($res) > 1 && (password_verify($passw, $res['password']) == true) && $res['active'] == 0)
    {
      $start->__setReport("account not activated, please check your email and activate this account");
      print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
      return;
		}
    if(count($res) > 1 && $res['active'] == 1)
    {
      if (!password_verify($passw, $res['password']))
      {
        $start->__setReport("incorrect password");
        print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
        return;
      }
			$_SESSION['username'] = $res['username'];
      $_SESSION['firstname'] = $res['firstname'];
      $_SESSION['lastname'] = $res['lastname'];
      $_SESSION['email'] = $res['email'];
      $_SESSION['gender'] = $res['gender'];
      $_SESSION['user_id'] = $res['user_id'];
			header("Location: ../index.php");
		}
    elseif (count($res) > 1 && (password_verify($passw, $res['password']) == false)) {
        $start->__setReport("incorrect password");
        print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
        return;
    }
    else
    {
      $start->__setReport("incorrect username");
      print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
      return;
		}
	}
	catch (PDOException $err) {
		$start->__setReport($sql ."". $err->getMessage());
    print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
	}
}
$conn = null;

?>
