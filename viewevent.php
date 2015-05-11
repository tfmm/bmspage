<?php
//start php session
session_start();
//if user not logged in, force to login.php
if( $_SESSION['access'] != 1 ) {
        require( 'login.php' );
} else {

?>
<html>
        <head>
                <link rel="stylesheet" type="text/css" href="css/sestyle.css">
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
			echo "<h2>View Event</h2>";
		include("includes/menu.php"); ?>
        </div>
        <div class=content>
<?php include "includes/db_config.php";
$eventid=$_GET['eventid'];
                $conn1 = new mysqli($servername, $username, $password, $db);
                if ($conn1->connect_error) {
                        die("Connection Failed: " . $conn1->connect_error);
                }
                $sql1 = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE events.event_id=".$eventid.";";
                $result1 = $conn1->query($sql1);
                if ($result1->num_rows >0){
                        while ($row1 = $result1->fetch_assoc()) {
			echo "<br />";
			echo "<table align='center'><tr><td>";
			echo "Unit: ";
			echo "</td><td>";
			print_r($row1['unit_name']);
                        echo "</td></tr><tr><td>";
			echo "Alert: ";
			echo "</td><td>";
			print_r($row1['alert_name']);
			echo "</td></tr><tr><td>";
			echo "Description: ";
			echo "</td><td>";
			echo nl2br($row1['description']);
			echo "</td></tr><tr><td>";
			echo "Start Date and Time: ";
			echo "</td><td>";
			print_r($row1['date_time_start']);
                        echo "</td></tr><tr><td>";
			echo "Currently Ongoing? ";
			echo "</td><td>";
				if($row1['is_ongoing'] ==1) {
					echo "Yes";
				} else {
					echo "No";
				}
                        echo "</td></tr><tr><td>";
			echo "End Date and Time: ";
			echo "</td><td>";
			print_r($row1['date_time_end']);
			echo "</td></tr>";
			echo "<tr><td>";
			echo "Event Updates:";
			echo "</td><td>";
				$update_query = "SELECT update_desc, update_date_time, update_user FROM event_updates WHERE event_updates.event_id=".$eventid.";";
				$update_result = $conn1->query($update_query);
				if ($update_result->num_rows >0){
					while ($update_row = $update_result->fetch_assoc()) {
						echo "<table align='center'><tr><td>";
						echo "Update Desc: ";
						echo "</td><td>";
						echo nl2br($update_row['update_desc']);
						echo "</td></tr><tr><td>";
						echo "Update User: ";
						echo "</td><td>";
						print_r($update_row['update_user']);
						echo "</td></tr><tr><td>";
						echo "Update Date and Time: ";
						echo "</td><td>";
						print_r($update_row['update_date_time']);
						if(empty($update_row['update_image'])) {
							echo "</td></tr></table>";
						} else {
							echo "<tr><td>";
							echo "Image: ";
							echo "</td><td>";
							echo "<a href=".$update_row['update_image']." target=blank>Attachment</a>";
						}
					}
					} else {
						echo "No updates to this event";
					}
			echo "</td></tr>";
			if(empty($row1['event_image'])) {
	                        echo "<tr><td colspan='2' class='ui-helper-center'>";
        	                echo "<a href=editevent.php?event_id=".$row1['event_id'].">Edit Event</a>";
                	        echo "</td></tr></table>";
			} else {
                        echo "<tr><td>";
			echo "Attachments:";
			echo "</td><td>";
			echo "<a href=".$row1['event_image']." target=blank>Attachment</a>";
			echo "<tr><td colspan='2' class='ui-helper-center'>";
			echo "<a href=editevent.php?event_id=".$row1['event_id'].">Edit Event</a>";
			echo "</td></tr></table>";
			}
		}
		} else {
                        echo "<h4>ERROR Event ID Not Found</h4>";
                }
                if ($conn1->connect_error) {
                        die("Connection Failed: " . $conn1->connect_error);
                }
?>
</div>
</body>
</html>
<?php } ?>
