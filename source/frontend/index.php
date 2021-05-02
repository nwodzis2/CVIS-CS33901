<?php session_start();
      if(!$_SESSION['authenticated']){
        header("location: ./login.php");
      }
  error_reporting(0);
?>
<?php
//populate graph
include_once("../backend/graphs.php");
$graph = new vaccineGraph();
$total_graph_data = $graph->get_campus_data("stark");
?>
<html>

  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script src="./js/main.js"></script>
    <meta charset="utf-8">
    <title><?php if($_SESSION['authenticated']){echo ucfirst($_SESSION['user']); echo "'s ";} ?>CVIS Dashboard</title>
    <link rel="shortcut icon" href="./images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    
  </head>
  <body>
  <script >
if(window.attachEvent) {
    window.attachEvent('onload', createCharts);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            createCHarts(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = createCharts;
    }
}

function createCharts(){
  var chartElement = document.createElement('div');
  chartElement.className = "col-md-6";
  chartElement.id = "campus_vac_chart";
  var row1 = document.getElementById('row-1');
  row1.appendChild(chartElement);
  var campusChart = LightweightCharts.createChart(chartElement, {
    width: chartElement.offsetWidth - 50,
    height: window.innerHeight / 2,
    layout: {
      fontFamily: 'Comic Sans MS',
    },
    rightPriceScale: {
      borderColor: 'rgba(197, 203, 206, 1)',
    },
    timeScale: {
      borderColor: 'rgba(197, 203, 206, 1)',
    },
  });
  
  row1.appendChild(chartElement);

  var areaSeries = campusChart.addAreaSeries({
    topColor: 'rgba(33, 150, 243, 0.56)',
    bottomColor: 'rgba(33, 150, 243, 0.04)',
    lineColor: 'rgba(33, 150, 243, 1)',
    lineWidth: 2,
});
*/
areaSeries.setData([
  <?php echo $total_graph_data; ?>
]);

}


  </script>
    <header id="header-main">
      <img id="kent-logo-nav" src="./images/kent-logo.png" alt="">
      <span id="ksu-hs-logo-nav-span"><img id="ksu-hs-logo-nav" src="./images/ksu-hs-logo.png" alt=""></span>
      <span id="fa-sign-out-alt-span"><a href=""><i id="sign-out-nav" class="fas fa-sign-out-alt"></i></a></span>
      <span id="fa-bar-span"><a href="javascript:void(0);" onclick="openLogin()"><i class="fas fa-bars"></i></a></span>
        <nav id="nav-main">
            <ol>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="appointment.php">Appointment</a></li>
                <li><a href="availability.php">Availability</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ol>
        </nav>

    </header>
    
    <main>
      <h1>CVIS DASHBOARD</h1>
      <div id="row-1" class="row">
      </div>
      <div class="row">
      </div>
    </main>
    <?php echo $total_graph_data; ?>
  </body>
</html>