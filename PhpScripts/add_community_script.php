<?php
session_start();
include '../dbh/dbh.php';

 
$Sr_no=$_POST['Sr_no'];
$username=$_SESSION['username'];
$sql="SELECT communities from `convine_dbs`.`communities_table` WHERE Sr_no=$Sr_no";

$result=mysqli_query($conn,$sql);
    if($row=mysqli_fetch_row($result)){
        $communityselcted=implode($row);

        $sql2="SELECT communities from `convine_dbs`.`joined_users` WHERE communities= '$communityselcted' AND joined_users='$username';";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_row($result2);
         
        if($row2==0){
            $sql3="INSERT INTO `convine_dbs`.`joined_users` (communities,joined_users) VALUES ('$communityselcted','$username')";
            mysqli_query($conn,$sql3);
            $color=["bgcolor"=>"blue",
            "color"=>"white"];
            echo json_encode($color);
        }
        else{
            $sql4="DELETE FROM `convine_dbs`.`joined_users`  WHERE communities= '$communityselcted' AND joined_users='$username';";
            mysqli_query($conn,$sql4);
            $color=["bgcolor"=>"white",
            "color"=>"black"];
            echo json_encode($color); 
        }
        
    }
    else {
        echo "nope";
    }