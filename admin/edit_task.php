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

	<?php require_once("../includes/initialize.php"); 

	if (!$session->is_logged_in()) {
		redirect_to("login.php"); 
	}

	if (empty($_GET['id'])) {
		$session->message("No task ID was provided.");
	  redirect_to('../index.php');
	}

	$task = Task::find_by_id($_GET['id']);

	if (isset($_POST['submit'])) {
		$task->title = $_POST['title'];
	    $task->priority = $_POST['priority'];
	    $task->due_date = $_POST['duedate'];
	    $task->status = $_POST['status'];
		if ($task && $task->update()) {
			$session->message("The task {$task->title} was updated.");
	  		redirect_to("../view_list.php?id={$task->list_id}");
	  	} else {
	  		$session->message("The task could not be updated.");
	  		redirect_to('../index.php');
	  	}
	}
	?>

<h2>Edit task</h2>

	<?php echo output_message($message); ?>

<div class="task-form"> 
	<form action="edit_task.php?id=<?php echo $task->id;?>" method="POST">
		<label>Task name:</label>
		<input type="text" class="text" name="title" value="<?php echo $task->title ?>" />
		<br>

		<label>Priority:</label>
		<select name="priority">
		<option <?php if(isset($task->priority) && $task->priority == "low"){echo "selected=\"selected\"";} ?>>Low</option>
		<option <?php if(isset($task->priority) && $task->priority == "normal"){echo "selected=\"selected\"";} ?>>Normal</option>
		<option <?php if(isset($task->priority) && $task->priority == "high"){echo "selected=\"selected\"";} ?>>High</option>
		</select>
		<br>

		<label>Due date:</label>
		<input type="date" name="duedate" value="<?php echo $task->due_date ?>">
		<br>

		<label>Status:</label>
		<select name="status">
		<option <?php if(isset($task->status) && $task->status == "pending"){echo "selected=\"selected\"";} ?>>Pending</option>
		<option <?php if(isset($task->status) && $task->status == "done"){echo "selected=\"selected\"";} ?>>Done</option>
		</select>
		
		<input type="submit" name="submit" class="submit" value="Submit" />
	</form>
<div class="copy-right">
  <p>Davorin Lucic - Locastic</a></p> 
</div> 
</body>
</html>