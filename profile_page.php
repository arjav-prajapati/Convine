<?php
include "./PhpScripts/NavBar.php";
include "./PhpScripts/community_admins_script.php";
date_default_timezone_set('Asia/Kolkata');

$profile_user = $_GET['u'];

$sql_age = "SELECT TIMESTAMPDIFF(YEAR, `dob`, CURDATE()) AS age FROM `convine_dbs`.`users` WHERE username='{$profile_user}';";
$result_age = mysqli_query($conn, $sql_age);

if (mysqli_num_rows($result_age) > 0 && $result_age != NULL) {
  $age = mysqli_fetch_assoc($result_age);
} else {
  $age = 'Undefined';
}

$sql_profile_details = "SELECT * FROM `convine_dbs`.`users` WHERE username = '{$profile_user}'";
$result_profile_users =  mysqli_query($conn, $sql_profile_details);

if (mysqli_num_rows($result_profile_users) > 0) {

  $datas_profile_users = mysqli_fetch_assoc($result_profile_users);
}



$sql_followers = "SELECT followed_by FROM `convine_dbs`.`follow_users` WHERE username = '{$profile_user}'";
$count_followers = 0;
$result_followers = mysqli_query($conn, $sql_followers);
if (mysqli_num_rows($result_followers) > 0) {
  $count_followers = mysqli_num_rows($result_followers);
}

$sql_following = "SELECT username FROM `convine_dbs`.`follow_users` WHERE followed_by = '{$profile_user}'";
$count_following = 0;
$result_following = mysqli_query($conn, $sql_following);
if (mysqli_num_rows($result_following) > 0) {
  $count_following = mysqli_num_rows($result_following);
}

$sql_following_follow_hardcoded = "SELECT * FROM `convine_dbs`.`follow_users` WHERE username = '{$_GET['u']}' AND followed_by = '{$session_user['username']}'";
$result_following_follow_hardcoded = mysqli_query($conn, $sql_following_follow_hardcoded);
$datas_following_follow_hardcoded = false;
if (mysqli_num_rows($result_following_follow_hardcoded) == 1) {
  $datas_following_follow_hardcoded = true;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Profile</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="CSS/profile.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
 </head>

<body>

  <div class="top-main">


    <div class="profile-main">

    <div class="profile_main_div1">
      
      <div class="profile-img">
        <img src="<?php echo $datas_profile_users['profile_img']; ?>" alt="">
      </div>
      
      <div class="profile-about">
        
        <div class="profile-username-and-follow">
          <div class="profile-username">
            <?php echo $datas_profile_users['username']; ?>
          </div>
          <div class="follow-btn-div">

          <?php if ($profile_user != $session_user['username']) {
                if ($datas_following_follow_hardcoded) {
                  echo '<button id="follow_button"  class="follow-button-following" onclick="followButton()" >Following</button>';
                } else {
                  echo '<button id="follow_button"  class="follow-button" onclick="followButton()">Follow</button>';
                }
              }
              ?>
            </div>
        </div>
        <div class="profile-name">
          <?php echo $datas_profile_users['Name']; ?>
        </div>

        <div class="profile-following-followers">
          <div class="profile-followers">
            <b><?php echo $count_followers; ?></b>
            Followers   
          </div>

          <div class="profile-following">
            <b><?php echo $count_following; ?></b>
          Following
          </div>
          
        </div>
        
        
      </div>
    </div>
    <div class="profile_main_div2">
      
      <div class="profile-bio">
     
          <?php echo $datas_profile_users['about']; ?>
     
      </div>

      </div>
    </div>

    <div class="main-right">
      <div class="about_btn">
        About <img class="about_img" src="Assets/information.png" alt="">
      </div>
      <div class="send_message_to_users">

        <div><img src="Assets/age.png" alt=""><?php if ($datas_profile_users['dob'] != NULL && $datas_profile_users['dob'] != '') {
                                                echo $age['age'];
                                              } else {
                                                echo 'Undefined';
                                              } ?></div>
        <div><img src="Assets/gender.png" alt=""> <?php if ($datas_profile_users['gender'] != 'select') {
                                                    echo $datas_profile_users['gender'];
                                                  } else {
                                                    echo 'Undefined';
                                                  } ?></div>
        <!-- <div><img src="Assets/interest.png" alt=""> Gaming,Driving</div> -->
        <!-- <div><img src="Assets/education.png" alt="">IT Diploma</div> -->
      </div>
      <!-- <button type="button" class="award-button">Give Award</button>
  <div class="award-text-button">
    Don't have one! Buy from <a href="">here</a>.
  </div> -->
    </div>

  </div>
<div class="mainer">

  <div class="button-box">
    <button id="button-2" onclick="openPosts()">Posts</button>
    <button id="button-1" onclick="openComments()">Comments</button>
  </div>
  
  <div class="main" id="comments-content">  
    <div class="comments" ></div>  
  </div>

  <div class="main"  id="posts-content">  
      <div class="center"> <!-- posts to show --></div>
    </div>
  

    
  </div>
</div>
    

  
</body>
<script>
// Script to diffrent open tab views
      var commentsContent=document.getElementById('comments-content');
      var postsContent=document.getElementById('posts-content');
      
      var btn1=document.getElementById('button-1');
      var btn2=document.getElementById('button-2');

      function openComments(){
        commentsContent.style.transform="translateX(0px)";
        postsContent.style.transform="translateX(100%)";
        btn1.style.color="#4f45d3";
        btn2.style.color="#000";
        commentsContent.style.transitionDelay="0.3s";
        commentsContent.style.display="block";
        postsContent.style.transitionDelay="0.3s";
        postsContent.style.display="none";
        
      }
      function openPosts(){ 
        postsContent.style.display="block";
        commentsContent.style.display="none";
        postsContent.style.transform="translateX(0)";
        btn2.style.color="#4f45d3";
        btn1.style.color="#000";
        commentsContent.style.transitionDelay="0.3s";
        commentsContent.style.display="none";
        postsContent.style.transitionDelay="0.3s";
      } 
</script>



<script>
  var obj = {
    profile_user:'<?php echo $profile_user; ?>'
  };
</script>


<?php include "./post-1/post1.php"; ?>


<script>



  var username="<?php echo $_GET['u'] ?>";
                          var xhr3=new XMLHttpRequest();
                          var params3="u="+username;
                          
                          xhr3.open('POST','./PhpScripts/profile_page_load_comments.php',true);
                          xhr3.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                          xhr3.onload=function(){
                            // console.log(this.responseText);
                            var comments=JSON.parse(this.responseText);
                            var output2="";
                            for(var i in comments ){
                              output2+='<a href="comments_page.php?id='+comments[i].post_id+'&c_id='+comments[i].comment_id+'"><div>'+comments[i].comment+'</div></a>'
                            }
                            document.getElementsByClassName('comments')[0].innerHTML=output2;
                            // console.log(output2);
                           }
                          xhr3.send(params3);




  function followButton(){

var followButtonText= document.getElementById('follow_button');

if(followButtonText.innerText=="Following"){
followButton.innerText="Unfollow";
var xhr=new XMLHttpRequest();
var username='<?php echo $_GET['u']; ?>';
var followedBy='<?php echo $_SESSION['username']; ?>';
var action="unfollow";

var params="username="+username+"&followedBy="+followedBy+"&action="+action;
              
xhr.open('POST','./PhpScripts/followScript.php',true);
xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
xhr.onload=function(){ 

    // console.log(this.responseText);
    followButtonText.innerText=this.responseText;
    followButtonText.style="background-color:rgb(215, 144, 255); color:rgb(255, 255, 255)";
}

xhr.send(params);
}
else{ 

var xhr=new XMLHttpRequest();
var username='<?php echo $_GET['u']; ?>';
var followedBy='<?php echo $_SESSION['username']; ?>';
var action="follow";

var params="username="+username+"&followedBy="+followedBy+"&action="+action;
              
xhr.open('POST','./PhpScripts/followScript.php',true);
xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
xhr.onload=function(){ 

    // console.log(this.responseText);
    followButtonText.innerText=this.responseText;
    followButtonText.style="background-color: rgb(255, 255, 255); color:rgb(215, 100 ,255)";
}

xhr.send(params);
} 
}

 


 

  function getAge(dateString) {
    let ageInMilliseconds = new Date() - new Date(dateString).getTime();
    return Math.floor(ageInMilliseconds / 1000 / 60 / 60 / 24 / 365); // convert to years
  }

  // document.getElementById('age').innerHTML ="<img src='Assets/age.png' alt=''>" + getAge('');
</script>

</html>