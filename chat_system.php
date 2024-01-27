<?php 
include "./PhpScripts/NavBar.php";
$username=$_SESSION['username'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <link rel="stylesheet" href="CSS/chatsystem.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Document</title>
</head>
<body>
    
    <div class="chat_main_body_div">
        <?php
            $sql="SELECT * from `convine_dbs`.follow_users WHERE followed_by='$username';";
            $users=mysqli_query($conn,$sql) or die("Failed to open database") . mysqli_error($conn,$sql);
            
            while($user  = mysqli_fetch_assoc($users)){
            
                $sqlLastMessage="SELECT Message FROM `convine_dbs`.`messages` WHERE (FromUser='".$_SESSION["username"]."'AND ToUser='".$user["username"]."') OR (FromUser='".$user["username"]."' AND ToUser='".$_SESSION["username"]."')  ORDER BY Id DESC LIMIT 1 ;" ;
                $resultLastMessage=mysqli_query($conn,$sqlLastMessage) or die("Failed to query database" .mysqli_error($conn));
                $lastMessage=mysqli_fetch_assoc($resultLastMessage);
                
                $sqlUserProfilePic="SELECT profile_img FROM `convine_dbs`.`users` WHERE username='".$user['username']."';";
                $resultProfilePic=mysqli_query($conn,$sqlUserProfilePic) or die("Failed to query database" .mysqli_error($conn));
                $profilePic=mysqli_fetch_assoc($resultProfilePic);
                
                $ecryptedUsername=base64_encode($user["username"]);
                if(isset($lastMessage["Message"])){
                    echo '
                    <div class="chat_main_div style="padding:10px;"> 
                    <a href="chat_box.php?toUser='.$ecryptedUsername.'">
                    
                    <div class="chat_main_flex_div">
                    <div class="chat_profile_img"> <img src='.$profilePic['profile_img'].'></div>
                    
                    <div class="chat_profile_and_username">
                    <div class="chat_Username">'.$user["username"].'</div>
                    <div class="lastMessage"> '.$lastMessage["Message"].' </div>
                    </div>
                    </div>
                    </a>
                    </div>';
                    
                }
                else{
                    echo '
                    <div class="chat_main_div style="padding:10px;"> 
                    <a href="chat_box.php?toUser='.$ecryptedUsername.'">
                    
                    <div class="chat_main_flex_div">
                    <div class="chat_profile_img"> <img src='.$profilePic['profile_img'].'></div>
                    
                    <div class="chat_profile_and_username">
                    <div class="chat_Username">'.$user["username"].'</div>
                    </div>
                    </div>
                    </a>
                    </div>';
                }
            }
                ?>
    </div>
</body>
</html>