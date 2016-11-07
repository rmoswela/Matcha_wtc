<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
  </head>
  <body background="./images/love-sand.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
    </header>
    <div id='container'>

      <div id="show" class='signup'>
          <h1 id="form-title">login</h1>
         <form name="user_login" onsubmit="return formValidate()" action="" method="post">
           <input type='text' name="uname" placeholder='username:'/>
           <input type='password' required name="passwd" placeholder='Password:'/>
           <input type='submit' name="submit" value="login" placeholder='login'/>
         </form>
         <div id="bottom-links">
          <a href="reset.php"><span>forgot your password?</span></a>
          <a href="register.php"><span>Don't have an account? Register</span></a>
         </div>
    </div>
    </div>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/login.js">
    </script>
  </body>
</html>

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
    $uname = htmlspecialchars(trim($_POST['uname']));
    $passw = htmlspecialchars(trim($_POST['passwd']));
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT active, username, password, email FROM users
                           WHERE username = :uname");
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
      $uname = $res['username'];
			$_SESSION['username'] = $uname;
			header("Location: index.php");
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
