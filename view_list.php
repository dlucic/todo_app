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
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
<div class="login-form">

  <?php require_once("includes/initialize.php");
  if (!$session->is_logged_in()) { redirect_to("login.php"); }

  $lists = Lista::find_by_id($_GET['id']);
    
  if (empty($_GET['id']) || ($lists->id != $_GET['id'])) {
    	$session->message("No list ID was provided.");
      redirect_to('../todo1/');
    }

    $lists = Lista::find_by_id($_GET['id']);
    echo $lists->title;
    echo "</br>";
    echo "Created on: " . $lists->date_created;
    echo "</br>";
    echo "Total number of tasks: " . count($lists->tasks());
    echo "</br>";
    echo "Total number of unfinished tasks: " . count($lists->unfinished_tasks()); 
    echo "</br>";
    if (count($lists->finished_tasks()) > 0) {
      echo "Progress with finished tasks: " . round((count($lists->finished_tasks())/count($lists->tasks())*100),2) . "%</br></br>"; 
    } else echo "Progress with finished tasks: 0 percent</br>";
    ?>

<a href="admin/delete_list.php?id=<?php echo $lists->id;?>" class="colorRed" onclick="return confirm('Are you sure you want to delete this item?');">Delete list</a>
</br></br>

  <?php
  echo output_message($message);

  $tasks = $lists->tasks();
  $orderBy = array('title', 'status', 'priority', 'due_date',);
  $order = 'type';

  if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    $order = $_GET['orderBy'];
    $tasks = Task::order_by($order);
  }

  foreach ($tasks as $task) {
    echo '<div class="taskWrap"> Title: '. $task->title;
    echo " Priority: {$task->priority}"; 
    echo " Due date: {$task->due_date}<br>"; 
    echo " Status: {$task->status}";
    days_left(($task->due_date), (date('Y-m-d')));
    ?>
    <br>
    <a class="deleteTask colorRed" href="admin/delete_task.php?id=<?php echo $task->id;?>" data-id="<?php echo $task->id;?>">Delete task</a>
    <a href="admin/edit_task.php?id=<?php echo $task->id;?>">Edit task</a>
    </div>
    <?php } ?> 

</br></br><hr>  
<a href="index.php">Go back</a>

Order by: 
<a href="view_list.php?id=<?php echo $lists->id; ?>&orderBy=title">Name</a>
<a href="view_list.php?id=<?php echo $lists->id;; ?>&orderBy=status">Status</a>
<a href="view_list.php?id=<?php echo $lists->id;; ?>&orderBy=priority">Priority</a>
<a href="view_list.php?id=<?php echo $lists->id;; ?>&orderBy=due_date">Due Date</a>

  <?php
  if (isset($_POST['submit'])) {
    $new_task = new Task();
    $new_task->title = $_POST['title'];
    $new_task->priority = $_POST['priority'];
    $new_task->due_date = $_POST['duedate'];
    $new_task->status = $_POST['status'];
    $new_task->list_id = $_GET['id'];

    if($new_task->save()) {
      $session->message("Task created successfully.");
      redirect_to("view_list.php?id={$lists->id}");
    } else {
    $message = join("<br />", $new_task->errors);
  }
  }
  ?>

<hr><br>
<h2>Add task</h2>

</br>
<?php echo output_message($message);?>
 
<div class="task-form"> 
  <form action="view_list.php?id=<?php echo $lists->id; ?>" method="POST">
    
    <label>Task name:</label>
    <input type="text" class="text" name="title"/>
    <br>

    <label>Priority:</label>
    <select name="priority">
      <option value="low">Low</option>
      <option selected value="normal">Normal</option>
      <option value="high">High</option>
    </select>
    <br>

    <label>Due date:</label>
    <input type="date" name="duedate">
    <br>

    <label>Status:</label>
    <select name="status">
      <option value="pending">Pending</option>
      <option value="done">Done</option>
    </select>

    <input type="submit" class="submit" name="submit" value="Submit" />
  </form>
</div>
<div class="copy-right">
  <p>Davorin Lucic - Locastic</p> 
</div>
<!--//end-copyright-->  

<script type="text/javascript">
  $(document).on('click', ".deleteTask", function(e) {
    e.preventDefault();
    var self = $(this);
    var taskId = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "admin/delete_task_ajax.php",
      data: {id: taskId},
      success: function(response) {
        self.parent().html(response);
      }
    });
  });
</script>
</body>
</html>

<?php if(isset($database)) { $database->close_connection(); } ?>