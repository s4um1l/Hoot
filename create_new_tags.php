<?php
  session_start();
  if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
 mysql_select_db("hoot") or die(mysql_error()) ;
  $tag= $_POST['tag'];
  $type= $_POST['type'];
  $usrId= $_SESSION['userId'];
  $sql= "select max(tagId) as m from tags";
  $result1 = mysql_query($sql, $link);
  if (!$result1) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }
  while( $row1 = mysql_fetch_array( $result1 ) )
  {
    $var_tag=$row1["m"]+1;
    $sql= "INSERT INTO tags(tagId,tag,actionId) values ($var_tag,'$tag',$type)";
    $result2 = mysql_query($sql, $link);
      if (!$result2) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }
  } 
  
  $sql= "INSERT INTO userTags(userId,tagId) values ($usrId,$var_tag)";
  $result3 = mysql_query($sql, $link); 
  if (!$result3)
  {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
  } 

?>