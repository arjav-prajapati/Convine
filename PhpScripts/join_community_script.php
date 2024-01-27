<?php
include "../dbh/dbh.php";

$user_joined =$_POST['username'];
$community = $_POST['community'];
$action = $_POST['action'];

        if($action=="join"){
            $sql="INSERT INTO `convine_dbs`.`joined_users` (communities,joined_users) VALUES ('$community','$user_joined');";
            mysqli_query($conn,$sql);
            echo "Joined";
        }
        else{
            $sql="DELETE FROM `convine_dbs`.`joined_users` WHERE (communities = '$community' AND joined_users = '$user_joined')";
            mysqli_query($conn,$sql);
            echo "Join";
        }
?>