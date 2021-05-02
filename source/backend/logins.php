<?php

include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");


//doesn't really return anything right now,,, not sure how you want to do this with sessions but ya it currently just echos what is going down
function check_if_correct_credentials($connection, $email, $password){
        $sql = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(empty($row)){
                $_SESSION['authenticated'] = false;
                echo '<script>alert("Please enter valid credentials")</script>';
            }
            else{
                $_SESSION['authenticated'] = true;
                $_SESSION['user'] = explode('@', $email)[0];
                echo "success";
                header("location: ../frontend/index.php");
                echo '<script>
                alert("Your have successfully signed in!");
                window.location.href="../frontend/index.php";
                </script>';
            }
        }
}

    
?>