<?php
/**
 * author: emsimang 09 wed 2016 3:40 PM
 */

class Matcha
{
  private $start;
  private $results;
  private $username;
  private $connection;

  public function __construct($start)
  {
    $this->start = $start;
  }

  public function get_user_data()
  {

  }

  public function suggest()
  {
    $this->username = $_SESSION['username'];
    $this->connection = $this->start->server_connect();
    $sql = $this->connection->prepare("SELECT users.id, user_id, username, gender FROM profile, users
                                       WHERE profile.user_id = users.id AND users.username = :uname");
    $sql->bindParam(":uname", $this->username);
    $sql->execute();
    $this->results = $sql->fetch();
    if (count($this->results) > 1 && $this->results['gender'] == "male")
    {
      $sql_suggestions = $this->connection->query("SELECT users.firstname, users.lastname, profile.gender FROM users, profile
                                                   WHERE profile.user_id = users.id AND profile.gender = 'female'
                                                   AND profile.user_id != '".$this->results['id']."' ");
      $suggest_list = $sql_suggestions->fetchAll();
      return ($suggest_list);
    }
    if (count($this->results) > 1 && $this->results['gender'] == "female")
    {
      $sql_suggestions = $this->connection->query("SELECT users.firstname, users.lastname, profile.gender FROM users, profile
                                                   WHERE profile.user_id = users.id AND profile.gender = 'male'
                                                   AND profile.user_id != '".$this->results['id']."' ");
      $suggest_list = $sql_suggestions->fetchAll();
      return ($suggest_list);
    }
    if (count($this->results) > 1 && $this->results['gender'] == "bisexual")
    {
      $sql_suggestions = $this->connection->query("SELECT users.firstname, users.lastname, profile.gender FROM users, profile
                                                   WHERE profile.user_id = users.id
                                                   AND profile.user_id != '".$this->results['id']."' ");
      $suggest_list = $sql_suggestions->fetchAll();
      return ($suggest_list);
    }
    $this->connection = null;
  }

  public function best_match()
  {
    $this->connection = $this->start->server_connect();
    $sql = $this->connection->prepare("SELECT users.id, user_id, username, gender, sexual_preference, interests FROM profile, users
                                       WHERE profile.user_id = users.id AND users.username = :uname");
    $sql->bindParam(":uname", $this->username);
    $sql->execute();
    $this->results = $sql->fetch();
    $interests = "%".$this->results['interests']."%";
    if (count($this->results) > 1 && $this->results['sexual_preference'] == "female")
    {
      $sql_best_match = $this->connection->prepare("SELECT users.firstname, users.lastname, profile.gender
                                                    FROM users, profile WHERE profile.user_id = users.id
                                                    AND profile.gender = 'female' AND profile.interests
                                                    LIKE :inter AND profile.user_id != :id ");
      $sql_best_match->bindParam(":inter", $interests);
      $sql_best_match->bindParam(":id", $this->results['id']);
      $sql_best_match->execute();
      $best_match = $sql_best_match->fetchAll();
      return ($best_match);
    }
  }
}


?>
