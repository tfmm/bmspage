<?php
	include "db_config.php";
$conn = mysqli_connect($servername, $username, $password, $db);

$event_id = mysqli_real_escape_string($conn, $_POST['event']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$is_ongoing = mysqli_real_escape_string($conn, $_POST['is_ongoing']);
$end_date_time = mysqli_real_escape_string($conn, $_POST['end_date_time']);
$user = mysqli_real_escape_string($conn, $_POST['user']);

//Insert event to events table
$event = "UPDATE events SET description='$description', is_ongoing='$is_ongoing', date_time_end='$end_date_time', user='$user' WHERE event_id='$event_id'";

$result = mysqli_query($conn, $event);
if($result){
	echo("Event updated, redirecting...");
	sleep (2);
	header('Location: ../index.php');
	exit();
} else{
	echo('Error! Please <a href="javascript:history.back()">go back</a> and try again');
}
?>
