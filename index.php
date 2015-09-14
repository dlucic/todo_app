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
<div class="login-form">
	
	<?php 
	require_once("/includes/initialize.php");

	if (!$session->is_logged_in()) { redirect_to("login.php"); }
	echo output_message($message);

	$lists = Lista::find_by_user($_SESSION["user_id"]);
	$orderBy = array('title', 'date_created');
	$order = 'type';

	if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
		$order = $_GET['orderBy'];
		$lists = Lista::order_by($order);
	}

	if(!$lists){
		echo "No lists available. </br>";
	} else foreach ($lists as $list) { ?>
		List name: <a href="view_list.php?id=<?php echo $list->id;?>"><?php echo $list->title;?></a>
		<?php
		echo "</br>";
		echo "Number of tasks in list: " . count($list->tasks());
		echo "</br>";
		echo "Number of unfinished tasks: " . count($list->unfinished_tasks());
		echo "</br>";
		echo "Created on: " . $list->date_created;
		echo "</br>";
		?>
		<a href="admin/delete_list.php?id=<?php echo $list->id;?>">Delete list</a></br>
		<?php
		echo "</br>";
		echo "</br>";
	}
	?>

Order by: 
<th><a href="?orderBy=title">Name</a></th>
<th><a href="?orderBy=date_created">Date created</a></th>
<hr>
<a href="admin/new_list.php">Create a new todo list.</a>
<a href="logout.php">Logout</a>
</div>
<div class="copy-right">
	<p>Davorin Lucic - Locastic</a></p> 
</div>
</body>
</html>