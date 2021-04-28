<?php

//error_reporting(0);
include_once("../backend/logins.php");
?>
<html>
    <head>
    <meta charset="utf-8">
    <title><?php if($_SESSION['authenticated']){echo ucfirst($_SESSION['user']); echo "'s ";} ?>CVIS login</title>
    <link rel="shortcut icon" href="./images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    </head>
<body>
<form method="post" action="../backend/logins.php">
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password">
  	</div>
  	  <button type="submit" class="btn" name="log">Login</button>
  	</div>
  	<p>
  		Need an Account? <a href="register.php">Register</a>
  	</p>
</form>
</body>
</html>