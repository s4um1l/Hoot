<?php
  session_start();
  if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
 mysql_select_db("hoot") or die(mysql_error()) ;
  $search= $_POST['search_text'];
  $type= $_POST['type'];
  $result=mysql_query("SELECT tag from tags where actionId = ". $type  ,$link);
  $ret=array();
  $shortest = -1;

while( $row = mysql_fetch_array( $result ) ){

      similar_text(strtoupper($search), strtoupper($row['tag']), $similarity_pst); 
      similar_text(strtoupper($row['tag']), strtoupper($search), $similarity_pst1); 
      if (number_format($similarity_pst, 0) > 50||number_format($similarity_pst1, 0) > 50){ 
          array_push($ret, $row['tag']);
      	}
    //  $lev = levenshtein($search, $row['tag']);

    // // check for an exact match
    // if ($lev == 0) {

    //     // closest word is this one (exact match)
    //     $closest =  $row['tag'];
    //     $shortest = 0;

    //     // break out of the loop; we've found an exact match
    //     break;
    // }

    // // if this distance is less than the next found shortest
    // // distance, OR if a next shortest word has not yet been found
    // if ($lev <= $shortest || $shortest < 0) {
    //     // set the closest match, and shortest distance
    //     $closest  =  $row['tag'];
    //     $shortest = $lev;
    // }
    // // array_push($ret, $closest);
}
array_unique($ret);
if (sizeof($ret)==0){

			 $sql= "select max(tagId) as m from tags";
              $result2 = mysql_query($sql, $link);
                 if (!$result2) {
              echo "DB Error, could not query the database\n";
              echo 'MySQL Error: ' . mysql_error();
              exit;
            } 
            while( $row2 = mysql_fetch_array( $result2 ) ){
             	$var_tag=$row2["m"]+1;
             $sql= "INSERT INTO tags(tagId,tag,actionId) values ('$var_tag','$search','$type')";
              $result2 = mysql_query($sql, $link);
                 if (!$result2) {
              echo "DB Error, could not query the database\n";
              echo 'MySQL Error: ' . mysql_error();
              exit;
            }
            } 
   //          
            	$user=$_SESSION["userId"];
   	$sql= "INSERT INTO userTags(userId,tagId) values ('$user','$var_tag')";
              $result2 = mysql_query($sql, $link); 
               if (!$result2) {
              echo "DB Error, could not query the database\n";
              echo 'MySQL Error: ' . mysql_error();
              exit;
            } 
   //          }

      
 
}

 echo json_encode($ret);

?>