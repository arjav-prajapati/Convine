<?php 
session_start();
include "../dbh/dbh.php";

$username=$_SESSION['username'];


$community_name=$_POST['community_name'];
$title=mysqli_real_escape_string($conn,$_POST['title']);
$desc=mysqli_real_escape_string($conn,$_POST['desc']);

$post_img=$_FILES['img'];
$post_img_name=$_FILES['img']['name'];
$post_img_tmp_name=$_FILES['img']['tmp_name'];
$explode_ext = explode(".",$_FILES["img"]["name"]);
$extension = end($explode_ext);
$file_new_name= uniqid().".".$extension;
$file_destination="../C/$community_name/Posts/$file_new_name";

if($title==""){
    header("Location:../add_post.php?error=empty_title");
}

else if($community_name==""){
    $_SESSION['title']=$title;
    $_SESSION['desc']=$desc;
    header("Location:../add_post.php?error=no_community_selected");
}   

else{

if($post_img_name=="" OR $post_img="" OR $post_img_tmp_name=""){
 


        $sql= "INSERT INTO `convine_dbs`.`posts`(title,description,uploaded_by,community) VALUES ('$title','$desc','$username','$community_name')";
        if(mysqli_query($conn,$sql)){

            header("Location:../community_page.php?C=$community_name");
        }
        else{
            echo mysqli_error($conn);
        }
        
        
    }
    
    else{
        
        if(file_exists("../C/$community_name/posts")){
            echo "yes";
        }
    else {
        mkdir("../C/$community_name/posts");
        echo "made";
    }
    $post_img=$_FILES['img'];
    $post_img_name=$_FILES['img']['name'];
    $post_img_tmp_name=$_FILES['img']['tmp_name'];
    $post_img_size=$_FILES['img']['size'];
    $explode_ext = explode(".",$_FILES["img"]["name"]);
    $extension = end($explode_ext);
    $file_new_name= uniqid().".".$extension;
    $file_destination="../C/$community_name/Posts/$file_new_name";
    $file_destination_in_db="./C/$community_name/Posts/$file_new_name";
    echo $file_new_name;
    
    move_uploaded_file($post_img_tmp_name,$file_destination);
    $allowed=array('jpg','jpeg','png');
    if(in_array($extension,$allowed)){ 
        if($post_img_size < 1000000){
            
            $sql3="INSERT INTO `convine_dbs`.`posts`(title,description,img,uploaded_by,community) VALUES ('$title','$desc','$file_destination_in_db','$username','$community_name')";
            mysqli_query($conn,$sql3);  
            header("Location:../community_page.php?C=$community_name");
            
        }
        else{ 
            header("Location:../add_post.php?error=big_file_size");
        }
        
    }
    else{
        header("Location:../add_post.php?error=invalid_file_type");
    }
    
}

}

