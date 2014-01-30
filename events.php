<?php
echo ("Hi");
if(!$link=mysql_connect("localhost", "root", "fruit") )
  die(mysql_error()) ; 
 mysql_select_db("hoot") or die(mysql_error()) ;
 $result=mysql_query("SELECT tag,t.tagId,COUNT( * ) AS c
FROM posts p ,tags t
where p.tagId = t.tagId
GROUP BY tagId"  ,$link);
 $output=array();
 $output1=array();
while($e=mysql_fetch_assoc($result)){
    array_push($output1,$e['tagId'] );
    array_push($output1,$e['c'] );
    // array_push($output,$output1);
    //array_pop($output1);
    // array_pop($output1);
     }
echo "[".json_encode($output1)."]" ; 
?>
<style type="text/css">
    * { padding: 0; margin: 0; vertical-align: top; }

body {
    background: url(background.png) repeat-x;
    font: 18px/1.5em "proxima-nova", Helvetica, Arial, sans-serif;
}

a { color: #069; }
a:hover { color: #28b; }

h2 {
    margin-top: 15px;
    font: normal 32px "omnes-pro", Helvetica, Arial, sans-serif;
}

h3 {
    margin-left: 30px;
    font: normal 26px "omnes-pro", Helvetica, Arial, sans-serif;
    color: #666;
}

p {
    margin-top: 10px;
}

button {
    font-size: 18px;
    padding: 1px 7px;
}

input {
    font-size: 18px;
}

input[type=checkbox] {
    margin: 7px;
}

#header {
    position: relative;
    width: 900px;
    margin: auto;
}

#header h2 {
    margin-left: 10px;
    vertical-align: middle;
    font-size: 42px;
    font-weight: bold;
    text-decoration: none;
    color: #000;
}

#content {
    width: 880px;
    margin: 0 auto;
    padding: 10px;
}

#footer {
    margin-top: 25px;
    margin-bottom: 10px;
    text-align: center;
    font-size: 12px;
    color: #999;
}

.demo-container {
    box-sizing: border-box;
    width: 850px;
    height: 450px;
    padding: 20px 15px 15px 15px;
    margin: 15px auto 30px auto;
    border: 1px solid #ddd;
    background: #fff;
    background: linear-gradient(#f6f6f6 0, #fff 50px);
    background: -o-linear-gradient(#f6f6f6 0, #fff 50px);
    background: -ms-linear-gradient(#f6f6f6 0, #fff 50px);
    background: -moz-linear-gradient(#f6f6f6 0, #fff 50px);
    background: -webkit-linear-gradient(#f6f6f6 0, #fff 50px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    -o-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    -ms-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    -moz-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    -webkit-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.demo-placeholder {
    width: 100%;
    height: 100%;
    font-size: 14px;
    line-height: 1.2em;
}

.legend table {
    border-spacing: 5px;
}
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Flot Examples: Stacking</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
       google.load('visualization', '1', {'packages':['corechart']});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
      var jsonData = <?php echo json_encode($output1) ; ?>;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 400, height: 240});
    }
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../../excanvas.min.js"></script><![endif]-->
    
    <script src="https://code.jquery.com/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>
  
    <script type="text/javascript">

    $(function() {

        var d2 = <?php echo json_encode($output1) ; ?>;

        alert(d2);

        var stack = 0,
            bars = true,
            lines = false,
            steps = false;

        function plotWithOptions() {
            $.plot("#placeholder", [d2], {
                series: {
                    stack: stack,
                    lines: {
                        show: lines,
                        fill: true,
                        steps: steps
                    },
                    bars: {
                        show: bars,
                        barWidth: 0.6
                    }
                }
            });
        }

        plotWithOptions();

        $(".stackControls button").click(function (e) {
            e.preventDefault();
            stack = $(this).text() == "With stacking" ? true : null;
            plotWithOptions();
        });

        $(".graphControls button").click(function (e) {
            e.preventDefault();
            bars = $(this).text().indexOf("Bars") != -1;
            lines = $(this).text().indexOf("Lines") != -1;
            steps = $(this).text().indexOf("steps") != -1;
            plotWithOptions();
        });

        // Add the Flot version string to the footer

        $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
    });

    </script>
</head>
<body>

    <div id="header">
        <h2>Stacking</h2>
    </div>
  
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
 
    <div id="content">

        <div class="demo-container">
            <div id="placeholder" class="demo-placeholder"></div>
        </div>

    </div>
</body>
</html>

    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
