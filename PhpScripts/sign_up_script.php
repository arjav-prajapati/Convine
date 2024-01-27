<?php
include '../dbh/dbh.php';

$username=$_POST['username'];
$Name=$_POST['Name'];
$email=$_POST['email'];
$password=$_POST['password'];
$rpt_password=$_POST['rpt_password'];

if(empty($username) || empty($Name) || empty($email) || empty($password) || empty($rpt_password)  ){
    header("Location:../sign_up_page.html?error=emptyfields");
    echo "somethibng wrong";
    exit();        
}
else{
    
    $sql_username="SELECT * FROM `convine_dbs`.`users` WHERE username='$username'";
    $result_username=mysqli_query($conn,$sql_username);
    if (mysqli_num_rows($result_username)>=1){
        // echo mysqli_num_rows($result_username);
        echo "username already exist";
        exit();
    }
    else {
        
        // $sql2="CREATE TABLE `convine_users_dbs`.`$username`(
        //         Sr_no INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        //         communities varchar(255),
        //         follow varchar(30),
        //         followings varchar(30),
        //         blocked_users varchar(30)
        //         )";
        // mysqli_query($conn,$sql2);
        
        $sql="INSERT INTO `convine_dbs`.`users` (username,Name,email,password) VALUES (?,?,?,?)";
                    $stmt=mysqli_stmt_init($conn); 
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        echo "failed";
                    }
                    else{
                        $hashedpwd=password_hash($password,PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt,"ssss",$username,$Name,$email,$hashedpwd);
                        
                        mysqli_stmt_execute($stmt);
                        
                        session_start();
                        $_SESSION['username']="$username";
                        $_SESSION['password']="$password";  
                         
                        if(!file_exists("../U/$username")){
                            mkdir("../U/$username");
                        }

                       
                    }
                    
                } 
            }

            
            
            $sql3="SELECT * FROM `convine_dbs`.`communities_table` ORDER BY `Sr_no` ASC";
            $result=mysqli_query($conn,$sql3);
            $datas = array();
            if(mysqli_num_rows($result)>0){
                $datas=array();
                while($row = mysqli_fetch_assoc($result)){
                    $datas[]=$row; 
                }
                
                echo json_encode($datas);
}


?>

