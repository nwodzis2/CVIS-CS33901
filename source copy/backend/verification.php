<?php
    include_once("../backend/db.php");

    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");

    function check_if_user_verified($connection, $user_email){
        $sql = "SELECT * FROM verifiedemails WHERE email ='$user_email'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            $user = $row['email'];
            if($user === $user_email){
                echo $user . " is a verified email in our system";
            }
            else{
                echo $user_email . " is not a verified email in our system, please contact support @330-763-1234"; 
            } 
        }
    }

?>
    