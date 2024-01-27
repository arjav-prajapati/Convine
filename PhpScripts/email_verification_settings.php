<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../dbh/dbh.php';


$name = $_SESSION['username'];
$otp = substr(number_format(time() * rand(),0,'',''),0,6);
$verification_code = $otp;

if (isset($_POST['new-email'])) {
    $sql = "SELECT * FROM `convine_dbs`.`users` WHERE username = '{$name}';";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $datas = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
        }
    }


    $newEmail = $_POST['new-email'];
    $to = $newEmail;
    $mail = new PHPMailer(true);

    if($newEmail == $datas[0]['email']){
        echo 'You are trying to change same Email';
        exit();
    }

    $_SESSION['new_email']="$newEmail";
    $_SESSION['otp'] = $verification_code;
    try{
        //Enable verbose debug output
        $mail->SMTPDebug = 0;

        //Send using SMTP
        $mail->isSMTP();

        //set the SMTP sever to send through
        $mail->Host = 'smtp.gmail.com';

        //Enable SMTP Authentication
        $mail->SMTPAuth = true;

        //SMTP username
        $mail->Username = 'sender@gmail.com'; // add email address of sender

        //SMTP Password 
        $mail->Password = ''; //please add some password here

        //Enable TLS encryption
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //TCP port to connect to , use 465 for PHPMailer::ENCRYPTION_SMTPS
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('sender@gmail.com','Convine');

        //Add a recipients
        $mail->addAddress($newEmail,$datas[0]['Name']);

        //set email format to html
        $mail->isHTML(true);

        $mail->Subject = "Email verification";
        $mail->Body = "<html>
                        <body>
                        <div>
                            <div>Dear, " . $datas[0]['Name'] . "</div>
                        </br></br>
                            <div style='padding-top:8px;'>
                                Your Verification code for email verification is: 
                            </div>
                            <div style='padding-top:10px; display:block'>
                                Your Varification Code is: <div style='margin:auto; width:fit-content;background-color:black;color:white;padding:10px'>" . $verification_code . " 
                            </div>
                            <div style='padding-top:4px;'>
                                by applying this otp your email address will be changed.
                            </div>
                        </div>
                    </body>
                </html>";

        $mail->send();
        echo 'Successfull';

    }catch(Exception $e){
        // echo $newEmail . " mail couldn't send " . $e ;
        echo 'Can\'t send E-mail please recheck your E-mail';
    }
}


if(isset($_POST['userEnter_otp'])){
    $userEnter_otp = $_POST['userEnter_otp'];
    if($_SESSION['otp'] == $userEnter_otp){
        $sql2 =   "UPDATE `convine_dbs`.`users` SET email ='{$_SESSION['new_email']}' WHERE username='{$name}';";
        
        if(mysqli_query($conn,$sql2)){
            echo 'Email Change Successfully!';
            unset($_SESSION['new_email']);
            unset($_SESSION['otp']);
        }else{
            mysqli_error($conn);
        }
    }else{
        echo 'Wrong OTP';
    }
}
