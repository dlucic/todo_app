<?php
require_once('initialize.php');

class Lista extends DatabaseObject {

	protected static $table_name="lists";
	protected static $db_fields = array('id', 'title', 'user_id', 'date_created');
	
	public $id;
	public $title;
	public $user_id;
	public $date_created;

	public static function find_by_user($user_id) {
		return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE user_id={$user_id}");
	}

  	public static function order_by($order) {
		return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE user_id={$_SESSION["user_id"]} ORDER BY {$order}");
  	}

	public function tasks() {
		return Task::find_tasks_on($this->id);
	}

	public function finished_tasks() {
		return Task::find_finished_on($this->id);
	}

	public function unfinished_tasks() {
		return Task::find_unfinished_on($this->id);
	}

	public function delete_tasks() {
		return Task::delete_on($this->id);
	}
}