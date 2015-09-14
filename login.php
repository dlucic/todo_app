<!DOCTYPE html>
<html>	
<head>
<title>To-Do List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<meta name="keywords" content="User Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--web-fonts-->
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!--/web-fonts-->
</head>
<body>

	<?php
	require_once("includes/initialize.php");

	if($session->is_logged_in()) {
	  redirect_to("index.php");
	}

	if (isset($_POST['submit'])) {

	  $email = trim($_POST['email']);
	  $password = trim($_POST['password']);
	  
	  $found_user = User::authenticate($email, $password);
		
	  if ($found_user) {
	    $session->login($found_user);
	    redirect_to("index.php");
	  } else {
	  	$message = "E-mail/Password combination incorrect.";
	  }
	} else {
	  $email = "";
	  $password = "";
	}
	?>

<h1>To-Do List Login</h1>
<div class="warning"><?php echo output_message($message); ?> </div>
<div class="avtar"> <img src="images/avtar.png" /> </div>
	<div class="login-form">
		<p>New user?<a href="register.php">Register here!</a></p>
		<form action="login.php" method="post">
			<div class="form-text">
			<input type="text" class="text" name="email" value="E-mail" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'E-mail';}" >
			<input type="password" name="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
			<input type="submit" name="submit" value="Go" />
			</div>
		</form>
	</div>
<div class="copy-right">
	<p>Davorin Lucic - Locastic</a></p> 
</div>
</body>
</html>