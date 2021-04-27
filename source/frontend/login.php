<?php

error_reporting(0);
include_once("../backend/logins.php");
?>

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