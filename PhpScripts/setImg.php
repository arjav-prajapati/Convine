    <?php
    session_start();
    include '../dbh/dbh.php';

    if($_FILES["myfile"]["name"] != ''){
        $username = $_SESSION['username'];
        $test = explode(".",$_FILES["myfile"]["name"]);
        $extenction = end($test);
        $time = gettimeofday();
        $name =  $time['sec'] . $time['dsttime'] . '.' . $extenction;
        $location =  '../U/' . $username . '/' . $name;

        if($extenction == 'jpeg' || $extenction == 'png' || $extenction == 'jpg' || $extenction == 'ico'){
        

            // $image_file=basename( $_FILES["myfile"]["name"],$extenction);
            // $imgContent = addslashes(file_get_contents($_FILES["myfile"]["name"]));
            $data_store_path = 'U/' . $username . '/' . $name;


            $sql = "SELECT profile_img FROM `convine_dbs`.`users` WHERE username = '{$username}';";

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $datas = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $datas[] = $row;
                }
            }
            $previous_img = '../' . $datas[0]['profile_img'];
            if (file_exists($previous_img) and $datas[0]['profile_img'] != "./Assets/profile.png") {
                unlink($previous_img);
            }


            
            move_uploaded_file($_FILES["myfile"]["tmp_name"],$location);

            

            if (!$conn) {
                die("connection to database unsucessful because of error: " . mysqli_connect_error());
            }
            // else{
            //     echo  $arr['name'];
            // }

            $sql =   "UPDATE `convine_dbs`.`users` SET profile_img ='{$data_store_path}' WHERE username='{$username}';";
            // echo $sql;

            mysqli_query($conn,$sql);

            echo "U/" . $username . "/" . $name;
            // echo "D:/xampp/htdocs/Project_Collage/U/Arjav123/" .$name;
        }
    }


    ?>