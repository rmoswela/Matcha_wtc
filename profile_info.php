<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
  </head>
  <body background="./images/love-sand.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
    </header>
    <div id="pro">
    <?php
        session_start();
        require_once("db_object.php");
        $conn = $start->server_connect();
        $sql = $conn->prepare("SELECT id, firstname, lastname, online, last_seen
            FROM users WHERE username=:user");
        $sql->execute(array(':user' => $_GET['user']));
        $get_user = $sql->fetch();
        $sql_profile = $conn->prepare("SELECT gender, interests, age, toage,
            sexual_preference, biography, agefrom, fame, profile_picture FROM
            profile WHERE user_id=:id");
        $sql_profile->execute(array('id' => $get_user['id']));
        $profile = $sql_profile->fetch();

        echo '
            Profile picture: <br />
			<img src="' . $profile['profile_picture'] . '" width="400"> <br /><br />
            Name: ' . $get_user['firstname'] . ' ' . $get_user['lastname'] . '<br />
            Gender: ' . $profile['gender'] . '<br />
            Interests: ' . $profile['interests'] . '<br />
            Age: ' . $profile['age'] . '<br />
            Fame Rating: ' . $profile['fame'] . '<br />
            Biography: ' . $profile['biography'];
        
        $sql_view = $conn->prepare("INSERT INTO views (username, profile_id,
        notified) VALUES (:username, :id, 'No')");
        $sql_view->execute(array(':username' => $_SESSION['username'],
        ':id' => $get_user['id']));
    ?>
    </div>
    </body>
</html>