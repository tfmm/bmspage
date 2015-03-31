<?php
//cleanup old sessions
gc_collect_cycles();
//start php session
session_start();
//if user not logged in, force to login.php
if( $_SESSION['access'] != 1 ) {
        require( 'login.php' );
} else {
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="shortcut icon" href="favicon.ico" />
		<title>BMS Events</title>
	</head>
<body>
	<div class=header>
		<h1>Liquidweb BMS Events</h1>
		<?php
			if(isset($_SESSION['uname'])) {
				echo "Hello, ";
				print_r($_SESSION['uname']);
			}
		include("includes/menu.php"); ?>
	</div>
	<div class=content>
		<h3>Current Ongoing Events</h3>
		<?php include "includes/db_config.php";
		$conn1 = new mysqli($servername, $username, $password, $db);
		if ($conn1->connect_error) {
			die("Connection Failed: " . $conn1->connect_error);
		}
		$sql1 = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id where is_ongoing=1;";
		$result1 = $conn1->query($sql1);
		if ($result1->num_rows >0){
			echo "<table align='center'><tr><th>Event ID</th><th>Unit</th><th>Alert</th><th>Start Date and Time</th><th>Description</th><th>End Date and Time</th><th>User</th><th>Edit</th></tr>";
			while ($row1 = $result1->fetch_assoc()) {
				echo "<tr><td><a href=https://utilities.mon.liquidweb.com/bms/viewevent.php?eventid=".$row1["event_id"]." target=_blank>".$row1["event_id"]."</a></td><td>".$row1["unit_name"]."</td><td>".$row1["alert_name"]."</td><td>".$row1["date_time_start"]."</td><td>".$row1["description"]."</td><td>".$row1["date_time_end"]."</td><td>".$row1["user"]."</td><td><a href=http://utilities.mon.liquidweb.com/bms/editevent.php?event_id=".$row1["event_id"]." target=blank>Edit</a></td></tr> ";
			}
			echo "</table>";
		} else {
			echo "<h5>No Ongoing Events at This Time</h5>";
		}
		if ($conn1->connect_error) {
		        die("Connection Failed: " . $conn2->connect_error);
		}
		$sql2 = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id where is_ongoing=0 ORDER BY date_time_end DESC LIMIT 10;";
		$result2 = $conn1->query($sql2);
		if ($result2->num_rows >0){
			echo "<h3>Previous 10 Events</h3>";
			echo "This does not include ongoing events.";
			echo "<table align='center'><tr><th>Event ID</th><th>Unit</th><th>Alert</th><th>Start Date and Time</th><th>Description</th><th>End Date and Time</th><th>User</th><th>Edit</th></tr>";
			while ($row2 = $result2->fetch_assoc()) {
			        echo "<tr><td><a href=https://utilities.mon.liquidweb.com/bms/viewevent.php?eventid=".$row2["event_id"]." target=_blank>".$row2["event_id"]."</a></td><td>".$row2["unit_name"]."</td><td>".$row2["alert_name"]."</td><td>".$row2["date_time_start"]."</td><td>".$row2["description"]."</td><td>".$row2["date_time_end"]."</td><td>".$row2["user"]."</td><td><a href=http://utilities.mon.liquidweb.com/bms/editevent.php?event_id=".$row2["event_id"]." target=blank>Edit</a></td></tr> ";
			}
			echo "</table>";
		} else {
			echo "<h3>Previous 10 Events</h3>";
		        echo "<h5>No Previous Events</h5>";
		}
		$conn1->close();
		?>
	</body>
</html>
<?php } ?>
