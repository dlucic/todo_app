<!DOCTYPE html>
<html>	
<head>
<title>To-Do List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<meta name="keywords" content="User Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
<link href="../css/style.css" rel='stylesheet' type='text/css' />
<!--web-fonts-->
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!--/web-fonts-->
</head>
<body>
<div class="login-form">

	<?php 
	require_once("../includes/initialize.php"); 
	
	if (!$session->is_logged_in()) { 
		redirect_to("login.php"); 
	}

	if (isset($_POST['submit'])) {
		$new_list = new Lista();
		$new_list->title = $_POST['title'];
		$new_list->user_id = $_SESSION['user_id'];
		$new_list->date_created = date("d-m-Y");

		if ($new_list->save()) {
			$session->message("List created successfully.");
			redirect_to("../view_list.php?id={$new_list->id}");
		} else {
			$message = join("<br />", $new_list->errors);
		}
	}
	?>

<h2>Create New List</h2><br>
<div class="warning"><?php echo output_message($message); ?> </div>
<div class="login-form">
	<form action="new_list.php" method="POST">
		List name: 
		<input type="text" class="text" name="title" /></p>
		<input type="submit" name="submit"class="submit" value="Submit" />
	</form>
</div>
<div class="copy-right">
	<p>Davorin Lucic - Locastic</p> 
</div>
</body>
</html>