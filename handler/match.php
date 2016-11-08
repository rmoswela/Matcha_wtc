<?php
session_start();
require_once "../db_object.php";

if (isset($_SESSION['username']))
{
  try
  {
    $uname = $_SESSION['username'];
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT * FROM users WHERE username = :uname");
    $sql->bindParam(":uname", $uname);
    $sql->execute();
    $res = $sql->fetch();
    if (count($res) > 1 && $res['gender'] == "male")
    {
      $sql_suggestions = $conn->query("SELECT * FROM users WHERE gender = 'female'");
      $suggest_list = $sql_suggestions->fetch();
      $response = json_encode($suggest_list);
      print $response;
    }
  }
  catch(PDOEXception $e)
  {
    $start->__setReport("".$e->getMessage());
    print "<div id='error' onclick='disappear()'>".$start->__getReport()."</div>";
  }
}
else
{
  $error = array('error' => "not logged in");
  $error = json_encode($error);
  print $error;
}

?>
