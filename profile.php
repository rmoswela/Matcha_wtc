<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>update profile</title>
    <link rel="stylesheet" type="text/css" href="css/header.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/error.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/profile.css" media="screen">
  </head>
  <body>
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span>
      <div id="user">
        <div id="user-name">John Doe</div>
        <div id="user-pic"><img id="profile" width="35" height="35" src="avatar/avatar.jpg" alt="profile-pic"></div>
      </div>
    </header>
    <div id="wrapper">
      <div class="side-content">
        <label style="padding-left: 30%" for="settings">Settings</label>
        <ul id="settings">
          <li><a id="inter">interests</a></li>
          <li><a id="sex">sexual-preference</a></li>
          <li><a id="bio">biography</a></li>
          <li><a id="acc">my account</a></li>
        </ul>
      </div>
      <div id="heading" style="text-align: center; width: 80%;">
        <h1>edit profile</h1>
      </div>
      <div class="edit-options">

        <div id="interests">
          <form name="user_reg" id="interests-data" action="handler/edit_profile.php" method="post">
            <label for="txt-area">Tag your interests</label>
            <br><small style="color: rgba(0,0,0, .5); font-family: 'Roboto', sans-serif">tagging interests will help people find you easily</small>
            <br><small style="color: rgba(0,0,0, .5); font-family: 'Roboto', sans-serif">available tags: #geek #vegan #short #tall #suprise</small>
            <textarea id="txt-area" name="bio-data" form="bio-form" placeholder="#example #sexy ..."></textarea>
            <input type='submit' name="submit" value="Save"/>
          </form>
        </div>
        <div id="sexual">
          <div id="orientation">
            <label for="gender-options">I Am</label>
            <select form="orientation-form" name="orientation" id="gender-options" class="gender">
              <option value="male">male</option>
              <option value="female">female</option>
              <option value="bisexual">bisexual</option>
              <option value="transgender">transgender</option>
            </select>

            <br><label for="preference-list">looking for</label>
            <select form="orientation-form" name="preference" id="sexual-preference" class="gender">
              <option value="male">male</option>
              <option value="female" selected="selected">female</option>
              <option value="bisexual">bisexual</option>
              <option value="transgender">transgender</option>
            </select>
          </div>
          <form id="orientation-form" action="handler/edit_profile.php" method="post">
            <input type='submit' name="submit" value="Save"/>
          </form>
        </div>

        <div id="biography">

           <form name="user_reg" id="bio-form" action="handler/edit_profile.php" method="post">
             <label for="txt-area">Add your Biography</label>
             <br><small style="color: rgba(0,0,0, .5); font-family: 'Roboto', sans-serif">users with a bio are likely to find a patner</small>
             <textarea id="txt-area" name="bio-data" form="bio-form" placeholder="from the horses mouth"></textarea>
             <input type='submit' name="submit" value="Save"/>
           </form>

        </div>
      </div>
  </div>
  <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
    <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
  </footer>
  <script type="text/javascript" src="javascript/profile.js">
  </script>
  </body>
</html>

<?php
session_start();

if (!isset($_SESSION['username']))
{
  header("Location: login.php");
}
?>
