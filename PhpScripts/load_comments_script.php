<?php
include "../dbh/dbh.php";

$id= mysqli_real_escape_string($conn,$_POST['id']);
$c_id= mysqli_real_escape_string($conn,$_POST['c_id']);

if($c_id!=0){
    
    $sql2="SELECT * FROM `convine_dbs`.`post_comments` WHERE  comment_id='$c_id'";
    $result2=mysqli_query($conn,$sql2);
    $datas2=array();
    if(mysqli_num_rows($result2)>0){
        while($row2= mysqli_fetch_assoc($result2)){
            $datas2[]=$row2;
        }
        echo json_encode($datas2);
    }
    
}
else{

    $sql="SELECT * FROM `convine_dbs`.`post_comments` WHERE post_id='$id'";
    $result=mysqli_query($conn,$sql);

    $datas=array();
    if(mysqli_num_rows($result)>0){
        while($row= mysqli_fetch_assoc($result)){
            $datas[]=$row;
        }
        echo json_encode($datas);
    }
}

