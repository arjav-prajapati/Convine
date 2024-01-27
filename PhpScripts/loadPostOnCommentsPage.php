<?php 
include "../dbh/dbh.php";


$id=$_POST['id'];
if(isset($_GET['c_id'])){

    $c_id=$_GET['c_id'];
}
session_start();
$username=$_SESSION['username'];
$sql="SELECT * from `convine_dbs`.`posts` WHERE sno='$id'";
$result=mysqli_query($conn,$sql);
$datas=array();

    $datas=array();
    $row = mysqli_fetch_assoc($result);
        $datas[]=$row;
    
    echo json_encode($datas);
    // echo $id;
    // $imgsrc=$datas[0]['img'];


 
