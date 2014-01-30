<?php
  session_start();
  if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
  mysql_select_db("hoot") or die(mysql_error()) ;
  $usr= $_POST['userId'];
  $tag= $_POST['tagId'];
  $result=mysql_query("delete from userTags where userId = ". $usr . " and tagId = " . $tag ,$link);
?>