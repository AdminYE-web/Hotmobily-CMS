<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<link href="data.css" rel="stylesheet" type="text/css" />
	<title></title>
</head>
<body>

  <div class="first">
 <h2>Sign in to see customer information</h2>
    <div class="boxlogin">
	    <form name="frmlogin"  method="post" action="login.php">
        <p> 
          <input type="text"   id="username" required name="username" placeholder="Enter Username">
        </p>
        <p>
          <input type="password"   id="password" required name="password" placeholder="Enter Password">
        </p>
        <p>
          <button class="button button4" type="submit">Login</button>
          
        </p>
      </form>
      </div>
</div>
    
</body>
</html>

