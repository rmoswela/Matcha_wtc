<?php
   session_start();
    require_once("db_object.php");
    $conn = $start->server_connect();
    $sql = $conn->prepare("SELECT id, username, firstname, lastname, username
        FROM users WHERE NOT username=:uname");
    $sql->execute(array(':uname' => $_SESSION['username']));
    $other_users = $sql->fetchAll();
    $sql_likee = $conn->prepare("SELECT id FROM users WHERE username=:uname");
    $sql_likee->execute(array(':uname' => $_SESSION['username']));
    $likee = $sql_likee->fetch();

    if (isset($_POST['submit']) && $_POST['submit'] == "LIKE")
    {
      $sql_liker = $conn->prepare("SELECT id FROM users WHERE username=:uname");
      $sql_like = $conn->prepare("INSERT INTO likes (likes_id, liked_id)
        VALUES (:liker, :likee)");
      $sql_liker->execute(array(':uname' => $_SESSION['username']));
      $liker = $sql_liker->fetch();
      $sql_like->execute(array(':liker' => $liker['id'], ':likee' => $likee['id']));
    }

    $sql_id = $conn->prepare("SELECT id FROM users WHERE username=:uname");
    $sql_id->execute(array(':uname' => $_SESSION['username']));
    $get_user = $sql_id->fetch();

    if (isset($_POST['submit']) && $_POST['submit'] == "UNLIKE")
    {
      $query = $user_db->prepare("DELETE FROM likes WHERE
                      likes_id=:id_like AND liked_id=:id_liked");
      $sql_liked->execute(array(':id_like' => $get_user['id'],
      'id_liked' => $likee['id']));
    }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
  </head>
  <body background="">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
    </header>
      <div id='container'>
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

                    if ($get_liked)
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
        </div>
    <footer style="position: fixed;"><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
  </body>
</html>
