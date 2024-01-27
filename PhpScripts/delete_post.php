<?php
include "../dbh/dbh.php"; 

$post_sno =  $_POST['post_sno'];

$sql = "DELETE FROM `convine_dbs`.`posts` WHERE sno = {$post_sno};";

if(mysqli_query($conn,$sql)){
    echo 'successfull';
}else{
    echo 'Can\'t delete!';
}
?>