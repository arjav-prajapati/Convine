<?php
include "../dbh/dbh.php";

$comment=mysqli_real_escape_string($conn,$_POST['commentData']);
$id= mysqli_real_escape_string($conn,$_POST['id']);
$commented_by= mysqli_real_escape_string($conn,$_POST['commented_by']);
if($comment==""){
    echo "Please Enter a valid Comment";
}
else{

    $sql="INSERT INTO `convine_dbs`.`post_comments`(post_id,comment,commented_by) VALUES ('$id','$comment','$commented_by')";
    mysqli_query($conn, $sql);
}
