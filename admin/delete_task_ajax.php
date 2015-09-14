<?php 
require_once("../includes/initialize.php");

$task = Task::find_by_id($_POST['id']);

if($task && $task->delete()) {
	echo '<span class="colorRed">The task "'.$task->title.'" was deleted.</span>';
} else {
	echo "The task could not be deleted.";
}