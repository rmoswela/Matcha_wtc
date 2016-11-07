<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/reg.css">
  </head>
  <body background="./images/valentine-girl.jpg">
    <header>
      <span><a style="color:rgba(255,23,68 ,.9)" href="index.php">Vicini</a></span> Love
    </header>
    <div id='container'>
      <div id="show" class='signup'>
          <h1 id="form-title">Register</h1>
         <form name="user_reg" action="create_acc.php" method="post">
           <input type='text' required name="fname" placeholder='First Name:'/>
           <input type='text' required name="lname" placeholder='Last Name:'/>
           <input type='text' required name="email" placeholder='Email Address:'/>
           <input type='text' required name="uname" placeholder='Username:'/>
           <input type='password' required name="passwd" placeholder='Password:'/>
           <input type='password' required name="cpassw" placeholder='Confirm:'/>
           <input type='submit' name="submit" placeholder='SUBMIT'/>
         </form>
         <div id="bottom-links">
          <a href="login.php"><span>Already have an account? login</span></a>
         </div>
      </div>
      <div class='app-title'>
        <h1><span style="color:rgba(255,23,68 ,.9)">Vicini</span>Love</h1>
      </div>
    </div>
    <footer><span style="color: rgba(0, 0, 0, 0.5)">website by:</span> <a href="https://twitter.com/TheeRapDean">@TheeRapDean</a>
      <br><p>Copyright (c) 2016 emsimang All Rights Reserved.</p>
    </footer>
    <script type="text/javascript" src="javascript/script.js">
    </script>
  </body>
</html>
