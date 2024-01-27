<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/login&signup_page.css">
    <title>Log In Page</title>
</head>

<body>
    <div class="outer_main">

        <div class="main">

            <form action="PhpScripts/log_in_script.php" method="post" class="login_form">

                <div class="login_container">
                    <div class="logo"> <img src="Assets/convine.png" class="convine_logo" alt="not found"></div>
                    <input type="text" name="username" class="username" placeholder="Enter your username">
                    <input type="password" name="password" class="password" placeholder="Enter your password">
                    <div id="error_msg2">
                        <?php
                        if (isset($_GET['error'])) {

                            if ($_GET['error'] == "emptyfields") {
                                echo "Fill all the fields";
                            } else if ($_GET['error'] == "wrongpwd") {
                                echo "Wrong Password";
                            } else if ($_GET['error'] == "no_user") {
                                echo "User not found!";
                            }
                        }
                        ?>
                    </div>
                    <button name="login_button">Log in</button>
                    <?php
                    if( isset($_GET['error'])){

                        if($_GET['error']=='wrongpwd'){
                            echo  '<div class="forget_pass"> Forgot your password? <span id="forget_pass">Click here.</span></div>';
                        }
                    }
                    ?>
                </div>

            </form>

            <div class="sign_up_button">
                <div class="or">OR</div>
                <a href="sign_up_page.php"><button>Don't have an account? Sign up</button></a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('forget_pass').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.main')[0].innerHTML = `
            <div class="login_container"><div class="logo"> <img src="Assets/convine.png" id= "convine_forget_logo_email" class="convine_logo" alt="not found"></div><p>Make sure your E-mail is correct.</p>
            <input type="text" name="user_forget" id="user_forget" placeholder="Enter Your Username Here." required>
  <input type="email" name="user_email" id="user_email" placeholder="Enter Your E-mail Here." required>
  <button type="submit" id="send-otp">Send OTP</button>
  <p id="alert_email"></p></div>`;



            document.getElementById('send-otp').addEventListener('click', function(e) {
                e.preventDefault();
                var user_name = document.getElementById('user_forget').value;
                var user_email = document.getElementById('user_email').value;

                if (user_email == '') {
                    document.getElementById('alert_email').innerText = 'Email expected!!';
                    document.getElementById('alert_email').style.display = 'block';
                    console.log('this');
                } else {
                    let params = "new-email=" + user_email + "&username=" + user_name;

                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'PhpScripts/forget_pass_script.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    document.getElementById('alert_email').innerText = 'Please wait!! We are attempting to send you OTP!';
                    document.getElementById('alert_email').style.display = 'flex';

                    xhr.onload = function() {
                        let data = this.responseText;
                        document.getElementById('alert_email').style.display = 'block';
                        document.getElementById('alert_email').innerText = data;

                        if (data == 'Successfull') {
                            document.querySelectorAll('.main')[0].innerHTML = `<div class="login_container"><div class="logo"> <img src="Assets/convine.png" id= "convine_forget_logo_email" class="convine_logo" alt="not found"></div><p>We send you OTP ,please enter OTP here and new Password.</p>
                                <input type="password" name="pass" id="pass" placeholder="Write New Password Here." required>
                                <input type="password" name="repeat_pass" id="repeat_pass" placeholder="Repeat new Password." required>
          <input type="number" name="otp" id="otp" placeholder="Write OTP here to change Password" required>
          <button type="submit" id="submit_otp">Change</button>
          <p id="alert_otp"></p></div>`;



                            document.getElementById('submit_otp').addEventListener('click', function(e) {
                                if (document.getElementById('pass').value != document.getElementById('repeat_pass').value) {
                                    document.getElementById('alert_otp').display = 'block';
                                    document.getElementById('alert_otp').innerText = 'Please enter same password!';
                                }

                                if (document.getElementById('otp').value != '') {
                                    e.preventDefault();
                                    let get_otp = document.getElementById('otp').value;

                                    let paramsotp = "userEnter_otp=" + get_otp + "&new_pass=" + document.getElementById('pass').value + "&username=" + user_name;

                                    let xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'PhpScripts/forget_pass_script.php', true);
                                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                                    xhr.onload = function() {
                                        let data = this.responseText;
                                        document.getElementById('alert_otp').display = 'block';
                                        document.getElementById('alert_otp').innerText = data;

                                        if (data == 'Password Change Successfully!') {
                                            document.querySelectorAll('.main')[0].innerHTML = `<form action="PhpScripts/log_in_script.php" method="post" class="login_form">

<div class="login_container">
    <div class="logo"> <img src="Assets/convine.png" class="convine_logo" alt="not found"></div>
    <input type="text" name="username" class="username" placeholder="Enter your username">
    <input type="password" name="password" class="password" placeholder="Enter your password">
    <div id="error_msg2">
        <?php
        if (isset($_GET['error'])) {

            if ($_GET['error'] == "emptyfields") {
                echo "Fill all the fields";
            } else if ($_GET['error'] == "wrongpwd") {
                echo "Wrong Password";
            } else if ($_GET['error'] == "no_user") {
                echo "User not found!";
            }
        }
        ?>
    </div>
    <button name="login_button">Log in</button>
    <div class="forget_pass"> Forgot your password? <span id="forget_pass">Click here.</span></div>
</div>

</form>

<div class="sign_up_button">
<div class="or">OR</div>
<a href="sign_up_page.php"><button>Don't have an account? Sign up</button></a>
</div>`;
                                        }
                                    }

                                    xhr.send(paramsotp);
                                }

                            });

                        }
                    }

                    xhr.send(params);
                }


            });



        });
    </script>
</body>

</html>