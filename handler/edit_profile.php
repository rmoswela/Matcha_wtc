<?php
session_start();
require_once "../db_object.php";

if (isset($_SESSION['username']) && !empty($_SESSION['username']))
{
  try {
    if (isset($_POST['submit']) && $_POST['submit'] == 'Save')
    {
      $conn  = $start->server_connect();
      $uname = $_SESSION['username'];
      if (isset($_POST['orientation']) && !empty($_POST['orientation']) &&
          isset($_POST['preference']) && !empty($_POST['preference']))
      {
        $gen = htmlspecialchars($_POST['orientation']);
        $pref = htmlspecialchars($_POST['preference']);
        print $gen ."<br>". $pref;
        $sql   = $conn->prepare("UPDATE users SET gender = :gen, `sex-preference` = :pref WHERE username = :uname");
        $sql->bindParam(":gen", $gen);
        $sql->bindParam(":pref", $pref);
        $sql->bindParam(":uname", $uname);
        if ($sql->execute())
        {
          $start->__setReport("updating success");
          /*
          *response for ajax
          *print $start->__getReport();
          */
          header("Location: ../profile.php");
        }
        else {
          $start->__setReport("updating biography error");
        }
      }
      else if (isset($_POST['bio-data']) && !empty($_POST['bio-data']))
      {
        $bio   = htmlspecialchars(trim($_POST['bio-data']));
        $sql   = $conn->prepare("UPDATE users SET biography = :bio WHERE username = :uname");
        $sql->bindParam(":bio", $bio);
        $sql->bindParam(":uname", $uname);
      }
      if ($sql->execute())
      {
        $start->__setReport("updating success");
        /*
        *response for ajax
        *print $start->__getReport();
        */
        header("Location: ../profile.php");
      }
      else {
        $start->__setReport("updating biography error");
      }
    }
    else
    {
      $start->__setReport("save button not clicked");
      header("Location: ../profile.php");
    }
  }
  catch (PDOException $e)
  {
    $start->__setReport("<br>".$e->getMessage());
    print $start->__getReport();
  }
}
else {
  header("Location: ../login.php");
}

?>
