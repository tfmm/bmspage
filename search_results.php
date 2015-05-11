<?php
//start php session
session_start();
//if user not logged in, force to login.php
if( $_SESSION['access'] != 1 ) {
        require( 'login.php' );
} else {
        include "includes/db_config.php";
$conn = mysqli_connect($servername, $username, $password, $db);

$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$start_date_time = mysqli_real_escape_string($conn, $_POST['start_date_time']);
$end_date_time = mysqli_real_escape_string($conn, $_POST['end_date_time']);


if(!empty($unit)) {
	if(!empty($start_date_time)) {
		if(!empty($end_date_time)) {
			$query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE events.unit_id='$unit' AND date_time_start LIKE '%$start_date_time%' AND date_time_end LIKE '%$end_date_time%'";
		} else {
			$query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE events.unit_id='$unit' AND date_time_start LIKE '%$start_date_time%'";
		}
	} else {
		$query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE events.unit_id='$unit'";
	}
} else {
        if(!empty($start_date_time)) {
                if(!empty($end_date_time)) {
                        $query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE date_time_start LIKE '%$start_date_time%' AND date_time_end LIKE '%$end_date_time%'";
                } else {
                        $query = "SELECT * FROM events AS events INNER JOIN units AS units ON events.unit_id=units.unit_id INNER JOIN alerts as alerts ON events.alert_id=alerts.alert_id WHERE date_time_start LIKE '%$start_date_time%'";
		}
	}
}
$result = $conn->query($query);
if($result->num_rows >0){
?>
<html>
        <head>
                <link rel="stylesheet" type="text/css" href="css/style.css">
                <link rel="shortcut icon" href="favicon.ico" />
                <title>BMS Event Search Results</title>
        </head>
<body>
        <div class=header>
                <h1>BMS Events</h1>
                <?php
                        if(isset($_SESSION['uname'])) {
                                echo "Hello, ";
                                print_r($_SESSION['uname']);
                        }
			echo "<h2>Search Results</h2>";
		include("includes/menu.php"); ?>
        </div>
        <div class=content>
<br />
<?php
                if ($result->num_rows >0){
                echo "<table align='center'><tr><th>Event ID</th><th>Unit</th><th>Alert</th><th>Start Date and Time</th><th>Description</th><th>End Date and Time</th><th>User</th><th>Updates</th><th>Attachments</th><th>Edit</th></tr>";
		while ($row1 = $result->fetch_assoc()) {
                                echo "<tr><td>";
                                echo "<a href=viewevent.php?eventid=".$row1["event_id"]." target=_blank>".$row1["event_id"]."</a>";
                                echo "</td><td>";
                                print_r($row1["unit_name"]);
                                echo "</td><td>";
                                print_r($row1["alert_name"]);
                                echo "</td><td>";
                                print_r($row1["date_time_start"]);
                                echo "</td><td>";
                                echo nl2br($row1["description"]);
                                echo "</td><td>";
                                print_r($row1["date_time_end"]);
                                echo "</td><td>";
                                print_r($row1["user"]);
                                echo "</td><td>";
                                        $update_query = "SELECT update_desc, update_date_time, update_user, update_image FROM event_updates WHERE event_updates.event_id=".$row1["event_id"].";";
                                        $update_result = $conn->query($update_query);
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
                                if(empty($row1["event_image"])) {
                                        echo "";
                                } else {
                                        echo "<a href=".$row1["event_image"]." target=blank>Attachment</a>";
                                }
                                echo "</td><td>";
                                echo "<a href=editevent.php?event_id=".$row1["event_id"]." target=blank>Edit</a>";
                                echo "</td></tr>";
                        }
                        echo "</table>";
                        }


} else{
        echo('No Results Found! Please <a href="javascript:history.back()">Go back</a> and try again');
}
?>
</body>
</html>
<?php } ?>
