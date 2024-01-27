<?php
session_start();
include '../dbh/dbh.php';
$community_name=$_POST['community_name'];
$sql="SELECT * FROM `convine_dbs`.`admins` WHERE communities='$community_name';";
$result2=mysqli_query($conn,$sql);
$datas=array();

if(mysqli_num_rows($result2)>0){
    $datas2=array();
    while($row2 = mysqli_fetch_assoc($result2)){
        $datas2[]=$row2['admin_name']; 
    }
     
    $i=0;
    $datas=array();
    $joined_communities2="";
    while($i<sizeof($datas2)){
        $joined_communities2 .= " username='$datas2[$i]' OR ";
        $i++;
    }
    $new=substr($joined_communities2, 0,strrpos($joined_communities2,"OR"));
}

$sql2="SELECT username, profile_img, about  FROM `convine_dbs`.`users` WHERE $new;";
// echo $sql2;
$result2=mysqli_query($conn,$sql2); 
$datas=array();

if(mysqli_num_rows($result2)>0){
    $datas2=array();
    while($row2 = mysqli_fetch_assoc($result2)){
        $datas2[]=$row2; 
    }
    echo json_encode($datas2);
}