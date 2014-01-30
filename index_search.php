<?php
session_start();
$userid = $_SESSION['userId'];
$usernm = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html>
  <head>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script>
      var currentText;
      var currentTab;
    </script>
    <title>Hoot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="icon" type="image/ico" href="hoot_logo.ico">
<!--to be removed after config file-->
     <?php 
 if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
 mysql_select_db("hoot") or die(mysql_error()) ; 
 ?> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      body { padding-top: 80px; }
      @media screen and (max-width: 768px) {
        body { padding-top: 0px; }
      }

      .form-control {
        padding: 6px 0px;
      }

      #chat_input_area {
        padding-right: 0px;
      }
      #chat_btns {
       padding: 0px; 
      }      
      .well
      {
          height: 100px
          max-height: 100px;
          overflow-y:scroll;
      }

    </style>
  </head>
  <body>
    

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="img/hoot_logo.png" width=25px /> Hoot </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">My Tags</a></li>
            <li><a href="#about">Settings</a></li>
            <li><a href="#logout" id="logout">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <form id="tag_search">
            <div class="input-group">
              <span class="input-group-addon">#</span>
              <input type="text" class="form-control" placeholder="Search for tags" id="tag_val">
            </div>
          </form>
        </div>
      </div>

      <br />
      <br />

      <div class="row">
        <div>
          <div class="col-lg-12">
            <ul class="nav nav-tabs" id="tag_tabs"></ul>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12" >
          <div class="well">
            <div id="mesg_area"></div>
          </div>
        </div>
      </div>

      <div class="row">
      <form action="post_process.php" method="GET" id="post">
        <div class="col-lg-10" id="chat_input_area">
          <input type="text" class="form-control" id="mesg" name="mesg" placeholder="Enter your message here" />
          <input type="hidden" name="actionId" id="actionId" />
          <input type="hidden" name="tagged" id="tagger" />
        </div>
        <div class="col-lg-2" id="chat_btns">
          <button type="button" class="btn btn-primary" id ="postSend">Send</button>
          
          Filter:
          <div class="btn-group">
            <button type="button" class="btn btn-success">Off</button>
            <button type="button" class="btn btn-default">On</button>
          </div>
        </div>
      </form>
      
      </div>
    </div>
 
    <script type="text/javascript">
      $("#postSend").click(function() {
        $var_text=$("#mesg").val();
         line=currentText.split(":");
          $("#actionId").val(line[1])  ;
           $("#tagger").val(line[0])  ;
        $("#post").submit();
         
      });
    </script>


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $("#tag_tabs").on("click", "a", function (e) {
            e.preventDefault();

            $(this).tab('show');
            currentText=$(this).attr("href");
            currentText=currentText.substr(1);
            currentTab = $(this);
        });
        registerCloseEvent();
        registerSearchButtonEvent();
      });

      function registerCloseEvent() {
        $(".close").click(function () {
          //there are multiple elements which has .closeTab icon so close the tab whose close icon is clicked
          var tabContentId = $(this).parent().attr("href");
          $(this).parent().parent().remove(); //remove li of tab
          $('#tag_tabs a:last').tab('show'); // Select first tab
          $(tabContentId).remove(); //remove respective tab content
        });
      }

function refreshDB()
      {
        <?php
        $sql    = "SELECT tagId FROM userTags WHERE userId = '". $userid ."' ";
        $result = mysql_query($sql, $link);

        if (!$result)
        {
          echo "DB Error, could not query the database\n";
          echo 'MySQL Error: ' . mysql_error();
          exit;
        }

        while ($row = mysql_fetch_assoc($result))
        {
          $sql2 = 'SELECT tag,actionId FROM tags WHERE tagId ='. $row['tagId'];
          $result1 = mysql_query($sql2, $link);
          if (!$result1)
          {
            echo "DB Error, could not query the database\n";
            echo 'MySQL Error: ' . mysql_error();
            exit;
          }
          while ($row1 = mysql_fetch_assoc($result1))
          {
            $sql    = 'SELECT action FROM action WHERE actionId ='. $row1['actionId'];
            $result2 = mysql_query($sql, $link);
            while ($row2 = mysql_fetch_assoc($result2))
            {
              ?>
              var js_var = "<?php echo $row1['tag'].':'.$row2['action'] ?>";
              $('.nav-tabs').append('<li><a href="#' + js_var +'"><button type="button" class="close" aria-hidden="true">&times;</button>' + js_var+ '</a></li>');
              $(this).tab('show');
              showTab(js_var);
              registerCloseEvent();
              <?php
            }  
          }
        }
        mysql_free_result($result); 
        mysql_free_result($result1);?>
      }

      $(document).ready(function() 
      {
        refreshTabs();    
      });

      function refreshTabs()
      {
        refreshDB();
        <?php
          $con=mysql_connect("localhost", "root", "fruit") or die(mysql_error());
          mysql_select_db("hoot") or die(mysql_error()) ; 
          $query = mysql_query("SELECT username, data, dateTime, tag FROM posts p, tags t, user u, userTags ut WHERE p.tagId = t.tagId AND u.userId = ut.userId AND ut.tagId = t.tagId AND ut.userId = p.userId AND tag = 'CS6233' ORDER BY dateTime ASC") or die(mysql_error());
          while($row = mysql_fetch_assoc($query))
          {
            ?>
            var name = "<?php echo $row['username'] ?>" ;
            var msg = "<?php echo $row['data'] ?>" ;
            $("#mesg_area").append("<b>"+ name + "</b>: " + msg + "<br />");
            <?php
          }
        ?>
      }

      function registerSearchButtonEvent() {
        $('#tag_search').submit(function (e) {
          e.preventDefault();
          var tabId = $('#tag_val').val(); //this is id on tab content div where the 
          
          $('.nav-tabs').append('<li><a href="#' + tabId + '"><button type="button" class="close" aria-hidden="true">&times;</button>' + tabId + '</a></li>');
           <?php 
          $sql="SELECT tag from tags";
          
          $result=mysql_query($sql,$link);
            if (!$result)
        {
          echo "DB Error, could not query the database\n";
          echo 'MySQL Error: ' . mysql_error();
          exit;
        }
          $input="algo";
          $row = array();
          while( $row[] = mysql_fetch_array( $result ) );
          // no shortest distance found, yet
$shortest = -1;

// loop through words to find the closest
foreach ($row as $word) {

    // calculate the distance between the input word,
    // and the current word
    $lev = levenshtein($input, $word['tag']);
    similar_text(strtoupper($input), strtoupper($word['tag']), $similarity_pst); 
    similar_text(strtoupper($word['tag']), strtoupper($input), $similarity_pst1); 
    // check for an exact match
    if ($lev == 0) {

        // closest word is this one (exact match)
        $closest = $word['$tag'];
        $shortest = 0;

        // break out of the loop; we've found an exact match
        break;
    }
    if ($similarity_pst>50 ||$similarity_pst1>50)
      echo "Did you mean:'". $word['tag']."'?\n";
    // if this distance is less than the next found shortest
    // distance, OR if a next shortest word has not yet been found
    if ($lev <= $shortest || $shortest < 0) {
        // set the closest match, and shortest distance
        $closest  = $word['tag'];
        $shortest = $lev;
    }
}

echo "Input word: $input\n";
if ($shortest == 0) {
    echo "Exact match found: $closest\n";
} else {
    echo "Did you mean: $closest?\n";
}
          ?>
          $(this).tab('show');
          showTab(tabId);
          registerCloseEvent();
          $('#tag_val').val("");
        });
      }

      function showTab(tabId) {
        $('#tag_tabs a[href="#' + tabId + '"]').tab('show');
      }
      function getCurrentTab() {
        return currentTab;
      }

      $("#logout").click(function (e) {
        e.preventDefault();
          <?php
            unset($_SESSION['userId']);
            unset($_SESSION['userName']);
            session_destroy();
          ?>
          window.location = "login.php";
        });

    </script>
  </body>
</html>

<!-- Fiddle for tabs http://jsfiddle.net/vinodlouis/pb6EM/1/ -->