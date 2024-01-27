<?php
include "../dbh/dbh.php";
session_start();
$username=$_SESSION['username'];
$sql2="SELECT * from `convine_dbs`.`joined_users` WHERE  joined_users='$username'";

$result2=mysqli_query($conn,$sql2);
$datas2=array();

if(mysqli_num_rows($result2)>0){
    $datas2=array();
    while($row2 = mysqli_fetch_assoc($result2)){
              $datas2[]=$row2['communities']; 
            }
           
 

$i=0;
$datas=array();
$joined_communities2="";
while($i<sizeof($datas2)){
  $joined_communities2 .= "community ='$datas2[$i]' OR ";
  $i++;
}
$new=substr($joined_communities2, 0,strrpos($joined_communities2,"OR"));

}

$sql="SELECT * from `convine_dbs`.`posts` WHERE $new";

$result=mysqli_query($conn,$sql);
$datas=array();
if(mysqli_num_rows($result)>0){
    $datas=array();
    while ($row = mysqli_fetch_assoc($result)){
        $datas[]=$row;
    }
    echo json_encode($datas);
}


// <?php
// include "../dbh/dbh.php";
// $sql="SELECT * from `convine_dbs`.`posts` WHERE community='$community_name'";
// $result=mysqli_query($conn,$sql);
// $datas=array();
// if(mysqli_num_rows($result)>0){
//     $datas=array();
//     while ($row = mysqli_fetch_assoc($result)){
//         $datas[]=$row;
//     } 
// } 



//     echo json_encode($datas);

