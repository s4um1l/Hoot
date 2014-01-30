<?php
session_start();
if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
 mysql_select_db("hoot") or die(mysql_error()) ; 
$action= $_POST['actionId'];
$tag= $_POST['tagged'];
$sql    = "SELECT actionId FROM action WHERE action ='".$action."'";
$result = mysql_query($sql, $link);
if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
   $sql    = "SELECT tagId FROM tags WHERE tag ='".$tag."' AND actionId = '".$row["actionId"]."'";
   // echo $sql;
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
}

echo json_encode($tagId);
?>