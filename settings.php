<?php
include "./PhpScripts/NavBar.php";
require './dbh/dbh.php';
$username = $_SESSION['username'];
$sql = "SELECT * FROM `convine_dbs`.`users` where username = '$username';";;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $datas = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $datas[] = $row;
    }
}

$namelen = strlen($datas[0]['Name']);
$aboutlen = strlen($datas[0]['about']);
$stored_gender = $datas[0]['gender'];
$stored_country = $datas[0]['country'];


// function get_client_ip(){
//     $ipAddress = '';
//     if(isset($_SERVER['HTTP_CLIENT_IP'])){
//         $ipAddress  = $_SERVER['HTTP_CLIENT_IP'];
//     }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
//         $ipAddress  = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
//         $ipAddress  = $_SERVER['HTTP_X_FORWARDED'];
//     }else if(isset($_SERVER['HTTP_FORWARDED'])){
//         $ipAddress  = $_SERVER['HTTP_FORWARDED'];
//     }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
//         $ipAddress  = $_SERVER['HTTP_FORWARDED_FOR'];
//     }else if(isset($_SERVER['REMOTE_ADDR'])){
//         $ipAddress  = $_SERVER['REMOTE_ADDR'];
//     }else{
//         $ipAddress = 'UNKNOWN';
//     }

//     return $ipAddress;    
// }

// echo 'Your IP is: ' . get_client_ip();



$sql3 = "SELECT A.*, B.username FROM `convine_dbs`.`users` AS A INNER JOIN `convine_dbs`.`blocked_users` AS B ON A.username = B.blocked_by;";
$result3 = mysqli_query($conn,$sql3);
$datas3 = array();
if (mysqli_num_rows($result3) > 0) {
    while ($rows3 = mysqli_fetch_assoc($result3)) {
        $datas3[] = $rows3;
    }
}

                            
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/settings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>

    <div id="settings" class="settings">
        <h2>User Settings</h2>
        <div class="settings_menu" role="tablist" aria-label="Sample Tabs">
            <a role="tab" aria-selected="true" aria-controls="panel-1" id="tab-1" tabindex="0">Account</a>
            <a role="tab" aria-selected="false" aria-controls="panel-2" id="tab-2" tabindex="-1">Profile</a>
            <a role="tab" aria-selected="false" aria-controls="panel-3" id="tab-3" tabindex="-1">Privacy & Deletion</a>
            <!-- <a role="tab" aria-selected="false" aria-controls="panel-4" id="tab-4" tabindex="-1">Chat & Messaging</a> -->
        </div>


        <div class="sub_menu">
            <div id="panel-1" role="tabpanel" tabindex="0" aria-labelledby="tab-1">
                <h3>Account Settings</h3>
                <hr>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Email Address</h4>
                        <p id="email_hardcorded"><?php
                            echo $datas[0]['email'];
                            ?></p>
                    </div>
                    <button id="change_email">Change</button>
                </div>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Change Password</h4>
                        <p>Password must be 8 characters long.</p>
                    </div>
                    <button id="change_pass">Change</button>
                </div>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Gender</h4>
                        <p>This information will never share and only uses it to improve what content you see.</p>
                    </div>
                    <label for="gender"></label>
                    <select name="gender" id="gender">
                        <option value="select" >-Select-</option>
                        <option value="Male" >Male</option>
                        <option value="Female">Female</option>
                        <option value="Non-binary">Non-Binary</option>
                        <option value="I-prefer-not-to-say">I prefer not to say</option>
                    </select>
                </div>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Country</h4>
                        <p>Your Acctual Resident</p>
                    </div>
                    <label for="country"></label>
                    <select name="country" id="country">
                    </select>
                </div>

                <div class="sub_menu_settings">
                    <form action="PhpScripts/log_out.php" method="post">
                        <button type="submit" id="logout">Logout</button>
                    </form>
                 </div>
            </div>
            <div id="panel-2" role="tabpanel" tabindex="0" aria-labelledby="tab-2" hidden>
                <h3>Coustamize Settings</h3>
                <hr>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Avtar</h4>
                        <p>Images must be in .png or .jpg format</p>
                        <div class="profile_photo">
                            <form id="img_form" method="POST" enctype="multipart/form-data">
                                <img id="profile_img" src="
                                <?php
                                if ($datas[0]['profile_img'] != null) {
                                    echo $datas[0]['profile_img'];
                                } else {
                                    echo 'Assets/profile.png';
                                }
                                ?>" alt="">
                                <label for="myfile"><img id="edit_profile_img" src="Assets/edit_img.png" alt=""></label>
                                <input type="file" hidden id="myfile" name="myfile" accept="image/*">
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Date Of Birth:</h4>
                        <input type="date" id="birthday" name="birthday" value="<?php 
                        if($datas[0]['dob'] != '' && $datas[0]['dob'] != null){
                            echo $datas[0]['dob']; 
                        }
                        ?>">
                    </div>
                </div>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Name</h4>
                        <p>Set a display name; This does not change your username.</p>
                        <input type="text" name="name" id="name" maxlength="30" placeholder="Display Name">
                        <p id="remaining">Maximum 30 characters allow</p>
                    </div>
                </div>

                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>About (optional)</h4>
                        <p>Breif description of yourself.</p>
                        <textarea name="about" id="about" cols="69" rows="2" placeholder="Tell something about you!"></textarea>
                        <p id="about_remaining"><?php echo 255-$aboutlen; ?> characters Remaining</p>
                    </div>
                </div>

                

            </div>
            <div id="panel-3" role="tabpanel" tabindex="0" aria-labelledby="tab-3" hidden>
                <h3>Safety and Privacy</h3>
                <hr>


                <div class="sub_menu_settings">
                    <div class="sub_menu_settings_name">
                        <h4>Blocked People</h4>
                        <p>Blocked people can't send you message and can't see your personal posts!</p>

                        <div class="block_user_div">
                            <input type="text" name="block_user" id="block_user">
                            <p id="block_p">Block new user</p>
                            <button id="block_user_btn" disabled>ADD</button>
                        </div>

                        <div class="blockuser_list_block" id="blockuser_list_block">
                        <?php 
                            if($datas3 != null){
                                foreach ($datas3 as $key => $value) {
                                    if($value['username']!= null || $value['username']!= ''){
                            ?>
                                    <div class="block_users">
                                        <img src="<?php echo $value['profile_img']; ?> " alt="">
                                        <p name ="block_user_name" id="block_user_name_<?php echo $value['username']; ?> " > <?php echo $value['username'];?> </p>
                                        <button name = "unblock_user_btn" id="unblock_user_btn_<?php echo $value['username']; ?>">UnBlock</button>
                                    </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                            <!-- <div class="block_users">
                                <img src="Assets/chat.png" alt="">
                                <p id="block_user_name">all</p>
                                <button id="unblock_user_btn">UnBlock</button>
                            </div> -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- <div id="panel-4" role="tabpanel" tabindex="0" aria-labelledby="tab-4" hidden>
                <p>Content for the forth panel</p>
                <button id="btn">click</button>
            </div> -->
        </div>
    </div>

    <!--box for change email-->
    <!-- <div id="myModal1" class="modal"> -->

        <!-- Modal content -->
        <!-- <div class="modal-header">
            <span id="email_close" class="close">&times;</span>
            <p>Change E-mail</p>
        </div>

        <div class="modal-content">
            <p>Make sure your E-mail is correct.</p>
            <input type="email" name="new_email" id="new_email" required>
            <button type="submit" id="send-otp">Send OTP</button>
            <p id="alert_email"></p>
        </div> -->

    <!-- </div> -->


    <script>

            let xhr = new XMLHttpRequest();

            xhr.open('GET', 'https://restcountries.com/v3.1/all', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                let data = JSON.parse(this.responseText);

                let option = `<option value="select" id = "select">-Select-</option>`;
                let arrayCountry = [];

                data.forEach(element => {
                    arrayCountry.push(element.name.common);
                });

                arrayCountry.sort();

                arrayCountry.forEach(e => {
                    if('<?php echo $stored_country; ?>' == e){
                        option += `<option value="${e}" id = "${e}" selected>${e}</option>`; 
                    }else{
                        option += `<option value="${e}" id = "${e}">${e}</option>`;
                    }
                    
                });

                document.getElementById('country').innerHTML = option;
            }
            xhr.send();


            /*set the name as default*/

                if (<?php echo $namelen; ?> != 0) {
                    document.getElementById('name').value = "<?php echo $datas[0]['Name']; ?>";
                }

                /*set the about as default*/
                if (<?php echo $aboutlen; ?> != 0) {
                    document.getElementById('about').value = "<?php echo $datas[0]['about']; ?>";
                }

            /*this will show gender */
            let gender_select_childNodes = document.getElementById('gender').children;
            for (let index = 0; index < gender_select_childNodes.length; index++) {
                let element = gender_select_childNodes[index];
                if(element.value == '<?php echo $stored_gender; ?>'){
                    element.selected = true;
                }
            }
        
    </script>
    <script src="javaScripts/settings.js"></script>
</body>

</html>