<?php
require_once('database.php');
require_once('initialize.php');

class User extends DatabaseObject {
	
	protected static $table_name="users";
	protected static $db_fields = array('id', 'email', 'email_code', 'first_name', 'last_name', 'regdate', 'lastlogin', 'status', 'password');
	
	public $id;
	public $email;
	public $first_name;
	public $last_name;
	public $regdate;
	public $lastlogin;
	public $status;
	public $password;
	public $email_code;
	

	public static function authenticate($email="", $password="") {
	    global $database;
	    $email = $database->escape_value($email);
	    $password = $database->escape_value($password);
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE email = '{$email}' AND password = '{$password}' AND status = 1 LIMIT 1";
	    $result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function last_login() {
		global $database;
		$date = strftime("%Y-%m-%d %H:%M:%S", time());
	    $sql = "UPDATE " . static::$table_name . " SET lastlogin = '{$date}' WHERE id = '{$_SESSION['user_id']}'";
	    return static::find_by_sql($sql);
	}

	public static function verify_user($email="", $email_code="") {
		global $database;
		$email = $database->escape_value($email);
		$email_code = $database->escape_value($email_code);
		$sql  = "SELECT * FROM " . static::$table_name . " WHERE email = '{$email}' AND email_code = '{$email_code}' AND status = '0'";
		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function activate($email="", $email_code="") {
		global $database;
	    $sql = "UPDATE " . static::$table_name . " SET status = '1' WHERE email = '{$email}' AND email_code = '{$email_code}' AND status = '0'";
	    $result_array= static::find_by_sql($sql);
	    return !empty($result_array) ? array_shift($result_array) : false;
	}

	public function send_mail() {
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = '';		//smtp username
		$mail->Password = '';		//smtp password
		$mail->SMTPSecure = 'tls'; 
		$mail->Port = 587;

		$mail->From = 'admin@todolist.com';
		$mail->FromName = 'Admin';
		$mail->addAddress($this->email);

		$mail->isHTML(true);

		$mail->Subject = 'To-Do List user activation';
		$mail->Body    = "Dear " . $this->first_name . ", please activate your account by clicking on the following link: http://localhost/todo/activate.php?email=" . $this->email . "&email_code=" . $this->email_code;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$result = $mail->Send();
		return $result;
	}
}