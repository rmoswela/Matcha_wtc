<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>vicinilove</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
  </head>
  <body background="./images/love-sand.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
    </header>
    <div id='container'>

      <div id="show" class='signup'>
          <h1 id="form-title">login</h1>
         <form name="user_login" action="./handler/login_handle.php" method="post">
           <input type='text' name="uname" placeholder='username:'/>
           <input type='password' required name="passwd" placeholder='Password:'/>
           <input type='submit' name="submit" value="login" placeholder='login'/>
         </form>
         <div id="bottom-links">
          <a href="reset.php"><span>forgot your password?</span></a>
          <a href="register.php"><span>Don't have an account? Register</span></a>
         </div>
    </div>
    </div>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/login.js">
    </script>
  </body>
</html>
