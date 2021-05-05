<?php 

//page created by Nathan Wodzisz Spring 2021 for software engineering
//used to cancel an appointment
      session_start();
      if(!$_SESSION['authenticated']){
        header("location: ./login.php");
      }
      include_once("../backend/db.php");
      include_once("../backend/appointment.php");
      $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "id16720870_cvismain");
?>
<html>
    <script>
        function cancelAppointment(){
            document.getElementById("col2").innerHTML = "<h2>Are you sure you want to <span style='color: #053B74;'>cancel</span> your appointment?</h2><br><br><form method='POST' ><input type='submit' name='cancel-submit' value='confirm'> </form> <a href='javascript:void(0)' onclick='closeModal();'><i class='far fa-window-close'></i></a>";
            document.getElementById("col2").className = "col2";
            document.getElementById('shadow').className = "shadow";
        }
        function closeModal(){
            document.getElementById("col2").innerHTML = "";
            document.getElementById("col2").className = "";
            document.getElementById('shadow').className = "";
        }
    </script>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="./js/main.js"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <meta charset="utf-8">
    <title><?php if($_SESSION['authenticated']){echo ucfirst($_SESSION['user']); echo "'s ";} ?>Appointment</title>
    <link rel="shortcut icon" href="./images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    <script   src="https://code.jquery.com/jquery-3.6.0.js"   integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" ></script>

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
    <div class='' id="shadow"></div>
    <main>
    <nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <ul class="nav navbar-nav">
    <li ><a href="appointment.php">Schedule Appointment </a></li>
      <li ><a href="reschedule.php">Reschedule Appointment<span class="sr-only">(current)</span></a></li>
      
      <li class="active"><a href="#">Cancel Appointment<span class="sr-only">(current)</span></a> </li>
    </ul>
  </div>
</nav>
      <h1>Cancel Appointment</h1>
      <div class="row">
        <div class="col-md-6" id="col1">
            
            <?php
            if(has_appointment($connection, $_SESSION["email"])){
                echo "<h3>Your appointment</h3>";
                get_appointments_by_email($connection, $_SESSION['email']);
                echo "<input type='submit' value='cancel appointment' onclick='cancelAppointment()'>";
                
            }
            else{
                echo "<p style='font-size: 20px; color: #EDAA28; padding-left: 20px;'>You do not have an apppointment!</p>";
            }
            echo "<br>";
            if(isset($_POST['cancel-submit'])){
                cancel_appointment($connection, $_SESSION["email"]);
                echo "<script>window.location.href='../frontend/cancel.php';</script>";
            }
            ?>
        </div>
        <div class="" id="col2">

        </div>
      </div>
    </main>
  </body>
<?php


if(isset($_POST['day'])){
  
  $_SESSION['campus'] = $_POST['campus'];
  $_SESSION['day'] = $_POST['day'];
  $_SESSION['month'] = $_POST['month'];include_once("../backend/db.php");
  include_once("./appointment.php");
  $DB_link = new DB_Link();
  $connection = $DB_link->connect("localhost", "id16720870_cvismain");
  $appointmentArray = [];
  
  $datetime = DateTime::createFromFormat('G:i', "8:00");
  for($i = 0; $i < 60; $i++){
      if(!check_for_appointment_at_time_and_location($connection, $_Session['campus'], $_SESSION['day'], $_SESSION['month'], $datetime->format('G:i'))){
          array_push($appointmentArray, $datetime->format('G:i'));
      }
      $datetime->modify('+10 minutes');
  }
  $_SESSION['apt-array'] = $appointmentArray;
}
?>
</html>