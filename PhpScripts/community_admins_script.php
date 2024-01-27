<?php
include "./dbh/dbh.php";

$username = $_SESSION['username'];

$sql = "SELECT communities FROM `convine_dbs`.`admins` WHERE admin_name='{$_SESSION['username']}'";

$result = mysqli_query($conn,$sql);

if($result){
    $user_admin = array();
    if(mysqli_num_rows($result)>0){
        $user_admin=array();
        while($row = mysqli_fetch_assoc($result)){
            $user_admin[]=$row; 
        }
    }
}
?>