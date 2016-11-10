<?php
/**
 * author: emsimang 09 wed 2016 3:40 PM
 */

class Matcha
{
  private $start;
  private $results;
  private $connection;

  public function __construct($start)
  {
    $this->start = $start;
  }

  public function suggest()
  {
    $uname = $_SESSION['username'];
    $this->connection = $this->start->server_connect();
    $sql = $this->connection->prepare("SELECT * FROM users WHERE username = :uname");
    $sql->bindParam(":uname", $uname);
    $sql->execute();
    $this->results = $sql->fetch();
    if (count($this->results) > 1 && $_SESSION['gender'] == "male")
    {
      $sql_suggestions = $this->connection->query("SELECT * FROM users WHERE gender = 'female'");
      $suggest_list = $sql_suggestions->fetchAll();
      $response = json_encode($suggest_list);
      return ($response);
    }
    if (count($this->results) > 1 && $_SESSION['gender'] == "female")
    {
      $sql_suggestions = $this->connection->query("SELECT * FROM users WHERE gender = 'male'");
      $suggest_list = $sql_suggestions->fetchAll();
      $response = json_encode($suggest_list);
      return ($response);
    }
    if (count($this->results) > 1 && $_SESSION['gender'] == "bisexual")
    {
      $sql_suggestions = $this->connection->query("SELECT * FROM users WHERE username != '".$uname."'");
      $suggest_list = $sql_suggestions->fetchAll();
      $response = json_encode($suggest_list);
      return ($response);
    }
  }

  public function best_match()
  {

  }
}


?>
