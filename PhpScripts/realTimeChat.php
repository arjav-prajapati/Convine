<?php
include "../dbh/dbh.php";

$toUser= mysqli_real_escape_string($conn, $_POST['toUser']);
$fromUser=mysqli_real_escape_string($conn, $_POST['fromUser']);
$output="";

$chats= mysqli_query($conn,"SELECT * FROM `convine_dbs`.`messages` WHERE (FromUser='".$fromUser."'AND ToUser='".$toUser."') OR (FromUser='".$toUser."' AND ToUser='".$fromUser."')") 
or die("Failed to query database" .mysqli_error($conn));

while($chat=mysqli_fetch_assoc($chats)){
                
    if ($chat["FromUser"] ==  $fromUser){
        $output.="<div class='fromuser' >
        <p>
        ".$chat['Message']."
        </p>
        </div>";
    }
    else{
        $output.="<div class='touser' >
        <p>".$chat['Message']."
        </p>
        </div>";
    }
}   

    echo $output;