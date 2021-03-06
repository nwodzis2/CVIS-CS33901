<?php 


//Created by Jaden Kandel Spring Semester 2021
session_start();
    if(!$_SESSION['authenticated']){
        header("location: ./login.php");
}

include_once("../backend/campus.php");
$starkCampus = Campus::with_name('stark');
$s_revenue = $starkCampus->get_c_revenue(5,6);
$s_doses = $starkCampus->get_c_doses_on_hand(5,6);
//kent main
$k = Campus::with_name('kent');
$k_revenue = $k->get_c_revenue();
$k_doses = $k->get_c_doses_on_hand();

//ashtabula
$a = Campus::with_name('ashtabula');
$a_revenue = $a->get_c_revenue();
$a_doses = $a->get_c_doses_on_hand();

$el = Campus::with_name('east liverpool');
$el_revenue = $el->get_c_revenue();
$el_doses = $el->get_c_doses_on_hand();

$sa = Campus::with_name('salem');
$sa_revenue = $sa->get_c_revenue();
$sa_doses = $sa->get_c_doses_on_hand();

$g = Campus::with_name('geauga');
$g_revenue = $g->get_c_revenue();
$g_doses = $g->get_c_doses_on_hand();

$tr = Campus::with_name('trumbull');
$tr_revenue = $tr->get_c_revenue();
$tr_doses = $tr->get_c_doses_on_hand();

$t = Campus::with_name('tuscarawas');
$t_revenue = $t->get_c_revenue();
$t_doses = $t->get_c_doses_on_hand();
  

?>
<?php
include_once("../backend/appointment.php");
include_once("../backend/db.php");
include_once("../backend/avail.php");
include_once("../backend/user.php");
include_once("../backend/administration.php");

//add to every page at top, this is the name that you click for active user
$user = $_SESSION['user'];
    echo "<div class='above-nav'>";
    echo 'Signed in as <strong><a href="user_details.php">'.$user ."</a> </strong>";
    echo "</div>";
//end active user

include_once("../backend/email.php");

function campuses_that_need_appointments($connection, $day, $month, $campus){
    $sql = "SELECT * FROM appointments WHERE campus = '$campus' AND day = '$day' AND month = '$month'";

    $stmt = $connection->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();
    
    if(!$result){
        echo "query failed";
    }
    else{
        $count = 0;
        
        while($row = mysqli_fetch_assoc($result)){
             $count = $count + 1; 
        }
        if($count < 31){
            $address = "nwodzis2@kent.edu";

            $subject = "Appointments Needed! " . $month . "/" . $day . " at " . $campus;
            //Text in body
            $body = "Hello, this is a KSU-HS CVIS automated message. We are reaching out to all un-vaccinated users in our system to let you know we have appointments availabe today!";

            send_email($address,$subject, $body);
        }     
    }  
}


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
    
<center>
    <p>Enter a day and month to complete all appointments for</p>
    <form method="post">
      <label for="day">Day</label>
      <input type="text" id="day" name="day">
      <label for="month">Month</label>
      <input type="text" id="month" name="month">
      <input type="submit" value="Complete" name="com">
    </form>
</center>
    <?php 
    if(isset($_POST['com'], $_POST['day'], $_POST['month'] )){
    $d = $_POST['day'];
    $m = $_POST['month'];
    complete_appointments_on_day($connection, $m, $d);
    }
    ?>
<center>
    <p>Send emails to user-list</p>
    <form method="post">
      <label for="day">Day</label>
      <input type="text" id="day" name="day2">
      <label for="month">Month</label>
      <input type="text" id="month" name="month2">
      <label for="month">campus</label>
      <input type="text" id="campus" name="campus">
      <input type="submit" value="send" name="email">
    </form>
</center>
    <?php 
    if(isset($_POST['email'], $_POST['day2'], $_POST['month2'], $_POST['campus'] )){
    $da = $_POST['day2'];
    $mo = $_POST['month2'];
    $ca = $_POST['campus'];
    campuses_that_need_appointments($connection, $da, $mo, $ca);
    }
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
<center>
<table>
      <tr>
        <th>Kent</th>
        <th><?php echo $k_revenue; ?></th>
        <th><?php echo $k_doses; ?></th>
      </tr>
      <tr>
        <th>Stark</th>
        <th><?php echo $s_revenue; ?></th>
        <th><?php echo $s_doses; ?></th>
      </tr>
      <tr>
        <th>Ashtabula</th>
        <th><?php echo $a_revenue; ?></th>
        <th><?php echo $a_doses; ?></th>
      </tr>
      <tr>
        <th>East Liverpool</th>
        <th><?php echo $el_revenue; ?></th>
        <th><?php echo $el_doses; ?></th>
      </tr>
      <tr>
        <th>Salem</th>
        <th><?php echo $sa_revenue; ?></th>
        <th><?php echo $sa_doses; ?></th>
      </tr>
      <tr>
        <th>Geauga</th>
        <th><?php echo $g_revenue; ?></th>
        <th><?php echo $g_doses; ?></th>
      </tr>
      <tr>
        <th>Trumbull</th>
        <th><?php echo $tr_revenue; ?></th>
        <th><?php echo $tr_doses; ?></th>
      </tr>
      <tr>
        <th>Tuscarawas</th>
        <th><?php echo $t_revenue; ?></th>
        <th><?php echo $t_doses; ?></th>
      </tr>
</table>
</center>


      
  </body>
</html>