<?php
session_start();
  $con=mysql_connect("localhost", "root", "fruit") or die(mysql_error());
  mysql_select_db("hoot") or die(mysql_error()) ; 
  $tag = $_POST['tag'];
  $sql = "SELECT username, data, dateTime, tag FROM posts p, tags t, user u WHERE p.tagId = t.tagId AND p.userId=u.userId AND p.tagid = '$tag' ORDER BY dateTime ASC" ;
  $query = mysql_query($sql) or die(mysql_error());
  $arr =  array();
  while($row = mysql_fetch_assoc($query))
  {
     array_push($arr, $row);
  }
  echo json_encode($arr);
?>