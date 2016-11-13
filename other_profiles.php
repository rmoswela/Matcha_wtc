<?php
   session_start();
    require_once("db_object.php");
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT id, username, firstname, lastname, username
        FROM users WHERE NOT username=:uname");
    $sql->execute(array(':uname' => $_SESSION['username']));
    $other_users = $sql->fetchAll();
    $sql_likee = $conn->prepare("SELECT id FROM users WHERE username=:uname");
    $sql_likee->execute(array(':uname' => $_POST['username']));
    $likee = $sql_likee->fetch();

    if (isset($_POST['submit']) && $_POST['submit'] == "LIKE")
    {
      $sql_liker = $conn->prepare("SELECT id FROM users WHERE username=:uname");
      $sql_like = $conn->prepare("INSERT INTO likes (likes_id, liked_id)
        VALUES (:liker, :likee)");
      $sql_liker->execute(array(':uname' => $_SESSION['username']));
      $liker = $sql_liker->fetch();
      $sql_like->execute(array(':liker' => $liker['id'], ':likee' => $likee['id']));

      $result_not = $conn->prepare("INSERT INTO notifications (type, `from`, `to`) VALUES ('Like', :id_from, :id_to)");
      $liking_result = $liker['id'];
      $liked_result = $likee['id'];

      $result_not->bindParam(":id_from", $liking_result, PDO::PARAM_INT);
      $result_not->bindParam(":id_to", $liked_result,PDO::PARAM_INT);
      $result_not->execute();

      /*update the users profile with notifications and likes*/
      $result_prof = $conn->prepare("UPDATE profile SET notif = notif + 1, likes = likes + 1, fame= fame + 1 WHERE user_id = :id");
      $result_prof->bindParam(":id", $liked_result, PDO::PARAM_INT);
      $result_prof->execute();
    }

    $sql_id = $conn->prepare("SELECT id FROM users WHERE username=:uname");
    $sql_id->execute(array(':uname' => $_SESSION['username']));
    $get_user = $sql_id->fetch();

    if (isset($_POST['submit']) && $_POST['submit'] == "UNLIKE")
    {
      $query = $conn->prepare("DELETE FROM likes WHERE
                      likes_id=:id_like AND liked_id=:id_liked");
      $query->execute(array(':id_like' => $get_user['id'],
      'id_liked' => $likee['id']));

      $result_not = $conn->prepare("INSERT INTO notifications (type, `from`, `to`) VALUES ('Unlike', :id_from, :id_to)");
      $liking_result = $get_user['id'];
      $liked_result = $likee['id'];

      $result_not->bindParam(":id_from", $liking_result, PDO::PARAM_INT);
      $result_not->bindParam(":id_to", $liked_result,PDO::PARAM_INT);
      $result_not->execute();

      /*update the users profile with notifications and likes*/
      $result_prof = $conn->prepare("UPDATE profile SET notif = notif + 1, likes = likes - 1, fame= fame - 1 WHERE user_id = :id");
      $result_prof->bindParam(":id", $liked_result, PDO::PARAM_INT);
      $result_prof->execute();
    }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
  </head>
  <body background="./mages/love-sand.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
          <a href="logout.php">Logout</a>
    </header>
            <?php
                foreach ($other_users as $user)
                {
                    $sql_pic = $conn->prepare("SELECT profile_pic FROM profile
                      WHERE user_id=:id");
                    $sql_pic->execute(array(':id' => $user['id']));
                    $get_pic = $sql_pic->fetch();
                    $sql_liked = $conn->prepare("SELECT id FROM likes WHERE
                      likes_id=:id_like AND liked_id=:id_liked");
                    $sql_pic->execute(array(':id' => $user['id']));
                    $sql_liked->execute(array(':id_like' => $get_user['id'],
                      'id_liked' => $user['id']));
                    $get_liked = $sql_liked->fetch();

                    $sql_isliked = $conn->prepare("SELECT id FROM likes WHERE
                      likes_id=:id_like AND liked_id=:id_liked");
                    $sql_isliked->execute(array(':id_like' => $user['id'],
                      'id_liked' => $get_user['id']));
                    $get_isliked = $sql_isliked->fetch();
                    
                    if ($get_liked && $get_isliked)
                      $like_value = "CHAT WITH " . strtoupper($user['firstname']);
                    else if ($get_liked)
                      $like_value = "UNLIKE";
                    else
                      $like_value = "LIKE";

                    if ($get_pic)
                    {
                      $src_pic = $get_pic['profile_pic'];

                      echo '<div id="profiles">
                            <form method="post" action="#">
                            <input type="hidden" name="username" value="' . $user['username'] . '"/>
                            <a href="profile_info.php?user=' . $user['username']
                            . '"><img src="'. $src_pic . '" width="300"></a><br />'
                            . $user['firstname'] . ' ' . $user['lastname'] . '<br />
                            <input id="btn_like" type="submit" name="submit" value="' . $like_value . '"/>
                            </form>
                            </div>';
                    }
                }
            ?>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/login.js">
    </script>
  </body>
</html>
