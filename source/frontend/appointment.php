<?php 
      session_start();
      if(!$_SESSION['authenticated']){
        header("location: ./login.php");
      }
      
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
    <link rel="stylesheet" type="text/css" href="css/index.css?v=<?php echo time(); ?>">
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
    
    <main>
    <nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Schedule Appointment <span class="sr-only">(current)</span></a></li>
      <li><a href="reschedule.php">Reschedule Appointment</a></li>
      <li><a href="cancel.php">Cancel Appointment</a></li>
    </ul>
  </div>
</nav>
      <h1>Schedule Appointment</h1>
      <div class="row">
        <div class="col-md-6">
          <div id='campus-select-cont'>
            <br>
        <input type="checkbox" id="insurance" name="insurance" value="true">
        <label for="insurance"> I have insurance</label><br>
          <label for="campus-select">Choose a campus:</label>
          <select name="campus-select" id="campus-select">
            <option value="kent">Kent Main Campus</option>
            <option value="stark">Stark Campus</option>
            <option value="ashtabula">Ashtabula Campus</option>
            <option value="eastliverpool">East Liverpool Campus</option>
            <option value="salem">Salem Campus</option>
            <option value="geauga">Geauga Campus</option>
            <option value="trumbull">Trumbull Campus</option>
            <option value="tuscarawas">Tuscarawas Campus</option>
          </select>
          <input type='submit' name='apt-submit' value='submit'>
          </div>
          <br>
          <div id="my-calendar"></div>
        </div>
        
        <div id="time-select" class="col-md-6 apt-centered"></div>
      </div>
    </main>
    <?php
include_once("../backend/appointment.php");
include_once("../backend/user.php");
include_once("../backend/campus.php");
if(isset($_POST['apt-submit'])){
  $DB_link = new DB_Link();
  $connection = $DB_link->connect("localhost", "cvis");
  $apt_time = $_POST['timeSelect'];
  make_appointment($connection, $_SESSION['first'], $_SESSION['last'], $_SESSION['email'], $_SESSION['campus'], $_SESSION['day'], $_SESSION['month'], $apt_time, 0, NULL);
  $myCampus = new Campus();
  $myCampus->load_by_name($_SESSION['campus']);
  if($_POST['insurance'] == "true"){
    $myCampus->increase_revenue();
  }
  else{
    $myCampus->decrease_revenue();
  }
  
}
if(isset($_POST['day'])){
  update_insurance($connection, $_SESSION['email'], $_SESSION['insurance']);
  $_SESSION['campus'] = $_POST['campus'];
  $_SESSION['day'] = $_POST['day'];
  $_SESSION['month'] = $_POST['month'];include_once("../backend/db.php");
  //include_once("./appointment.php");
  $DB_link = new DB_Link();
  $connection = $DB_link->connect("localhost", "cvis");
  
}
$appointmentArray = [];
  
  $datetime = DateTime::createFromFormat('g:i', "8:00");
  for($i = 0; $i < 60; $i++){
          array_push($appointmentArray, $datetime->format('G:i'));
      $datetime->modify('+10 minutes');
  }
  $_SESSION['apt-array'] = $appointmentArray;
?>
  </body>
  <script>
    var campus_ = 'kent';
    var insurance_ = false;
    //not my (Nathan Wodzisz) calendar, using personally modified Tavo Calendar
const myCalendar = new TavoCalendar('#my-calendar', {
      date: "<?php echo date("Y-m-d");?>",
      range_select: false,
      past_select: false,
      highlight_sunday: true,
      highlight_saturday: true,
})
function useCampus(){
      campus_ = document.getElementById('campus-select').value;
      insurance_ = document.getElementById('insurance').value;
  }
document.getElementById('my-calendar').addEventListener('calendar-select', (ev) => {
  var formString = myCalendar.getSelected().toString();
  /*var form1 = new FormData();
  let myDate = myCalendar;
  2021-03-23
  form1.append("day", myDate.substring(8,9));
  form1.append("month", myDate.substring(5,6));
  form1.append("campus", campus);*/
  var somedata;
  var somedataday;
  if(formString.substring(5,7).charAt(0) == "0"){
    somedata = formString.substring(6,7);
  }
  else{
    somedata = formString.substring(5,7);
  }
  if(formString.substring(8,10).charAt(0) == "0"){
    somedataday = formString.substring(9,10);
  }
  else{
    somedataday = formString.substring(8,10);
  }
  var data_ = { "day": somedataday, "month": somedata, "campus": campus_ , "insurance": insurance_};

  var data_2 = "day=" + formString.substring(8,10) + "&month=" + formString.substring(5,7) + "&campus=" + campus_ + "&insurance=" + insurance_;
  $.ajax({
        method: "POST",
        data: data_,
        success: fillDates(),
        error: function(){
                console.log("error: post unsucessful")
            }
    });
    
    //var posting = $.post( "../backend/appointmentArray.php", data )
    //posting.done(fillDates());
  })
  document.getElementById('campus-select').addEventListener("change", useCampus, false); 
  document.getElementById('insurance').addEventListener("change", useCampus, false);
  function fillDates(){
    let dates =
      <?php
        echo json_encode($_SESSION['apt-array']);
      ?>;
    var form = document.createElement("Form");
    form.id = "time-select-form";
    form.method = "post";
    let timeSelect = document.getElementById('time-select').appendChild(form);
    var myInnerHtml = "";
    var i = 1;
    for(const element of dates){
      myInnerHtml = myInnerHtml + "<input type='radio' id='" + element + "' name='timeSelect' value='" + element + "'><label for='" + element + "'>" + element + "</label>";
      if(i % 8 === 0){
        myInnerHtml = myInnerHtml + "<br>";
      }
      i++;
    }
    myInnerHtml = myInnerHtml + "<br><input type='submit' name='apt-submit' value='create appointment'>";
    if(i < 10){
      myInnerHtml = "";
      alert("no available appointments for this day");
    }
    document.getElementById('time-select-form').innerHTML = myInnerHtml;
      }
    
</script>

</html>