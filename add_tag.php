<?php
session_start();
  if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
  mysql_select_db("hoot") or die(mysql_error()) ;
  $tag= $_POST['tag'];
  $type= $_POST['type'];
  $usrId= $_SESSION['userId'];
  // var tagId;
  $sql    = "SELECT tagId FROM tags WHERE tag ='".$tag."' AND actionId = ".$type;
  $result1 = mysql_query($sql, $link);
  if (!$result1) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }
  while ($row1 = mysql_fetch_assoc($result1)){
    $tagId=$row1['tagId'];
    $data=$_POST["mesg"];
  }
  
  $sql= "INSERT INTO userTags(userId,tagId) values ('$usrId','$tagId')";
  $result2 = mysql_query($sql, $link); 
  if (!$result2)
  {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
  } 
  // echo json_encode($sql);
?>