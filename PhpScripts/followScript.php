<?php
include "../dbh/dbh.php";

$username =$_POST['username'];
$followed_by = $_POST['followedBy'];
$action = $_POST['action'];

        if($action=="follow"){
            $sql="INSERT INTO `convine_dbs`.`follow_users` (username,followed_by) VALUES ('$username','$followed_by');";
            mysqli_query($conn,$sql);
            echo "Following";
        }
        else{
            $sql="DELETE FROM `convine_dbs`.`follow_users` WHERE (username = '$username' AND followed_by = '$followed_by')";
            mysqli_query($conn,$sql);
            echo "Follow";
        }

     