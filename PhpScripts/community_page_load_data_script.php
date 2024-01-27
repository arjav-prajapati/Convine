<?php
include "../dbh/dbh.php";
$community_name=$_POST['community_name'];
$sql="SELECT * from `convine_dbs`.`posts` WHERE community='$community_name'";
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