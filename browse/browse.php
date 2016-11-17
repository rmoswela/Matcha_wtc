<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/browse.css">
    <link rel="stylesheet" type="text/css" href="../css/error.css">
  </head>
  <body onload="loadSuggestions()">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="../index.php">Vicini</a></span> Love
      <div id="header-pane">
        <div id="browse"><a href="browse.php">browse</a></div>
        <div id="profile"><a href="../userprofile/profile.php">profile</a></div>
        <div id="logout"><a href="../logout.php"><img id="power-off" width="20" height="20" src="../images/log-off.png" alt="" /></a></div>
      </div>
    </header>
    <div class="main-content">
      <div id="left-content">
        <label id="sort-label" for="filters">Sort By</label>
        <table id="sort-table">
          <tr><td><a href="#" id="check-age">Age:</a></td></tr>
          <tr><td><a href="#" id="check-interests">interests:</a></td></tr>
          <tr><td><a href="#" id="check-location">Location:</a></td></tr>
          <tr>
            <td>
              <button class="data-contol" id="filter"type="button" name="submit">sort</button>
            </td>
          </tr>
        </table>
        <br>
        <hr align="center" width="87%">
        <br>
        <label id="filter-label" for="filters">filter By</label>
        <table id="filter-table">
          <tr>
            <td>
              <label class="filter-title" for="from">Age from:</label>
            </td>
            <td>
              <select onclick="remove_error();clear_filter()" class="age-filter" name="age" id="from"><option id="default_min" selected="selected">min-age</option></select>
            </td>
          </tr>
          <tr>
            <td>
              <label for="upto">Age upto:</label>
            </td>
            <td>
              <select onclick="remove_error();clear_filter()" class="age-filter" name="age" id="upto"><option id="default_max" selected="selected">max-age</option></select>
            </td>
          </tr>
          <tr>
            <td>interests:</td>
            <td><input id="interest" type="text" value="" name="interest" value="" placeholder="interests ex: #gothic"></td>
          </tr>
          <tr>
            <td>Location:</td>
            <td><input id="location" type="text" value="" name="locale" placeholder="city or town"></td>
          </tr>
          <tr>
            <td>
              <button class="data-contol" id="filter" onclick="filter_list()" type="button" name="submit">filter</button>
            </td>
            <td>
              <button id="clear_filter" onclick="clear_refresh()" type="button" name="submit">clear filters</button>
            </td>
          </tr>
          <tr>
            <td>
              <div style="color: red; margin-top:8%; display:none" class="error-div" id="filter_error">
                <label id="error-label" for="error">ERROR:</label>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div id="best-match" scroll="true">
        <label for="best-match">Best Matches</label>
      </div>
      <div id="right-content"><h3>You might also like</h3></div>
    </div>
    <footer>
      <span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/ajax.js"></script>
    <script type="text/javascript" src="javascript/browse.js"></script>
  </body>
</html>
