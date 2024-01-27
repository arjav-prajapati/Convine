<?php

if (isset($_POST['login_button'])){
    
    include '../dbh/dbh.php';
 
    $username=$_POST['username'];
    $password=$_POST['password'];
    if(empty($username) || empty($password)){
        header("Location:../login_page.php?error=emptyfields");
            exit();
    }   

    else {
        $sql= "SELECT * FROM `convine_dbs`.`users` WHERE username=?;";
        $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location:../login_page.php?error=sqlerror");

                exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt,"s",$username);
                    mysqli_stmt_execute($stmt);
                    $result=mysqli_stmt_get_result($stmt);
                    if($row=mysqli_fetch_assoc($result)){
                        $pwdCheck=password_verify($password,$row['password']);
                            if ($pwdCheck==false){
                                echo $row['password'];
                                header("Location:../login_page.php?error=wrongpwd");
                            exit();
                            }
                            else if($pwdCheck==true){
                                session_start();
                                $_SESSION['username']=$row['username'];
                                header("Location:../front_page.php?login=success");
                            }
                            else {
                                header("Location:../indexx.php?error=wrongpwd");
                                exit();
                            }
                        }
                        else {
                            header("Location:../login_page.php?error=no_user");
                            exit();
                        }
                    }
         }
    }

