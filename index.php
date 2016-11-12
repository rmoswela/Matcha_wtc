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
      <div id="left-content">
        <label id="sort-label" for="filters">Sort By</label>
        <table id="sort-table">
          <tr><td><a href="#" id="check-age">Age:</a></td></tr>
          <tr><td><a href="#" id="check-interests">interests:</a></td></tr>
          <tr><td><a href="#" id="check-location">Location:</a></td></tr>
        </table>
        <label id="filter-label" for="filters">filter By</label>
        <table id="filter-table">
          <tr>
            <td><label class="filter-title" for="from">From:</label></td>
            <td><select class="age-filter" name="age" id="from"><option selected="selected">min-age</option></select></td>
          </tr>
          <tr>
            <td><label for="upto">Upto:</label></td>
            <td><select class="age-filter" name="age" id="upto"><option selected="selected">max-age</option></select></td>
          </tr>
          <tr>
            <td>interests:</td>
            <td><input type="text" name="interest" value="" placeholder="tag intersts ex: #gothic..."></td>
          </tr>
          <tr>
            <td>Location:</td>
            <td><input type="text" name="interest" value="" placeholder="city or town"></td>
          </tr>
        </table>
      </div>
      <div id="best-match" scroll="true">
        <label for="best-match">Best Matches</label>
      </div>
      <div id="right-content"><h3>You might also like</h3></div>
    </div>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/ajax.js"></script>
    <script type="text/javascript" src="javascript/index.js"></script>
  </body>
</html>
