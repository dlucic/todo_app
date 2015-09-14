<?php
require_once('initialize.php');

class Task extends DatabaseObject {
	
	protected static $table_name="tasks";
	protected static $db_fields = array('id', 'title', 'priority', 'due_date', 'status', 'list_id');
	
	public $id;
	public $title;
	public $priority;
	public $due_date;
	public $status;
	public $list_id;


	public static function find_tasks_on($list_id=0) {
    global $database;
    $sql = "SELECT * FROM " . static::$table_name;
    $sql .= " WHERE list_id=" .$database->escape_value($list_id);
    return static::find_by_sql($sql);
	}

	public static function find_finished_on($list_id=0) {
	global $database;
    $sql = "SELECT * FROM " . static::$table_name;
    $sql .= " WHERE status= 'done'";
    $sql .= " AND list_id=" .$database->escape_value($list_id);
    return static::find_by_sql($sql);
	}

	public static function find_unfinished_on($list_id=0) {
	global $database;
    $sql = "SELECT * FROM " . static::$table_name;
    $sql .= " WHERE status= 'pending'";
    $sql .= " AND list_id=" .$database->escape_value($list_id);
    return static::find_by_sql($sql);
	}

	public static function delete_on($list_id=0) {
	global $database;
	$sql = "DELETE FROM ".static::$table_name;
	$sql .= " WHERE list_id=". $database->escape_value($list_id);
	static::find_by_sql($sql);
	return ($database->affected_rows() > 0) ? true : false;
	}

	public static function order_by($order) {
		return static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE list_id={$_GET["id"]} ORDER BY {$order}");
  }
}