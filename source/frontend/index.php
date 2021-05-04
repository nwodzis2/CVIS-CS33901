<?php session_start();
      if(!$_SESSION['authenticated']){
        header("location: ./login.php");
      }
  //error_reporting(0);
?>
<?php
$user = $_SESSION['user'];


//populate graph
include_once("../backend/graphs.php");
$graph = new vaccineGraph();

//add to every page at top, this is the name that you click for active user
$user = $_SESSION['user'];
    echo "<div class='above-nav'>";
    echo "Signed in as <strong>" . '<a href="user_details.php">'.$user ."</a> </strong>";
    echo "</div>";
//end active user

$total_graph_data = $graph->get_total_data();
$kent_graph_data = $graph->get_total_data();
$stark_graph_data = $graph->get_campus_data("stark");
$ashtabula_graph_data = $graph->get_campus_data("ashtabula");
$eastliverpool_graph_data = $graph->get_campus_data("eastliverpool");
$salem_graph_data = $graph->get_campus_data("salem");
$geauga_graph_data = $graph->get_campus_data("geauga");
$trumbull_graph_data = $graph->get_campus_data("trumbull");
$tuscarawas_graph_data = $graph->get_campus_data("tuscarawas");
?>
<html>

  <head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script src="./js/main.js"></script>
    <meta charset="utf-8">
    <title><?php if($_SESSION['authenticated']){echo ucfirst($_SESSION['user']); echo "'s ";} ?>CVIS Dashboard</title>
    <link rel="shortcut icon" href="./images/favicon.ico"> <!--From kent state's website, property of kent state. Using for educational purpose only-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script   src="https://code.jquery.com/jquery-3.6.0.js"   integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="   crossorigin="anonymous"></script>
    
  </head>
  <body>
  <script >
    var thesignout = {signout: true};
    function signOut(){
      $.ajax({
        method: "POST",
        data: thesignout,
        success: function(){},
        error: function(){
                console.log("error")
            }
    });

    }
if(window.attachEvent) {
    window.attachEvent('onload', createCharts);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            createCharts(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = createCharts;
    }
}
var areaSeries;
var value = total;
function createCharts(){ //using trading views charts
  
  
  value = document.getElementById('campus-graph-select').value;
  var chartElement = document.createElement('div');
  chartElement.className = "col-md-6 campus_vac_chart";
  chartElement.id = "campus_vac_chart";
  var row1 = document.getElementById('row-1');
  row1.appendChild(chartElement);
  var campusChart = LightweightCharts.createChart(chartElement, {
    width: chartElement.offsetWidth - 70,
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
  
  //row1.appendChild(chartElement);

  areaSeries = campusChart.addAreaSeries({
    topColor: 'rgba(33, 150, 243, 0.56)',
    bottomColor: 'rgba(33, 150, 243, 0.04)',
    lineColor: 'rgba(33, 150, 243, 1)',
    lineWidth: 2,
});
areaSeries.setData([]);
switch(value){
    
    case "total":
      areaSeries.setData([
    <?php echo $total_graph_data; ?>
    ]);
      break;
    case "kent":
      areaSeries.setData([
    <?php echo $kent_graph_data; ?>
    ]);
      break;
    case "stark":
      areaSeries.setData([
    <?php echo $stark_graph_data; ?>
    ]);
      break;
    case "ashtabula":
      areaSeries.setData([
    <?php echo $ashtabula_graph_data; ?>
    ]);
      break;
    case "eastliverpool":
      areaSeries.setData([
    <?php echo $eastliverpool_graph_data; ?>
    ]);
      break;
    case "salem":
      areaSeries.setData([
    <?php echo $salem_graph_data; ?>
    ]);
      break;
    case "geauga":
      areaSeries.setData([
    <?php echo $geauga_graph_data; ?>
    ]);
      break;
    case "trumbull":
      areaSeries.setData([
    <?php echo $trumbull_graph_data; ?>
    ]);
      break;
    case "tuscarawas":
      areaSeries.setData([
    <?php echo $tuscarawas_graph_data; ?>
    ]);
      break;
    default:
      areaSeries.setData([
    <?php echo $total_graph_data; ?>
    ]);
    break
  }
}
function createCharts2(){
  
  areaSeries.setData([]);
  value = document.getElementById('campus-graph-select').value;
  switch(value){
    case "total":
      areaSeries.setData([
    <?php echo $total_graph_data; ?>
    ]);
      break;
    case "kent":
      areaSeries.setData([
    <?php echo $kent_graph_data; ?>
    ]);
      break;
    case "stark":
      areaSeries.setData([
    <?php echo $stark_graph_data; ?>
    ]);
      break;
    case "ashtabula":
      areaSeries.setData([
    <?php echo $ashtabula_graph_data; ?>
    ]);
      break;
    case "eastliverpool":
      areaSeries.setData([
    <?php echo $eastliverpool_graph_data; ?>
    ]);
      break;
    case "salem":
      areaSeries.setData([
    <?php echo $salem_graph_data; ?>
    ]);
      break;
    case "geauga":
      areaSeries.setData([
    <?php echo $geauga_graph_data; ?>
    ]);
      break;
    case "trumbull":
      areaSeries.setData([
    <?php echo $trumbull_graph_data; ?>
    ]);
      break;
    case "tuscarawas":
      areaSeries.setData([
    <?php echo $tuscarawas_graph_data; ?>
    ]);
      break;
    default:
    areaSeries.setData([]);
    break
  }
}
var i = 0;
function getGraph(){
  createCharts2();
}

  </script>
  

    <header id="header-main">
      <img id="kent-logo-nav" src="./images/kent-logo.png" alt=""> <!--From kent state's website, property of kent state. Using for educational purpose only-->
      <span id="ksu-hs-logo-nav-span"><img id="ksu-hs-logo-nav" src="./images/ksu-hs-logo.png" alt=""></span>
      <span id="fa-sign-out-alt-span"><a href="./login.php" ><i onclick="signOut()" id="sign-out-nav" class="fas fa-sign-out-alt"></i></a></span>
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
      <div id="row-1" class="row-1 row">
      <div class="col-md-6" id="mission-statement">
            <div id="mission-statement-inner">
            <h2 style="color: #053B74;">The mission of the KSU-HS is to provide quality healthcare, health counseling, and health education.</h2>
            <p style="font-size: 20px">Following the events of the Coronavirus, the office has expanded and has been tracking the Coronavirus cases on campus. With the arrival of the Coronavirus vaccine, the KSU-HS office has introduced an integrated automated system that helps monitor the Coronavirus vaccination of the KSU students and employees. For such a purpose the KSU-HS has set up one vaccination station at each of the 8 campuses across Ohio. </p>
            </div>
            
            <div id="vaccine-counts">
            <?php
            
              echo "<p>total vaccine count: <span style='color: #EDAA28;'>" . $graph->get_total_count() . "</span></p>";
              echo "<p>kent vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("kent") . "</span></p>";
              echo "<p>stark vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("stark") . "</span></p>";
              echo "<p>ashtabula vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("ashtabula") . "</span></p>";
              echo "<p>east liverpool vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("eastliverpool") . "</span></p>";
              echo "<p>salem vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("salem") . "</span></p>";
              echo "<p>geauga vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("geauga") . "</span></p>";
              echo "<p>trumbull vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("trumbull") . "</span></p>";
              echo "<p>tuscarawas vaccine count: <span style='color: #EDAA28;'>" . $graph->get_campus_count("tuscarawas") . "</span></p>";
            ?>
            </div>
      </div>
      <select  style="margin-left: 200px;" name="campus-graph-select" id="campus-graph-select">
            <option value="total">Total</option>
            <option value="kent">Kent Main Campus</option>
            <option value="stark">Stark Campus</option>
            <option value="ashtabula">Ashtabula Campus</option>
            <option value="eastliverpool">East Liverpool Campus</option>
            <option value="salem">Salem Campus</option>
            <option value="geauga">Geauga Campus</option>
            <option value="trumbull">Trumbull Campus</option>
            <option value="tuscarawas">Tuscarawas Campus</option>
          </select>
          <input type='submit' name='graph-submit' value='submit' onclick="getGraph()">
          <br>
          
      </div>
      <br>
      <div class="" id="payment-totals">
        
      </div>
    </main>
    <?php
    include_once('../backend/user.php');
  if(isset($_POST['signout'])){
    
    echo "<script>window.location.href='./index.php';</script>";
    logOut();
  }
  
  ?>
  </body>
 
</html>
