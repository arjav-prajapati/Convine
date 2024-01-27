<?php
include "../dbh/dbh.php";


$toUser= $_POST['toUser'];
$fromUser= $_POST['fromUser'];
$message= $_POST['message'];

$output="";

$sql= "INSERT INTO `convine_dbs`.`messages` (FromUser, ToUser , Message) VALUES (?,?,?)";
    $stmt=mysqli_stmt_init($conn);
        
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "failed to prepare stmt statement";
    }
    else{
        mysqli_stmt_bind_param($stmt,"sss",$fromUser,$toUser,$message);

     mysqli_stmt_execute($stmt);
            $output="";
     
    }
    echo $output;