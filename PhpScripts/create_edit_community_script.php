<?php
session_start();
include "../dbh/dbh.php";

if (isset($_POST['community_name'])) {
    $sql2 = "SELECT communities FROM `convine_dbs`.`communities_table`;";
    $result2 = mysqli_query($conn, $sql2);

    if ($result2) {
        $fetch_communities = array();
        if (mysqli_num_rows($result2) > 0) {
            $fetch_communities = array();
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $fetch_communities[] = $row2;
            }
        }
    }

    $lengtharray = sizeof($fetch_communities)+1;
    $username =  $_SESSION['username'];
    $community_name = $_POST['community_name'];

    mkdir("../C/" . $community_name);
    mkdir("../C/" . $community_name . "/Community_Profile_picture");

    $test = explode(".", $_FILES["myfile"]["name"]);
    $extenction = end($test);
    $time = gettimeofday();
    $name =  $time['sec'] . $time['dsttime'] . '.' . $extenction;

    $location =  '../C/' . $_POST['community_name'] . '/Community_Profile_picture/' . $name;
    $data_store_path = './C/' . $_POST['community_name'] . '/Community_Profile_picture/' . $name;

    if ($extenction == 'jpeg' || $extenction == 'png' || $extenction == 'jpg' || $extenction == 'ico' || $_FILES["myfile"]["name"] == null || $_FILES["myfile"]["name"] == '') {
        $community_desc = $_POST['community_desc'];

        foreach ($fetch_communities as $key => $value) {
            if ($value['communities'] == $_POST['community_name']) {
                echo "This community name is already taken! Please Enter Something else!";
                exit();
            }
        }

        move_uploaded_file($_FILES["myfile"]["tmp_name"], $location);


        if (!$conn) {
            die("connection to database unsucessful because of error: " . mysqli_connect_error());
        }
        // else{
        //     echo  $arr['name'];
        // }

        if ($_FILES["myfile"]["name"] == null || $_FILES["myfile"]["name"] == '') {
            $sql =   "INSERT INTO `convine_dbs`.`communities_table` (`Sr_no`,`communities`, `description`) VALUES ('{$lengtharray}','{$community_name}','{$community_desc}');";
        } else {
            $sql =   "INSERT INTO `convine_dbs`.`communities_table` (`Sr_no`,`communities`, `description`, `community_img`) VALUES ('{$lengtharray}','{$community_name}','{$community_desc}','{$data_store_path}');";
        }
        // echo $sql;



        if (mysqli_query($conn, $sql)) {
            $sql3 = "INSERT INTO `convine_dbs`.`joined_users` (`communities`,`joined_users`) values('{$community_name}','{$username}')";
            if (mysqli_query($conn, $sql3)) {
                // echo 'success2';
            }

            $sql4 = "INSERT INTO `convine_dbs`.`admins` (`communities`,`admin_name`) values('{$community_name}','{$username}')";
            if (mysqli_query($conn, $sql4)) {
                // echo 'success4';
            }
        } else {
            echo 'Community couldn\'t create :(';
        }


        echo "Community created successfully!";
        // echo "D:/xampp/htdocs/Project_Collage/U/Arjav123/" .$name;
    }
}


if (isset($_POST['edit_desc']) || isset($_FILES['edit_img']["name"])) {
    $sql6 = "SELECT * FROM `convine_dbs`.`communities_table` where communities = '{$_POST['edit_name']}';";
    $result6 = mysqli_query($conn, $sql6);

    if ($result6) {
        $fetch_community6 = array();
        if (mysqli_num_rows($result6) > 0) {
            $fetch_community6 = array();
            while ($row6 = mysqli_fetch_assoc($result6)) {
                $fetch_community6[] = $row6;
            }
        }
    }
    
    $sql5 = '';
    if (isset($_FILES['edit_img']["name"]) && $_FILES['edit_img']["name"] != '' && $_FILES['edit_img']["name"] != null){
        $test = explode(".", $_FILES["edit_img"]["name"]);
        $extenction = end($test);
        $time = gettimeofday();
        $name =  $time['sec'] . $time['dsttime'] . '.' . $extenction;

        $location =  '../C/' . $_POST['edit_name'] . '/Community_Profile_picture/' . $name;
        $data_store_path = './C/' . $_POST['edit_name'] . '/Community_Profile_picture/' . $name;

        move_uploaded_file($_FILES["edit_img"]["tmp_name"], $location);

        $previous_img = '.'  . $fetch_community6[0]['community_img'];
        if (file_exists($previous_img)) {
            unlink($previous_img);
        }

        $sql5 = "UPDATE `convine_dbs`.`communities_table` SET community_img = ? , description = ? WHERE communities='{$_POST['edit_name']}';";

        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql5)){
            echo "failed";
        }

        mysqli_stmt_bind_param($stmt,"ss",$data_store_path,$_POST['edit_desc']);
                        
        
        if (mysqli_stmt_execute($stmt)) {
            // echo 'success2';
            echo './C/' . $_POST['edit_name'] . '/Community_Profile_picture/' . $name;
        } else {
            echo 'cannot change';
        }
    }else{
        $sql5 = "UPDATE `convine_dbs`.`communities_table` SET description = ?  WHERE communities='{$_POST['edit_name']}';";

        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql5)){
            echo "failed";
        }

        mysqli_stmt_bind_param($stmt,"s",$_POST['edit_desc']);

        if (mysqli_stmt_execute($stmt)) {
            // echo 'success2';
            echo 'Desc change successfully';
        } else {
            echo 'cannot change';
        }
    }

    

}
// }else{
//     echo 'You didn\'t change anything';
// }
?>