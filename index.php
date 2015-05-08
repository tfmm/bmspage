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
		<h1>BMS Events</h1>
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
		$currently_ongoing_query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id where is_ongoing=1;";
		$currently_ongoing_result = $conn1->query($currently_ongoing_query);
		if ($currently_ongoing_result->num_rows >0){
			echo "<table align='center'><tr><th>Event ID</th><th>Unit</th><th>Alert</th><th>Start Date and Time</th><th>Description</th><th>End Date and Time</th><th>User</th><th>Updates</th><th>Attachments</th><th>Edit</th></tr>";
			while ($currently_ongoing_row = $currently_ongoing_result->fetch_assoc()) {
				echo "<tr><td>";
				echo "<a href=viewevent.php?eventid=".$currently_ongoing_row["event_id"]." target=_blank>".$currently_ongoing_row["event_id"]."</a>";
				echo "</td><td>";
				print_r($currently_ongoing_row["unit_name"]);
				echo "</td><td>";
				print_r($currently_ongoing_row["alert_name"]);
				echo "</td><td>";
				print_r($currently_ongoing_row["date_time_start"]);
				echo "</td><td>";
				echo nl2br($currently_ongoing_row["description"]);
				echo "</td><td>";
				print_r($currently_ongoing_row["date_time_end"]);
				echo "</td><td>";
				print_r($currently_ongoing_row["user"]);
				echo "</td><td>";
					$update_query = "SELECT update_desc, update_date_time, update_user, update_image FROM event_updates WHERE event_updates.event_id=".$currently_ongoing_row["event_id"].";";
					$update_result = $conn1->query($update_query);
					if ($update_result->num_rows >0){
						while ($update_row = $update_result->fetch_assoc()) {
							echo "<table align='center'><tr><td>";
							echo "Info: ";
							echo "</td><td>";
							echo nl2br($update_row['update_desc']);
							echo "</td></tr><tr><td>";
							echo "User: ";
							echo "</td><td>";
							print_r($update_row['update_user']);
							echo "</td></tr><tr><td>";
							echo "Time: ";
							echo "</td><td>";
							print_r($update_row['update_date_time']);
							echo "</td></tr>";
                                                        if(empty($update_row['update_image'])) {
                                                                echo "</table>";
                                                        } else {
                                                                echo "<tr><td>";
                                                                echo "Image: ";
                                                                echo "</td><td>";
                                                                echo "<a href=".$update_row['update_image']." target=blank>Attachment</a>";
                                                                echo "</td></tr></table>";
                                                        }
						}
						} else {
							echo "No updates to this event";
						}

                                echo "</td><td>";
				if(empty($currently_ongoing_row["event_image"])) {
					echo "";
				} else{
					echo "<a href=".$currently_ongoing_row["event_image"]." target=blank>Attachment</a>";
				}
                                echo "</td><td>";
				echo "<a href=editevent.php?event_id=".$currently_ongoing_row["event_id"]." target=blank>Edit</a></td></tr> ";
			}
			echo "</table>";
		} else {
			echo "<h5>No Ongoing Events at This Time</h5>";
		}
		if ($conn1->connect_error) {
		        die("Connection Failed: " . $conn1->connect_error);
		}
		$past_event_query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id where is_ongoing=0 ORDER BY date_time_end DESC LIMIT 10;";
		$past_event_result = $conn1->query($past_event_query);
		if ($past_event_result->num_rows >0){
			echo "<h3>Previous 10 Events</h3>";
			echo "This does not include ongoing events.";
			echo "<table align='center'><tr><th>Event ID</th><th>Unit</th><th>Alert</th><th>Start Date and Time</th><th>Description</th><th>End Date and Time</th><th>User</th><th>Updates</th><th>Attachments</th><th>Edit</th></tr>";
			while ($past_event_row = $past_event_result->fetch_assoc()) {
			        echo "<tr><td>";
				echo "<a href=viewevent.php?eventid=".$past_event_row["event_id"]." target=_blank>".$past_event_row["event_id"]."</a>";
				echo "</td><td>";
				print_r($past_event_row["unit_name"]);
				echo "</td><td>";
				print_r($past_event_row["alert_name"]);
				echo "</td><td>";
				print_r($past_event_row["date_time_start"]);
				echo "</td><td>";
				echo nl2br($past_event_row["description"]);
				echo "</td><td>";
				print_r($past_event_row["date_time_end"]);
				echo "</td><td>";
				print_r($past_event_row["user"]);
				echo "</td><td>";
                                        $update_query = "SELECT update_desc, update_date_time, update_user, update_image FROM event_updates WHERE event_updates.event_id=".$past_event_row["event_id"].";";
                                        $update_result = $conn1->query($update_query);
                                        if ($update_result->num_rows >0){
                                                while ($update_row = $update_result->fetch_assoc()) {
                                                        echo "<table align='center'><tr><td>";
                                                        echo "Info: ";
                                                        echo "</td><td>";
                                                        echo nl2br($update_row['update_desc']);
                                                        echo "</td></tr><tr><td>";
                                                        echo "User: ";
                                                        echo "</td><td>";
                                                        print_r($update_row['update_user']);
                                                        echo "</td></tr><tr><td>";
                                                        echo "Time: ";
                                                        echo "</td><td>";
                                                        print_r($update_row['update_date_time']);
                                                        echo "</td></tr>";
							if(empty($update_row['update_image'])) {
								echo "</table>";
							} else {
								echo "<tr><td>";
								echo "Image: ";
								echo "</td><td>";
								echo "<a href=".$update_row['update_image']." target=blank>Attachment</a>";
								echo "</td></tr></table>";
							}
                                                }
                                                } else {
                                                        echo "No updates to this event";
                                                }
                                echo "</td><td>";
				if(empty($past_event_row["event_image"])) {
					echo "";
				} else {
					echo "<a href=".$past_event_row["event_image"]." target=blank>Attachment</a>";
				}
                                echo "</td><td>";
				echo "<a href=editevent.php?event_id=".$past_event_row["event_id"]." target=blank>Edit</a>";
				echo "</td></tr>";
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
