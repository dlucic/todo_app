<?php 
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) { 
  redirect_to("login.php"); 
}

if (empty($_GET['id'])) {
  $session->message("No list ID was provided.");
  redirect_to('../index.php');
}

$list = Lista::find_by_id($_GET['id']);

if ($list && $list->tasks() && $list->delete() && $list->delete_tasks()) {
  $session->message("The List {$list->title} and all its tasks were deleted.");
  redirect_to('../index.php');
} elseif ($list && !($list->tasks()) && $list->delete()) {
  $session->message("The List {$list->title} was deleted.");
  redirect_to('../index.php');
} else {
  $session->message("The list could not be deleted.");
  redirect_to('../index.php');
}

if (isset($database)) {
  $database->close_connection();
}