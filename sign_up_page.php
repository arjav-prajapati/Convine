
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="CSS/login&signup_page.css">
</head>
<body>
    <div class="main">
        <form  method="POST" class="form">
            <div class="login_container">
                <div class="logo"> <img src="Assets/convine.png" class="convine_logo" alt="not found"></div>
                <input type="text" name="username" id="username" placeholder="Create your username">
                <input type="text" name="Name" id="Name" placeholder="Enter Your Name">
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <input type="password" name="password" id="password" placeholder="Create your password">
                <input type="password" name="rpt_password" id="rpt_password" placeholder="Repeat your password">
                <div id="error_msg"></div>
                <button name="signup_button" id="sign_up_btn">Sign Up</button>
            </div>
        </form>
        
        
    </div>
</body>
<script>
    document.getElementById("sign_up_btn").addEventListener('click',community_types);
    function community_types(e){
        e.preventDefault();
        let alphaUname = /^[a-zA-Z0-9_]{3,10}$/;
        const alphaEmail= /^[a-zA-Z0-9,\.\_\@]*$/;

        
        var username=document.getElementById('username').value;
        var Name=document.getElementById('Name').value;
        var email=document.getElementById('email').value;
        var password=document.getElementById('password').value;
        var rpt_password=document.getElementById('rpt_password').value;
        
        var insidediv=document.getElementsByClassName('login_container')[0];
        
        var xhr=new XMLHttpRequest(); 
        
        var params="username="+username + "&Name="+Name + "&email="+email + "&password="+password+ "&rpt_password="+rpt_password;
        
        xhr.open('POST','PhpScripts/sign_up_script.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');   
        
        
        if(username=="" || Name=="" || email=="" || password=="" || rpt_password==""){
            setTimeout(() => {
                document.getElementById('error_msg').style="display:none";
            }, 2000);
            document.getElementById('error_msg').style="display:block"
            document.getElementById('error_msg').innerHTML="Please Fill All The Input Fields";
        }
        else if(!alphaUname.test(username)){
            setTimeout(() => {
                document.getElementById('error_msg').style="display:none";
            }, 2000);
            document.getElementById('error_msg').style="display:block"
            document.getElementById('error_msg').innerHTML="Please Enter Valid username";
        }
        else if(!alphaEmail.test(email) || !email.includes('@')){
            setTimeout(() => {
                document.getElementById('error_msg').style="display:none";
            }, 2000);
            document.getElementById('error_msg').style="display:block"
            document.getElementById('error_msg').innerHTML="Please Enter Valid Email";
        }
        else if(password.length < 8){
            setTimeout(() => {
                document.getElementById('error_msg').style="display:none";
            }, 2000);
            document.getElementById('error_msg').style="display:block"
            document.getElementById('error_msg').innerHTML="Password length must be greater then 8!";
        }
        else {

                if(password!=rpt_password){
                    document.getElementById('error_msg').style="display:block";
                    document.getElementById('error_msg').innerHTML="Password doesn't match";
                    
                }
                else {
                    
                    xhr.onload=function(){

                        if(this.responseText=="username already exist"){
                            console.log(this.responseText);
                            document.getElementById('error_msg').style="display:block";
                            document.getElementById('error_msg').innerHTML="usernamae already exist";
                        }
                        else {

                            // console.log(this.responseText);
                            cmntname=JSON.parse(this.responseText);
                            var output="";

                            for(var i in cmntname){
                                output+=
                                '<li class="cmtli" onclick="addcmnt('+cmntname[i].Sr_no+',event)">'+cmntname[i].communities+'</li>' 
                            }
                            document.getElementsByClassName('login_container')[0].innerHTML='<div class="logo"> <img src="Assets/convine.png" class="convine_logo" alt="not found"></div>'+ output + ' <button name="Continue" id="continue"> <a href="front_page.php">Continue </a></button>';
                          
                        }  
                    }
                        
                        xhr.send(params);
                        
                }
            }
}
            
            
         

        function addcmnt(i,event){
            
            // document.getElementsByClassName('cmtli')[i-1].style.backgroundColor="blue";
            // document.getElementsByClassName('cmtli')[i-1].style.color="white";
           
            event.preventDefault();
            
            
            
            var xhr2=new XMLHttpRequest(); 
            var params="Sr_no="+i;
            
            xhr2.open('POST','PhpScripts/add_community_script.php',true);
            xhr2.setRequestHeader('Content-type','application/x-www-form-urlencoded');   
            xhr2.onload=function(){ 
                // console.log(this.responseText);
                var color=JSON.parse(this.responseText);
                console.log(color);
                document.getElementsByClassName('cmtli')[i-1].style.backgroundColor=color.bgcolor;
                document.getElementsByClassName('cmtli')[i-1].style.color=color.color;
                
            }
            xhr2.send(params);
        }

        
        
    
        </script>
</html>