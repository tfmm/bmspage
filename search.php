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
		<script type="text/javascript" src="includes/jquery-2.1.3.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="includes/js/dtp/jquery.datetimepicker.css"/ >
		<script src="includes/js/dtp/jquery.js"></script>
		<script src="includes/js/dtp/jquery.datetimepicker.js"></script>
		<title>BMS Event Search</title>
		<script>
			$(function() {
				$('#start_date_time').datetimepicker({timepicker:false, format: 'Y/m/d'});
				$('#end_date_time').datetimepicker({timepicker:false, format: 'Y/m/d'});
			});
		</script>

    <script type="text/javascript">
        $(document).ready(function(){
                var queryString = $('select_form').serialize();
                $("select#utype").prop("disabled", true);
                        $("select#unit").prop("disabled", true);
                $("select#alert").prop("disabled", true);
                                $("select#datacenter").change(function(){
                                        $("select#utype").prop("disabled", true);
                                        /*$("select#utype").html("<option>wait...</option>");*/
                                        var dc_id = $("select#datacenter option:selected").val();
                                $.post("includes/select_utype.php", function(data){
                                        $("select#utype").prop("disabled", false);
                                        $("select#utype").html(data);
                        });
                        });
                        $("select#utype").change(function(){
                                $("select#unit").prop("disabled", true);
                                /*$("select#unit").html("<option>wait...</option>");*/
                                var utype_id = $("select#utype option:selected").val();
                                $.post("includes/select_unit.php", {utype_id:utype_id, dc_id:$('#datacenter').val()}, function(data){
                                        $("select#unit").prop("disabled", false);
                                        $("select#unit").html(data);
                                });
                        });
//                        $("select#unit").change(function(){
//                                $("select#alert").prop("disabled", true);
//                                var unit_id = $("select#unit option:selected").val();
//                                $.post("includes/select_alert.php", {utype_id:$('#utype').val()}, function(data){
//                                        $("select#alert").prop("disabled", false);
//                                        $("select#alert").html(data);
//                                });
//                        });
                        $("form#select_form").submit(function(){
                                var dc = $("select#datacenter option:selected").val();
                                var utype = $("select#utype option:selected").val();
                                if(cat>0 && type>0)
                                {
                                        var result = $("select#utype option:selected").html();
                                        $("#result").html('your choice: '+result);
                                }
                                else
                                {
                                        $("#result").html("you must choose a DC and Unit Type!");
                                }
                                return false;
                                var unit = $("select#unit option:selected").val();
                                if(cat>0 && type>0)
                                {
                                        var result = $("select#unit option:selected").html();
                                        $("#result").html('your choice: '+result);
                                }
                                else
                                {
                                        $("#result").html("you must choose a DC, Unit Type, Alert, and Unit!");
                                }
                                return false;
                        });
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
			echo "<h2>Search</h2>";
		include("includes/menu.php"); ?>
        </div>
	        <?php include "includes/classes/select.class.php";?>
		<br />
		<form id="select_form" required method="post" action="search_results.php">
			<table align="center">
				<tr>
					<td>
						Choose a DC:
					</td>
					<td>
						<select name="datacenter" id="datacenter">
							<?php echo $opt->ShowDCs(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Choose a Unit Type:
					</td>
					<td>
						<select name="utype" id="utype" >
							<?php echo $opt->ShowUnitType(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Choose a unit:
					</td>
					<td>
						<select name="unit" id="unit" >
							<?php echo $opt->ShowUnits(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Event Start Date:
					</td>
					<td>
						<input type="text" name="start_date_time" id="start_date_time" />
					</td>
				</tr>
				<tr>
					<td>
						Event End Date:
					</td>
					<td>
						<input type="text" name="end_date_time" id="end_date_time" />
					</td>
				</tr>
				<tr>
					<td colspan="2" class="ui-helper-center">
						<input type="submit" value="Search" />
					</td>
				</tr>
			</table>
		</form>
Search by Unit, start date, or end date of the event.  The form will accept any or all of these three options.
<br />
When entering start or end date, enter any portion of the value, and the search should return relevant data.
</body>
</html>
<?php } ?>
