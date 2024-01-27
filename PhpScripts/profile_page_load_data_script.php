<?php
include "../dbh/dbh.php";
$get_username=$_POST['u'];
// $get_username='example';

$sql="SELECT * from `convine_dbs`.`posts` WHERE uploaded_by='$get_username'";
$result=mysqli_query($conn,$sql);
$datas=array();
if(mysqli_num_rows($result)>0){
    $datas=array();
    while ($row = mysqli_fetch_assoc($result)){
        $datas[]=$row;
    } 
} 

    echo json_encode($datas);

?>