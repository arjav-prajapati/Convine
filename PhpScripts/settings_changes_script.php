<?php
session_start();
include '../dbh/dbh.php';

$username = $_SESSION['username'];

if (!$conn) {
    die("connection to database unsucessful because of error: " . mysqli_connect_error());
}

if(isset($_POST['Name'])){
    $Name=$_POST['Name'];

    $stmt=mysqli_stmt_init($conn);
    $sql =   "UPDATE `convine_dbs`.`users` SET Name = ? WHERE username='{$username}';";

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$Name);
    

    if(mysqli_stmt_execute($stmt)){
        echo $Name;
    }else{
        echo mysqli_error($conn);
    }

}

if(isset($_POST['about'])){
    $about = $_POST['about'];
 
    $stmt=mysqli_stmt_init($conn);

    $sql2 =   "UPDATE `convine_dbs`.`users` SET about = ? WHERE username='{$username}';";
     
    mysqli_stmt_prepare($stmt,$sql2);
    mysqli_stmt_bind_param($stmt,"s",$about);
    

    if(mysqli_stmt_execute($stmt)){
        echo $Name;
    }else{
        echo mysqli_error($conn);
    }
}

if(isset($_POST['selected_gender'])){
    $sql3 =   "UPDATE `convine_dbs`.`users` SET gender ='{$_POST['selected_gender']}' WHERE username='{$username}';";
    mysqli_query($conn,$sql3);
    
//     if(mysqli_query($conn,$sql3)){
//         echo $sql3;
//     }else{
//         mysqli_error($conn);
//     }
}

if(isset($_POST['selected_country'])){
    $sql4 =   "UPDATE `convine_dbs`.`users` SET country ='{$_POST['selected_country']}' WHERE username='{$username}';";
    mysqli_query($conn,$sql4);
    
//     if(mysqli_query($conn,$sql3)){
//         echo $sql3;
//     }else{
//         mysqli_error($conn);
//     }
} 

if(isset($_POST['blocked_username'])){
    $sql6 = "SELECT * FROM `convine_dbs`.`users`;";

    if($username == $_POST['blocked_username']){
        echo 'Ahh!! you are trying to block yourself!';
        exit();
    }

    $result=mysqli_query($conn,$sql6);
    if($result){
        $datas = array();
        if(mysqli_num_rows($result)>0){
            $datas=array();
            while($row = mysqli_fetch_assoc($result)){
                $datas[]=$row; 
            }
        }
        
        foreach ($datas as $key => $value) {
            if($value['username'] == $_POST['blocked_username']){
                $sql7 =   "INSERT INTO `convine_dbs`.`blocked_users` (username,blocked_by) VALUES ('{$_POST['blocked_username']}','$username')";
                mysqli_query($conn,$sql7);
                echo "<img src=\"{$value['profile_img']}\" alt=\"\">
                    <p name = \"block_user_name\" id = \"block_user_name_{$value['username']}\"> {$value['username']} </p>
                    <button name = \"unblock_user_btn\" id=\"unblock_user_btn_{$value['username']}\">UnBlock</button>";
                exit();
            }
        }
        echo 'No user found';
    }else{
        echo mysqli_error($conn,$sql6);
    }
}

if(isset($_POST['unblocked_username'])){
    $sql5 = "DELETE FROM `convine_dbs`.`blocked_users` WHERE username = '{$_POST['unblocked_username']}';";

    if(mysqli_query($conn,$sql5)){
        echo "success";
    }else{
        echo mysqli_error($conn,$sql5);
    }
}

if(isset($_POST['DOB'])){
    $sql6 = "UPDATE `convine_dbs`.`users` SET dob = '{$_POST['DOB']}' WHERE username = '{$username}';";

    if(mysqli_query($conn,$sql6)){
        echo "success";
    }else{
        echo mysqli_error($conn,$sql6);
    }
}

?>