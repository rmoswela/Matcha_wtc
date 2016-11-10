<?php
session_start();
require_once "../db_object.php";
require_once "../class/Matcha.class.php";

if (isset($_SESSION['username']))
{
  try
  {
    $match = new Matcha($start);
    print ($match->suggest());
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
