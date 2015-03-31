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
		//	echo "Datacenter: ";
		//	$row1['dc_name'];
			echo "Unit: ";
			print_r($row1['unit_name']);
                        echo "<br />";
			echo "Alert: ";
			print_r($row1['alert_name']);
                        echo "<br />";
			echo "Start Date and Time: ";
			print_r($row1['date_time_start']);
                        echo "<br />";
			echo "Currently Ongoing? ";
				if($row1['is_ongoing'] ==1) {
					echo "Yes";
				} else {
					echo "No";
				}
                        echo "<br />";
			echo "End Date and Time: ";
			print_r($row1['date_time_end']);
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
