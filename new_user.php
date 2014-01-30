<?php
session_start();
$con=mysql_connect("localhost", "root", "fruit") or die(mysql_error());
mysql_select_db("hoot") or die(mysql_error()) ; 
$email = mysql_real_escape_string($_POST["new_email"]);
$user = mysql_real_escape_string($_POST["username"]);
$pass = mysql_real_escape_string(md5($_POST["new_pass"]));

$sql="INSERT INTO user (userName, userPassword, emailId, dateJoining) VALUES ('$user','$pass','$email', NOW() )";
$retval = mysql_query($sql, $con) ; 
if(!retval)
{
  die('Error: ' . mysql_error($con));
  session_destroy();
}
$_SESSION['userName'] = $_POST["username"];
$_SESSION['userId'] = $_POST["new_pass"];
mysql_close($con);
header("Location: index.php");
?>