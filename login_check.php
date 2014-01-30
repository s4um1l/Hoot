<?php
session_start();
$con=mysql_connect("localhost", "root", "fruit") or die(mysql_error());
mysql_select_db("hoot") or die(mysql_error()) ; 
$email = mysql_real_escape_string($_POST["email"]);
$pass = $_POST["pass"];
$check = mysql_query("SELECT * FROM user WHERE emailId = '$email'") or die(mysql_error());
while($info = mysql_fetch_array( $check )) 	
{
	$_SESSION['userName'] = $info['userName'];
	$_SESSION['userId'] = $info['userId'];
	if (md5($pass) != $info['userPassword']) 
	{
		header("Location: login.php");
		echo "Invalid username/password" ;
	}
 	else
 	{
 		mysql_close($con);
 		if(isset($_SESSION['userId']))
 			header("Location: index.php");
 	}
}
?>