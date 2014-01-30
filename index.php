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

      .well
      {
          height: 340px;
          overflow-y:scroll;
      }
      #nm
      {
        text-decoration: none;
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
            <li class="active"><a href="#" id="nm" style="cursor:pointer;"><?php echo $usernm ; ?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-10">
          <form id="tag_search">
            <div class="input-group">
              <span class="input-group-addon">#</span>
              <input type="text" class="form-control" placeholder="Search for tags" id="tag_val">
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-lg-2">
            <select class="form-control" id="tagType">
              <option value="2">Discussion</option>
              <option value="1">Buy/Sell</option>
              <option value="3">Career Opportunities</option>
              <option value="4">Group</option>
              <option value="5">Misc</option>
            </select>
          </div>
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
      <form id="post">
        <div class="col-lg-11" id="chat_input_area">
          <input type="text" class="form-control" id="mesg" name="mesg" placeholder="Enter your message here" />
          <input type="hidden" name="actionId" id="actionId" />
          <input type="hidden" name="tagged" id="tagger" />
        </div>
        <div class="col-lg-1" id="chat_btns">
          <button type="button" class="btn btn-primary" id ="postSend">Send</button>
        </div>
      </form>
      
      </div>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">New Tag?</h4>
            </div>
            <div id="modal_text">
              
            </div>
            <form id="new_tag_frm">
              <div class="modal-body">
                <label for="new_tag">A similar tag already exists. Either pick one or you can create a new tag if you wish</label>
                <select class="form-control" id="new_tag" name="new_tag">
                  
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="create_new_tag">Create tag</button>
              </div>
            </form>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    </div>
 
    <script type="text/javascript">
      $("#post").submit(function(e) {
        e.preventDefault();
        $var_text=$("#mesg").val();
        $line=currentText.split(":");
        //   $("#actionId").val(line[1])  ;
        //    $("#tagger").val(line[0])  ;
        // $("#post").submit();
        $.ajax({
          url: 'post_process.php',
          data: { mesg: $var_text, actionId: $line[1], tagged: $line[0] } ,
          type: "post",
          dataType: 'json',
          success: function(data)
          {
            //alert(JSON.stringify(data));
            refreshTabs();
            $("#mesg").val("");
          } 
        });
         
      });

      $("#create_new_tag").click(function() {
        $tag_text=$("#new_tag").val();
        var tabtype = $('#tagType').val();
        if($tag_text=="0")
        {
          $tag_text = $("#new_tag option:selected").text();
          var tabtype = $('#tagType').val();
          $.ajax({
            url: 'create_new_tags.php',
            data: { type: tabtype, tag: $tag_text } ,
            type: "post",
            async: false,
            dataType: 'json',
            success: function(data)
            {
              //alert(JSON.stringify(data));
              // $('#myModal').modal('toggle');
              // refreshTabs();
            }
          });
        }
        else
        {
          var tabtype1 = $('#tagType').val();
          $.ajax({
            url: 'add_tag.php',
            data: { type: tabtype1, tag: $tag_text } ,
            type: "post",
            async: false,
            dataType: 'json',
            success: function(data)
            {
              // alert(JSON.stringify(data));
              // $('#myModal').modal('toggle');
              // refreshTabs();
            }
          });
        }
        location.reload(); 
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
            refreshTabs();
            // $(this).tab('show');
            showTab(currentText);
            registerCloseEvent();
            //registerSearchButtonEvent();
        });
       
      });

      function registerCloseEvent() {
        $(".close").click(function () {
          //there are multiple elements which has .closeTab icon so close the tab whose close icon is clicked
          var tabContentId1 = $(this).parent().attr("href").substr(1);
          var tabContentId = $(this).parent().attr("href");
          var tag_id;
          $line=tabContentId1.split(":");
          $.ajax({
            url: 'get_tagid.php',
            data: { actionId: $line[1], tagged: $line[0] } ,
            type: "post",
            async: false,
            dataType: 'json',
            success: function(data)
            {
              tag_id = data[0];
            } 
          });
          $usrid = "<?php echo $userid ?>";
          $.ajax({
            url: 'remove.php',
            data: { userId: $usrid , tagId: tag_id } ,
            type: "post",
            async: false,
            dataType: 'json',
            success: function(data)
            {
              refreshDB();
              $(this).parent().parent().remove(); //remove li of tab
              $('#tag_tabs:nth-child(2) a').tab('show'); // Select first tab
              currentText=$("#tag_tabs:nth-child(2) a").attr("href").substr(1);
              currentTab=$("#tag_tabs:nth-child(2) a");          
              showTab(tabContentId1);
            }
          });

          location.reload(); 
          // $("#tag_tabs").empty();
          
          // alert(currentText);
          // refreshTabs();

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
              // $(this).tab('show');
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
        refreshDB();
        currentText=$("#tag_tabs:first-child a").attr("href");
        currentText=currentText.substr(1);
        currentTab=$("#tag_tabs:first-child a");
        // alert(currentText);
        refreshTabs();
      });

      function refreshTabs()
      {
        var tag_id;
        $line=currentText.split(":");
        $.ajax({
          url: 'get_tagid.php',
          data: { actionId: $line[1], tagged: $line[0] } ,
          type: "post",
          async: false,
          dataType: 'json',
          success: function(data)
          {
            tag_id = data[0];
          } 
        });
        $("#tag_tabs").empty();
        refreshDB();
        // currentTab.tab('show');
        showTab(currentText);
        $("#mesg_area").empty();
        $.ajax({
          url: 'fetch_tab.php',
          data: { tag: tag_id } ,
          type: "post",
          async:false,
          dataType: 'json',
          success: function(data)
          {
            for (var i = 0; i < data.length; i++)
            {
              $("#mesg_area").append("<b>"+ data[i].username + "</b>: " + data[i].data + "<br />");
            }
          } 
        });
      }

      //function registerSearchButtonEvent() {
        $('#tag_search').submit(function (e) {
          e.preventDefault();
         // alert("Hi");
          var tabId = $('#tag_val').val(); //this is id on tab content div where the 
          var tabtype = $('#tagType').val();
         // alert(tabId);
          $.ajax({
          url: 'search.php',
          data: { search_text: tabId , type: tabtype } ,
          type: "post",
          async: false ,
          dataType: 'json',
          success: function(data)
          {
            if (data.length==0){
              $('.nav-tabs').append('<li><a href="#' + tabId + ":" + $('#tagType option:selected').text() +'"><button type="button" class="close" aria-hidden="true">&times;</button>' + tabId +  ":" + $('#tagType option:selected').text() + '</a></li>');
      
             }
             else
             {
                $('#new_tag').append("<option value='0'>" +tabId+"</option>" );
                for (n = 0; n < data.length; ++n)
                {
                  $('#new_tag').append("<option value='"+data[n]+"'>" +data[n]+"</option>" );
                }
                $('#myModal').modal('show');
             }
          } 
          });
          // $(this).tab('show');
          // showTab(tabId);
          registerCloseEvent();
          $('#tag_val').val("");
        });
     // }

      function showTab(tabId) {
        $('#tag_tabs a[href="#' + tabId + '"]').tab('show');
      }
      function getCurrentTab() {
        return currentTab;
      }

      $("#logout").click(function () {
        alert("1");
          // $.ajax({
          //   url: 'logout.php'
          //   success: function(data)
          //   {
          //     window.location = "login.php";            
          //   }
          // });
        });

    </script>
  </body>
</html>

<!-- Fiddle for tabs http://jsfiddle.net/vinodlouis/pb6EM/1/ -->