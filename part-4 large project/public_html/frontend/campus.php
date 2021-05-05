<?php
//unused I believe?
    //error_reporting(0);
    //include the files from the backend that we are using 
    include_once("../backend/db.php");
    include_once("../backend/campus.php");
    /*$campus_test = new Campus();
    $campus_test->set_c_all("stark", 0, 0, 1, 100, 2);
    
    $campus_test->create_campus();
    echo "hello1";
    $sql = "SELECT * FROM campus WHERE campus_name = 'stark'";

    $stmt = $campus_test->get_connection()->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();
    
    if(!$result){
        echo "query failed";
    }
    else{
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
            $campusAdded = $row['campus_name'];
            echo $campusAdded;
        }
    }
    $stmt->close();*/
    /*$campus_test2 = Campus::with_name('stark');
    echo $campus_test2->get_c_name();
    echo $campus_test2->get_c_vaccinated();*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Campus create Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    </head>
    <body>
    <form action="campus.php">
      <label for="campus">Campus:</label><br>
      <input type="text" id="campus" name="campus"><br>
      <input type="submit" value="create campus">
    </form>
    
<?php 
//checks to see if the value from our get form (above) is set.
if(isset($_GET['campus'])){
    //if its set, we set a new variable equal to the value that is set.
  $user_campus = $_GET['campus'];
    //we call our function in verification.php (backend) with the value we just got from the form
    $campus_test = new Campus();
    $campus_test->set_c_all($user_campus, 0, 0, 1, 100, 2);

    if($campus_test->create_campus()){
        echo "<p>values: <br></p>";
        echo "<p>vacinated:"; echo $campus_test->get_c_vaccinated(); echo "</p>";
        echo "<p>name:"; echo $campus_test->get_c_name(); echo"</p>";
    }
    else{
        echo "<p>campus with that name already exists</p>";
    }
}
?>

    </body>
</html>