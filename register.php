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

	if(isset($_POST['submit'])) {
		$new_user = new User();
		$new_user->email = $_POST['email'];
		$new_user->first_name = $_POST['first_name'];
		$new_user->last_name = $_POST['last_name'];
		$new_user->regdate = date("d-m-Y");
		$new_user->status = 0;
		$new_user->password = $_POST['password'];
		$new_user->email_code = md5($_POST['first_name'] + microtime());
		if($new_user->create()) {
			$session->message("User created successfully, check your E-mail for activation.");
			$new_user->send_mail();
			redirect_to("login.php");
		} else {
			$message = join("<br />", $new_user->errors);
		}
	}
	?>

<h1>Register new user</h1>
<?php echo output_message($message); ?>
	<div class="register-form">
		<form action="register.php" method="post">
			<div class="form-text">
				<input type="text" class="text" name="first_name" value="First Name" autocomplete="off" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'First Name';}" >
				<input type="text" class="text" name="last_name" value="Last Name" autocomplete="off" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Last Name';}" >
		        <input type="text" class="text" name="email" value="E-mail" autocomplete="off" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'E-mail';}" >	
		        <input type="password" name="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
		        <input type="submit" name="submit" value="Go" />
			</div>
		</form>
	</div>
<div class="copy-right">
	<p>Davorin Lucic for Locastic</a></p> 
</div>
</body>
</html>