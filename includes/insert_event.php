<?php
	include "db_config.php";
$conn = mysqli_connect($servername, $username, $password, $db);

$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$start_date_time = mysqli_real_escape_string($conn, $_POST['start_date_time']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$is_ongoing = mysqli_real_escape_string($conn, $_POST['is_ongoing']);
$end_date_time = mysqli_real_escape_string($conn, $_POST['end_date_time']);
$alert = mysqli_real_escape_string($conn, $_POST['alert']);
$user = mysqli_real_escape_string($conn, $_POST['user']);

//Insert event to events table
$event = "INSERT INTO events (unit_id, date_time_start, description, is_ongoing, date_time_end, alert_id, user) VALUES ('$unit','$start_date_time', '$description', '$is_ongoing', '$end_date_time', '$alert', '$user')";

$result = mysqli_query($conn, $event);
if($result){
	echo("Event added, redirecting...");
	sleep (2);
	header('Location: ../index.php');
	exit();
} else{
	echo('Error! Please <a href="javascript:history.back()">go back</a> and try again');
}
?>
