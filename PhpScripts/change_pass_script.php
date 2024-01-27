<?php
session_start();
include "../dbh/dbh.php";



if(!$conn){
    echo 'unsucessfull connection';
}
// else{
//     echo $username;
// }

if(isset($_POST['new-pass'])){
    $username = $_SESSION['username'];
    $newpassword = $_POST['new-pass'];
    $password = $_POST['old-pass'];
    $sql = "SELECT * FROM `convine_dbs`.`users` WHERE username = '{$username}';";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $datas = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
        }
    }

    $pwdCheck = password_verify($password,$datas[0]['password']);
    if ($pwdCheck==false){
        echo 'Wrong Pass!';
    }
    else if($pwdCheck==true){
        $_SESSION['username']=$datas[0]['username'];

        $hashedpwd=password_hash($newpassword,PASSWORD_DEFAULT);
        $sql2 =   "UPDATE `convine_dbs`.`users` SET password ='{$hashedpwd}' WHERE username='{$username}';";
        
        if(mysqli_query($conn,$sql2)){
            echo 'Password Change Successfully!';
        }else{
            mysqli_error($conn);
        }
    }
    else {
        echo 'Something went wrong';
    }


    // $stmt= mysqli_stmt_init($con);
    // if(!mysqli_stmt_prepare($stmt,$sql)){
    //     header("Location:../settings.php?error=sqlerror");

    //     exit();
    // }
    //     else{
    //         mysqli_stmt_bind_param($stmt,'s',$username);
    //         mysqli_stmt_execute($stmt);
    //         $result=mysqli_stmt_get_result($stmt);
    //         while($row=mysqli_fetch_array($result)){
    //             $pwdCheck=password_verify($password,$row[0]['password']);
    //                 if ($pwdCheck==false){
    //                     echo 'Wrong Pass!';
    //                 }
    //                 else if($pwdCheck==true){
    //                     session_start();
    //                     $_SESSION['username']=$row[0]['username'];
    //                     echo 'Password Change Successfully!';

    //                     $sql2 =   "UPDATE users SET password ='{$newpassword}' WHERE username='{$username}';";
    //                 }
    //                 else {
    //                     echo 'Something went wrong';
    //                 }
    //             }
    //         }
    }
?>