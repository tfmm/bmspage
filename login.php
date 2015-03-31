<?php
include("includes/login-post.php");
 
// check to see if user is logging out
if(isset($_GET['out'])) {
	// destroy session
	session_unset();
	$_SESSION = array();
	unset($_SESSION['uname'],$_SESSION['access']);
	session_destroy();
}
 
// check to see if login form has been submitted
if(isset($_POST['userLogin'])){
	// run information through authenticator
	if(authenticate($_POST['userLogin'],$_POST['userPassword']))
	{
		// authentication passed
		header("Location: index.php");
		die();
	} else {
		// authentication failed
		$error = 1;
	}
}
 
// output error to user
if (isset($error)) echo "Login failed: Incorrect user name, password, or rights<br /-->";
 
// output logout success
if (isset($_GET['out'])) echo "Logout successful";
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="shortcut icon" href="favicon.ico" />
		<title>BMS Event Login</title>
	</head>
	<body>	
		<div class=header>
			<h1>Liquidweb BMS Events</h1>
			<?php include("includes/menu.php"); ?>
		</div>
		<div class=content>
			<h2>Please Login with LDAP</h2> 
			<form action="login.php" method="post">
				<table align='center'>
					<tr>
						<th colspan='2'>
							Please Login with LDAP
						</th>
					</tr>
					<tr>
						<td>
							Username: 
						</td>
						<td>
							<input type="text" name="userLogin" />
						</td>
					</tr>
					<tr>
						<td>
							Password: 
						</td>
						<td>
							<input type="password" name="userPassword" />
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<input type="submit" name="submit" value="Login" />
						</td>
					</tr>
				</table>
			</form>
			You will be returned to the main BMS status page after login.
		</div>	
	</body>
</html>
