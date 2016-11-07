<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/error.css" media="screen">
  </head>
  <body>

  </body>
</html>
<?php
session_start();
require_once "db_object.php";

if (isset($_POST['submit']))
{
  $fname = htmlspecialchars(trim($_POST['fname']));
  $lname = htmlspecialchars(trim($_POST['lname']));
  $email = htmlspecialchars(trim($_POST['email']));
  $uname = htmlspecialchars(trim($_POST['uname']));
  $passw = htmlspecialchars(trim($_POST['passwd']));
  $cpass = htmlspecialchars(trim($_POST['cpassw']));

  if ($passw != $cpass)
  {
    $start->__setReport("password dont match". PHP_EOL);
    print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
    header("refresh : 3; register.php");
    return;
  }
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
  {
    $start->__setReport("email is not valid");
    print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
    header("refresh : 3; register.php");
    return;
  }
  if (strlen($passw) < 6)
  {
    $start->__setReport("password must be a minimum of 6 characters");
    print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
    header("refresh : 3; register.php");
    return;
  }
  else
  {
    try {
      $_SESSION['email'] = $email;
      $conn = $start->server_connect();
      $passw = password_hash($passw, PASSWORD_DEFAULT);
      $sql = $conn->prepare("SELECT * FROM users WHERE email = :email OR username = :uname");
      $sql->bindParam(":email", $email);
      $sql->bindParam(":uname", $uname);
      $sql->execute();
      if($sql->rowCount() > 0)
      {
        $start->__setReport("ERROR: either an email or username already exists in database");
        print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
        header("refresh: 3; register.php");
        return;
      }
      else {
        $err_val = "<br><strong>this email doesn't exist in the database</strong><br>";
      }
      $sql = $conn->prepare("INSERT INTO users(`firstname`, `lastname`, `username`, `email`, `password`)
      VALUES('".$fname."','".$lname."', '".$uname."', '".$email."', '".$passw."')");
      if ($sql->execute())
        $start->__setReport("insertion success");
        print $start->__getReport();
        header("Location: verify.php");
        return;
    }
    catch(PDOException $error) {
      $start->__setReport($error->getMessage());
      print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
      return;
    }
    $conn = null;
  }
}
else {
  header('Location: register.php');
}

?>
