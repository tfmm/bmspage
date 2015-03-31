<?php
session_start();
if( $_SESSION['access'] != 1 ) {
        require( 'login.php' );
} else {
        $uname=$_SESSION['uname'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="css/sestyle.css">
    <link rel="shortcut icon" href="favicon.ico" />
    <script type="text/javascript" src="includes/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="includes/js/dtp/jquery.datetimepicker.css"/ >
    <script src="includes/js/dtp/jquery.js"></script>
    <script src="includes/js/dtp/jquery.datetimepicker.js"></script>
    <title>Edit BMS Event</title>
    <script>
    $(function() {
      $('#start_date_time').datetimepicker();
      $('#end_date_time').datetimepicker();
    });
    </script>
    </head>
    <body>
	<div class=header>
		<h1>BMS Events</h1>
		<?php
			if(isset($_SESSION['uname'])) {
                                echo "Hello, ";
                                print_r($_SESSION['uname']);
                        }
			echo "<h2>Edit Event</h2>";
		include("includes/menu.php"); ?>
	</div>
	<div class=body>
	<?php include "includes/db_config.php";
		//Get Event ID from URL
		if(isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
			$varEvent = $_GET['event_id'];
		} else {
			$varEvent = 0;
		}

		$conn1 = new mysqli($servername, $username, $password, $db);
		if ($conn1->connect_error) {
			die ("Connection Failed: " . $conn1->connect_error);
		}
		$sql1 = "SELECT * FROM events WHERE event_id='".$varEvent."'";

		$result1 = $conn1->query($sql1);
		if ($result1->num_rows >=1) {
			while($row1 = $result1->fetch_assoc()) {
			$unitid=$row1['unit_id'];
			$starttimedate=$row1['date_time_start'];
			$desc=$row1['description'];
			$ongoing=$row1['is_ongoing'];
			$endtimedate=$row1['date_time_end'];
			$alertid=$row1['alert_id'];
			$eventid=$row1['event_id'];
		}
	include "includes/classes/select2.class.php"; ?>
	<br />
        <form id="select_form" required method="post" action="includes/update_event.php">
		<table align=center>
			<tr>
				<td>
			        Affected unit:
				</td>
				<td>
	<?php
                if ($conn1->connect_error) {
                        die ("Connection Failed: " . $conn1->connect_error);
                }
                $sql2 = "SELECT unit_name FROM units WHERE unit_id='".$unitid."'";

                $result2 = $conn1->query($sql2);
		if ($result2->num_rows >0) {
			while($row2 = $result2->fetch_assoc()) {
			$unitname=$row2['unit_name'];
		}
		} else {
			echo "Database Error";
		}
		echo $unitname;
	?>
				</td>
			</tr>
			<tr>
				<td>
					Alert:
				</td>
				<td>
	<?php
                if ($conn1->connect_error) {
                        die ("Connection Failed: " . $conn1->connect_error);
                }
                $sql3 = "SELECT alert_name FROM alerts WHERE alert_id='".$alertid."'";

                $result3 = $conn1->query($sql3);
                if ($result3->num_rows >0) {
                        while($row3 = $result3->fetch_assoc()) {
                        $alertname=$row3['alert_name'];
                }
                } else {
                        echo "Database Error";
                }
                echo $alertname;
		$conn1->close();
        ?>
				</td>
			</tr>
			<tr>
				<td>
					Start date and time:
				</td>
				<td>
	<?php
                echo $starttimedate;
        ?>
				</td>
			</tr>
			<tr>
				<td>
					Issue Description:
				</td>
				<td>
					<input type="text" name="description" id="description" required value="<?=$desc;?>" />
				</td>
			</tr>
			<tr>
				<td>
					Currently Ongoing?
				</td>
				<td>
	<?php
		if ($ongoing == 1) $checked= ' checked="true"';

	echo '<input type="checkbox" name="is_ongoing" id="is_ongoing" value="1"' . $checked .' />';
	?>
				</td>
			</tr>
			<tr>
				<td>
					End date and time:
				</td>
				<td>
				        <input type="text" name="end_date_time" id="end_date_time" value="<?=$endtimedate;?>" />
				</td>
			</tr>
			<tr>
				<td colspan=2 class="ui-helper-center">
				        <input type="submit" value="Submit" />
				</td>
			</tr>
		</table>
		You must press "Submit" to record the update!
        <input type="hidden" name="event" id="event" value="<?=$eventid;?>"/>
        <input type="hidden" name="user" id="user" value="<?=$uname;?>"/>
        </form>
	<?php
	}else{
		echo 'No entry found. <a href="javascript:history.back()">Go back</a>';
	}
	?>
	</div>
        <div id="result"></div>
    </body>
</html>
<?php } ?>
