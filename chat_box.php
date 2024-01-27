<?php
include "./PhpScripts/NavBar.php";
$sql_blocked_users = "SELECT * FROM `convine_dbs`.`blocked_users` WHERE blocked_by = '{$session_user['username']}'";

$result_blocked_users =  mysqli_query($conn, $sql_blocked_users);
if ($result_blocked_users) {
  $datas_blocked_users = array();
  while ($row_blocked_users = mysqli_fetch_assoc($result_blocked_users)) {
    $datas_blocked_users[] = $row_blocked_users['username'];
  }
}



//query to get profile photo of the GET user
$getUserName = base64_decode($_GET["toUser"]);

$sqlProfilePhoto = "SELECT profile_img FROM `convine_dbs`.`users` WHERE username='$getUserName';";
$result = mysqli_query($conn, $sqlProfilePhoto);
$get_profile_photo = mysqli_fetch_assoc($result);
$get_profile_photo = $get_profile_photo['profile_img'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <link rel="stylesheet" href="CSS/chatbox.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Document</title>
</head>

<body>
    <div class="main_div">
        <div class="chat_profile_div">
            <div class="chat_back_button">
                <a href="./chat_system.php">
                    <img src="./Assets/back.png" alt="">
                </a>
            </div>
            <a class=chat_prfoile_photo_and_name href="./profile_page.php?u=<?php echo $getUserName ?>">
                <div class="chat_profile_photo">
                    <img src="<?php echo $get_profile_photo ?>" alt="">
                </div>
                <div class="chat_profile_name">
                    <?php echo $getUserName; ?>
                </div>
        </div>
        </a>
        <div id="msgbody">
            <?php

            if (isset($_GET["toUser"])) {
                $chats = mysqli_query($conn, "SELECT * FROM `convine_dbs`.`messages` WHERE (FromUser='" . $_SESSION["username"] . "'AND ToUser='" .$getUserName . "') OR (FromUser='" .  $getUserName . "' AND ToUser='" . $_SESSION["username"] . "')")
                    or die("Failed to query database" . mysqli_error($conn));
            } else {
                $chats = mysqli_query($conn, "SELECT * FROM `convine_dbs`.`messages` WHERE (FromUser='" . $_SESSION["username"] . "'AND ToUser='" . $_SESSION['toUser'] . "') OR (FromUser='" . $_SESSION["toUser"] . "' AND ToUser='" . $_SESSION["username"] . "')")
                    or die("Failed to query database" . mysqli_error($conn));
            }

            while ($chat = mysqli_fetch_assoc($chats)) {

                if ($chat["FromUser"] ==  $_SESSION["username"]) {
                    echo "<div class='fromuser' '>
                        <p>
                        " . $chat['Message'] . "
                        </p>
                        </div>";
                } else {
                    echo "<div class='touser' style='text-align:left;'>
                    <p>" . $chat['Message'] . "
                    </p>
                    </div>";
                }
            }

            ?>
        </div>
        <!-- <div class="scrollBottom"><button id="scroll_bottom">Scroll To Bottom</button></div> -->
        <div class="textandbutton">
            <input name="" id="message" placeholder="message"></input>
            <button onclick="send_messagee()" id="messageButton" type="submit"><img src="./Assets/send.png" alt=""></button>
        </div>

    </div>

</body>
<script>
    document.getElementById("msgbody").scrollTop = document.getElementById("msgbody").scrollHeight;

    document.getElementById('messageButton').disabled = true;

    document.getElementById('message').addEventListener('input', function() {
        var str = document.getElementById('message').value;
        if (str.trim() == '') {
            document.getElementById('messageButton').disabled = true;
        } else {
            document.getElementById('messageButton').disabled = false;
        }
    })

    function send_messagee() {
        var toUser = '<?php echo $getUserName; ?>';
        var fromUser = '<?php echo $_SESSION['username']; ?>';
        var message = document.getElementById('message').value;

        var xhr = new XMLHttpRequest();
        var params = "fromUser=" + fromUser + "&toUser=" + toUser + "&message=" + message;

        xhr.open('POST', './PhpScripts/insertMessage.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // console.log(this.responseText);
            document.getElementById('message').value = "";
            document.getElementById('messageButton').disabled = true;
        }
        xhr.send(params);
    }

    var refreshIntervalId = setInterval(loaddata, 500);


    function loaddata() {
        var toUser = '<?php echo $getUserName; ?>';
        var fromUser = '<?php echo $_SESSION['username']; ?>';

        var xhr = new XMLHttpRequest();
        var params = "fromUser=" + fromUser + "&toUser=" + toUser;

        xhr.open('POST', './PhpScripts/realTimeChat.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            var receivedData = this.responseText;
            document.getElementById('msgbody').innerHTML = receivedData;

            if (!document.getElementById('msgbody').classList.contains('active')) {
                scrollToBottom();
            }
        }
        xhr.send(params);
    }


    window.onload = function scrollToBottom() {
        var objDiv = document.getElementById("msgbody");
        objDiv.scrollTop = objDiv.scrollHeight;
    }




    function scrollToBottom() {
        var objDiv = document.getElementById("msgbody");
        objDiv.scrollTop = objDiv.scrollHeight;
    }


    input = document.getElementById("message");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("messageButton").click();
        }
    });

    document.getElementById("msgbody").onmouseenter = () => {
        document.getElementById("msgbody").classList.add('active');
    }

    document.getElementById("msgbody").onmouseleave = () => {
        document.getElementById("msgbody").classList.remove('active');
    }


    <?php if(in_array($getUserName,$datas_blocked_users)){ ?>
        document.getElementById('message').setAttribute('disabled',true);
        document.getElementById('message').setAttribute('placeholder','You can\'t send a message to blocked user.');
        document.getElementById('message').style.fontSize = '15px';
        <?php
    }
        ?>
</script>

</html>