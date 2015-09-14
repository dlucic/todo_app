<?php 
require_once("includes/initialize.php");

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['email_code']) && !empty($_GET['email_code'])) {

	$email = $_GET['email'];
    $email_code = $_GET['email_code'];

    $found_user = User::verify_user($email, $email_code);

    if ($found_user) {
    	User::activate($found_user->email, $found_user->email_code);
		$session->message("You successfully activated your account. Please Log In.");
		redirect_to("login.php");
	} else {
		$session->message("We had a problem activating your account. Please contact administrator.");
		redirect_to("login.php");
	}
} else {
		redirect_to("register.php");
	}