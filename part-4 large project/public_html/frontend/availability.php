<?php 
//Created by Jaden Kandel Spring Semester 2021
session_start();
    if(!$_SESSION['authenticated']){
        header("location: ./login.php");
}
//pain
error_reporting(0);

?>
<?php
include_once("../backend/appointment.php");
include_once("../backend/db.php");
include_once("../backend/avail.php");
include_once("../backend/user.php");

//add to every page at top, this is the name that you click for active user
$user = $_SESSION['user'];
    echo "<div class='above-nav'>";
    echo 'Signed in as <strong><a href="user_details.php">'.$user ."</a> </strong>";
    echo "</div>";
//end active user

?>
<html>

  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

    <meta charset="utf-8">
    <title><?php if($_SESSION['authenticated']){echo ucfirst($_SESSION['user']); echo "'s ";} ?>CVIS Dashboard</title>
        <link rel="shortcut icon" href="./images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <script src="./js/main.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet"> <!--load all styles -->
        <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" type="text/css" href="css/index.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" type="text/css" href="user_details.css?v=<?php echo time(); ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" ></script>
        <link rel="stylesheet" href="./dist/tavo-calendar.css" />
        <script src="./dist/tavo-calendar.js"></script>
    
  </head>
  <body>

    <header id="header-main">
      <img id="kent-logo-nav" src="./images/kent-logo.png" alt="">
      <span id="ksu-hs-logo-nav-span"><img id="ksu-hs-logo-nav" src="./images/ksu-hs-logo.png" alt=""></span>
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
    <!--- End of navbar --->

<?php
$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$days = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
?>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-1"></div>


        <div class="col-md-10">
        <form>
  <label for="cars">Select a month:</label>
  <select id="month" name="month">
    <?php 
    $val = 1;
    foreach($months as $m){
        
        echo '<option value="' . $val . '">'. $m . '</option>"'; 
        $val = $val +1;
    }
    ?>
  </select>
  <br>
  <label for="cars">Select a day:</label>
  <select id="day" name="day">
    <?php 
    $val2 = 1;
    foreach($days as $d){
        
        echo '<option value="' . $val2 . '">'. $d . '</option>"'; 
        $val2 = $val2 +1;
    }
    ?>
  </select>
  <br>
  <input type="submit">
  <br>

    <?php

      
    $times = [
    "8:10","8:20","8:30","8:40","8:50",
    "9:00","9:10","9:20","9:30","9:40","9:50",
    "10:00","10:10","10:20","10:30","10:40","10:50",
    "11:00","11:10","11:20","11:30","11:40","11:50",
    "12:00","12:10","12:20","12:30","12:40","12:50",
    "13:00","13:10","13:20","13:30","13:40","13:50",
    "14:00","14:10","14:20","14:30","14:40","14:50",
    "15:00","15:10","15:20","15:30","15:40","15:50",
    "16:00","16:10","16:20","16:30","16:40","16:50",
    "17:00","17:10","17:20","17:30","17:40","17:50",
    ];
    
    if($_GET['month'] != NULL && $_GET['day'] != NULL){
            echo'
    </form>
        
    <table>
      <tr>
        <th>Time Slots</th>
        <th>Kent</th>
        <th>Stark</th>
        <th>Ashtabula</th>
        <th>East Liverpool</th>
        <th>Salem</th>
        <th>Geauga</th>
        <th>Trumbull</th>
        <th>Tuscarawas</th>
      </tr>';
      
        $m = $_GET['month'];
        $d = $_GET['day'];
        //location, day, month
        $kent = get_appointments_by_campus($connection, "kent", $d, $m);
        $stark = get_appointments_by_campus($connection, "stark", $d, $m);
        $ash = get_appointments_by_campus($connection, "ashtabula", $d, $m);
        $east = get_appointments_by_campus($connection, "east liverpool", $d, $m);
        $salem = get_appointments_by_campus($connection, "salem", $d, $m);
        $gea = get_appointments_by_campus($connection, "geauga", $d, $m);
        $trum = get_appointments_by_campus($connection, "trumbull", $d, $m);
        $tusc = get_appointments_by_campus($connection, "tuscarawas", $d, $m);
        echo "<h1><center>Showing appointments for " . $m . "/" . $d . "</center></h1>";
        for ($x = 0; $x <= sizeof($times) - 1; $x++) {
        echo '    
          <tr>
            <td>'
            . $times[$x] .
            '</td>
            
            <td>'
            . $kent[$x] .
            '</td>
            
             <td>'
            . $stark[$x] .
            '</td>
            
             <td>'
            . $ash[$x] .
            '</td>
            
             <td>'
            . $east[$x] .
            '</td>
            
             <td>'
            . $salem[$x] .
            '</td>
            
             <td>'
            . $gea[$x] .
            '</td>
            
             <td>'
            . $trum[$x] .
            '</td>
            
             <td>'
            . $tusc[$x] .
            '</td>
            
          </tr>';
        }
        echo '</table>';
    }
        ?>

        </div>
        <div class="col-md-1"></div>
    </div>
</div>




  </body>
</html>