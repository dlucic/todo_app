<?php 
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php"); 
}

if (empty($_GET['id'])) {
	$session->message("No task ID was provided.");
	redirect_to('../index.php');
}

$task = Task::find_by_id($_GET['id']);

if($task && $task->delete()) {
	$session->message("The task {$task->title} was deleted.");
	redirect_to("../view_list.php?id={$task->list_id}");
} else {
	$session->message("The task could not be deleted.");
	redirect_to('../index.php');
}
  
if(isset($database)) {
	$database->close_connection();
}