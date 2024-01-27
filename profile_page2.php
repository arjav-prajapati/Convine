<?php

include "./PhpScripts/NavBar.php";
if(isset($_GET['u'])){

  $username_get=$_GET['u'];
  $sql_select_user="SELECT * FROM `convine_dbs`.`users` WHERE username='$username_get'";
  $result32=mysqli_query($conn,$sql_select_user);
  
  $user_data=array();
  if($row32=mysqli_fetch_assoc($result32)){
    $user_data=$row32;
  } 
  
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Profile</title>
    <link rel="stylesheet" href="CSS/profile.css">
    <link rel="stylesheet" href="CSS/community_page.css">
  </head>
  <body>
    
    <div class="top-main">

      <div class="main-left">
        <div class="about_btn">
          About <img class="about_img" src="Assets/information.png" alt="">
        </div>
        <div class="send_message_to_users">

        <div><img src="Assets/age.png" alt="">18</div>
        <div><img src="Assets/gender.png" alt=""> Male</div>
        <div><img src="Assets/interest.png" alt=""> Gaming,Driving</div>
        <div><img src="Assets/education.png" alt="">IT Diploma</div>
    </div>
  </div>

  <div class="profile-main">
      <div class="profile-following">
        <!-- <strong>Following</strong><br> -->
        <div class="following-no">
          <!-- 0 -->
        </div>
      </div>
    <img src="<?php echo $user_data['profile_img']?>" alt="">

      <div class="profile-followers">
        <!-- <strong>Followers</strong> -->
        <div class="followers-no">
          <!-- 0 -->
        </div>
      </div>
      <div class="profile-about">
          <div class="profile-username">
          <?php if(isset($user_data['username'])){
            echo $user_data['username'];
          } ?>
          </div>  
          <div class="profile-name">
          <?php if(isset($user_data['Name'])){
            echo $user_data['Name'];
          } ?>
        </div>
        <div class="profile-bio">
        <?php if(isset($user_data['about'])){
            echo $user_data['about'];
          } ?>
          </div>
      </div>
    </div>

<div class="main-right">
  <button class="follow-button">Follow</button>
  <button type="button" class="award-button">Give Award</button>
  <div class="award-text-button">
    Don't have one! Buy from <a href="">here</a>.
  </div>
</div>

</div>


<div class="main">
  <div class="left_ghost">
    <div class="left">
          <div class="comments_hardcoded">Comments     <img class="comments_img" src="Assets/comment.png"> </img></div>
          <div class="joined_community">
            <a href="">
              <div><img src="Assets/india.png" alt="">A post of r/india was commented.</div></a>
              <a href="">
                <div><img src="Assets/usa.png" alt="">A post of r/AskUSA was commented.</div></a>
                <a href="">
                  <div><img src="Assets/Marvel.png" alt="">A post of r/Marvel was commented.</div></a>
                  
                  
                </div>
              </div>
            </div>
            
            <div class="center">
          <div class="posts">
            <div class="post-title">
              Posts
            </div>
            <div class="post1">
              
              <div class="postnameinfo">
                <div class="post_community_name">AskIndia</div>
                <div class="post_user_name">Posted by user_Arjav</div>
              </div>
              
              <div class="post_text">Why Indians are So Health Concious?</div>
              <div class="post_img"> </div>
              <div class="post_subtext">I have seen people who gets so much anxity upon health related talks.</div>
              
                  <div class="post_btns">
                      <div class="post_upvote"><img src="Assets/upvote.png" alt=""></div>
                      <div class="post_downvote"><img src="Assets/downvote.png" alt=""></div>
                      <div class="post_comment"><img src="Assets/comment.png" alt=""></div>
                      <div class="post_save"><img src="Assets/save.png" alt=""></div>
                  </div>
                  
                </div> 
                
                
                
                <!-- <div class="post1">
                  
                  <div class="postnameinfo">
                    <div class="post_community_name">AskUSA</div>
                    <div class="post_user_name">Posted by u/Vraj</div>
                  </div>

                  <div class="post_text">Why Americas are So Toxic?</div>
                  <div class="post_img"><img src="Assets/ninja.jpg" alt=""> </div>
                  <div class="post_subtext">I really don't understand</div>
                  
                  <div class="post_btns">
                    <div class="post_upvote"><img src="Assets/upvote.png" alt=""></div>
                      <div class="post_downvote"><img src="Assets/downvote.png" alt=""></div>
                      <div class="post_comment"><img src="Assets/comment.png" alt=""></div>
                      <div class="post_save"><img src="Assets/save.png" alt=""></div>
                    </div>
                    
                  </div> -->
                  
                </div>
      </div>
      
      <div class="right_ghost">
      <div class="right">
        <div class="awards-main">
          <div class="heading-awards">
            Awards
            <img class="main-img" src="Assets/trophy.png" alt="">
          </div>
          <div class="awards-list">
              <div class="award-cell">
                <div class="award-img">
                    <img src="Assets/trophy1.png" alt="">
                  1 Year completion
                </div>
              </div>
              <div class="award-cell">
                <div class="award-img">
                    <img src="Assets/trophy1.png" alt="">
                    email varified
                </div>
              </div>
             
                </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
    

    var username="<?php echo $_GET['u'] ?>";
    var xhr=new XMLHttpRequest();
    var params="u="+username;
   
    xhr.open('POST','./PhpScripts/profile_page_load_data_script.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.onload=function(){
        posts=JSON.parse(this.responseText);
        var output="";
                            for(var i in posts ){
                                
                                if (posts[i].img==""){
                                    output+='<div class="post1" onclick="redirect_comment_page('+posts[i].sno+"," +i+')">'+
                                    '<div class="postnameinfo">'+
                                        '<div class="post_community_name">'+'<a href="community_page.php?C='+posts[i].community+'">'+posts[i].community+'</a></div>'+
                                        '<div class="post_user_name">Posted by '+'<a href="./profile_page.php?u='+posts[i].uploaded_by+'">'+posts[i].uploaded_by+'</a> </div>'+
                                    '</div>'+
                                    '<div class="post_text">'+posts[i].title+'</div>'+
                                    '<div class="post_subtext">'+posts[i].description +'</div>'+
                                    '<div class="post_btns">'+
                        '<div class="post_upvote"><a href="#"><img src="Assets/upvote.png" alt=""></a></div>'+
                        '<div class="post_downvote"><a href="#"><img src="Assets/downvote.png" alt=""></a></div>'+
                        '<div class="post_comment"><a href="#"><img src="Assets/comment.png" alt=""></a></div>'+
                        '<div class="post_save"><a href="#"><img src="Assets/save.png" alt=""></a></div>'+'</div>'+
                        '</div>'}
                                else{

                                    output+='<div class="post1" onclick="redirect_comment_page('+posts[i].sno+"," +i+')">'+
                                    '<div class="postnameinfo">'+
                                        '<div class="post_community_name">'+'<a href="community_page.php?C='+posts[i].community+'">'+posts[i].community+'</a></div>'+
                                        '<div class="post_user_name">Posted by '+'<a href="./profile_page.php?u='+posts[i].uploaded_by+'">'+posts[i].uploaded_by+'</a> </div>'+
                                    '</div>'+
                                    '<div class="post_text">'+posts[i].title+'</div>'+
                                    '<div class="post_img"><img src="'+posts[i].img+'"> </div>'+
                                    '<div class="post_subtext">'+posts[i].description +'</div>'+
                                    '<div class="post_btns">'+
                        '<div class="post_upvote"><a href="#"><img src="Assets/upvote.png" alt=""></a></div>'+
                        '<div class="post_downvote"><a href="#"><img src="Assets/downvote.png" alt=""></a></div>'+
                        '<div class="post_comment"><a href="#"><img src="Assets/comment.png" alt=""></a></div>'+
                        '<div class="post_save"><a href="#"><img src="Assets/save.png" alt=""></a></div>'+'</div>'+
                        '</div>'}
                }
                            document.getElementsByClassName('posts')[0].innerHTML=output;
    }  
    xhr.send(params);
     
    function join_button(){
        var join_button_value=document.getElementById("join_button").innerText;

        if(document.getElementById("join_button").innerText=="Join"){
        document.getElementById("join_button").innerText="Joined";
        }
        else {
        document.getElementById("join_button").innerText="Join";
        }
    }


    function redirect_comment_page(id,class_no){
        
        var a="";
        a=document.getElementsByClassName("post1")[class_no].innerHTML;
        url=`comments_page.php?id=${id}`;
        console.log(url);
             window.location = url;
            // var xhr2=new XMLHttpRequest();
            var params2="data="+a;
            console.log(params2);
            var xhr2=new XMLHttpRequest();
            xhr2.open('POST','./comments_page.php',true);
            xhr2.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            xhr2.onload=function(){

        }

        xhr2.send(params2);
    } 
  </script>

</html>
