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
    

    <p>Enter a day and month to complete all appointments for</p>
    <form method="post">
      <label for="day">Day</label>
      <input type="text" id="day" name="day">
      <label for="month">Month</label>
      <input type="text" id="month" name="month">
      <input type="submit" value="Complete" name="com">
    </form>
    <br>
    <p>Enter a day and month to un-complete all appointments for</p>
    <form method="post">
      <label for="day">Day</label>
      <input type="text" id="day" name="day">
      <label for="month">Month</label>
      <input type="text" id="month" name="month">
      <input type="submit" value="Un-complete" name="uncom">
    </form>
  </body>
</html>