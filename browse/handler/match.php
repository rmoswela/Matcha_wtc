<?php
session_start();
require_once "../../db_object.php";
require_once "../class/Matcha.class.php";

if (isset($_SESSION['username']))
{
  try
  {
    $min = htmlspecialchars(trim($_POST['min_age']));
    $max = htmlspecialchars(trim($_POST['max_age']));
    if (!isset($_POST['submit']))
    {
      $min = 0;
      $max = 100;
    }
    //print ($min." and " .$max);
    $matcha = new Matcha($start);
    $suggested = $matcha->suggest();
    $best_match = $matcha->best_match($min, $max);
    $data = json_encode(array('suggest' => $suggested, 'match' => $best_match));
    print ($data);
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
