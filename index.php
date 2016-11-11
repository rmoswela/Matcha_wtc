<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
  </head>
  <body onload="loadSuggestions()">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
      <div id="header-pane">
        <h2><a href="logout.php">logout</a></h2>
        <h2><a href="userprofile/profile.php">profile</a></h2>
      </div>
    </header>
    <div class="main-content">
      <div id="left-content"><h3>welcome</h3></div>
      <div id="best-match">
          <label for="best-match">Best Matches</label>
      </div>
      <div id="right-content"><h3>You may like</h3></div>
    </div>
    <script type="text/javascript" src="javascript/ajax.js">
    </script>
  </body>
</html>
