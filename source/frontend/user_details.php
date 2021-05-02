<?php 
//Created by Jaden Kandel Spring Semester 2021
session_start();
?>
<?php
include_once("../backend/db.php");
include_once("../backend/user.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "CVIS");

//email should come from the session
$user_stuff = get_user_details_by_email($connection, 'jkandel4@kent.edu');



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
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet"> <!--load all styles -->
        <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" type="text/css" href="user_details.css">
    
  </head>
  <body>

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
    <!--- End of navbar --->
<div class="container">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
        <h1><center>User Details<center></h1>
        
        <?php    
        $user_stuff = get_user_details_by_email($connection, 'tester@kent.edu');
        ?>
        <div class="panel panel-info ">
            <div class="panel-heading"><center><strong>User information</strong></center></div>
            <div class="panel-body"><strong>ID: </strong><?php echo $user_stuff->get_u_id(); ?></div>
            <div class="panel-body"><strong>Email: </strong><?php echo $user_stuff->get_u_email(); ?></div>
            <div class="panel-body"><strong>Appointment One: </strong><?php echo $user_stuff->get_u_ap1(); ?></div>
            <div class="panel-body"><strong>Appointment Two: </strong><?php echo $user_stuff->get_u_ap2(); ?></div>
            <div class="panel-body"><strong>Vaccine Type: </strong><?php $vac = $user_stuff->get_u_vaccine_type(); 
            if($vac === 1){
                echo "Pfizer";
            }elseif($vac === 2){
                echo "Moderna";
            }else{
                echo "Johnson&Johnson";
            }
            ?></div>
            <div class="panel-body"><strong>Fully Vaccinated: </strong><?php $vaccinated = $user_stuff->get_u_vaccinated(); 
            if($vaccinated === 1){
                echo "Yes";
            }else{
                echo "No";
            }      
            ?></div>
            <div class="panel-body"><strong>Has Insurance </strong><?php $insurance = $user_stuff->get_u_has_insurance();
            if($insurance === 1){
                echo "Yes";
            }else{
                echo "No";
            }
            ?></div>
        </div>
        
        
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>
    
    
  </body>
</html>