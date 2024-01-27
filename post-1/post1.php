<?php
include "./PhpScripts/community_admins_script.php";
include "./dbh/dbh.php";

$sql_blocked_users = "SELECT * FROM `convine_dbs`.`blocked_users` WHERE blocked_by = '{$session_user['username']}'";

$result_blocked_users =  mysqli_query($conn, $sql_blocked_users);
if ($result_blocked_users) {
  $datas_blocked_users = array();
  while ($row_blocked_users = mysqli_fetch_assoc($result_blocked_users)) {
    $datas_blocked_users[] = $row_blocked_users['username'];
  }
}

?>

<script>
  // console.log(community_name);
  if (obj.hasOwnProperty('community_name')) {

    community_name = obj.community_name;
    var xhr = new XMLHttpRequest();
    var params = "community_name=" + community_name;

    xhr.open('POST', './PhpScripts/community_page_load_data_script.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      posts = JSON.parse(this.responseText);
      var output = "";
      for (let i = posts.length-1; i >= 0; i--) {
        let ago = time_ago(posts[i].time);
        if (posts[i].img == "") {
          output += '<div class="post1" id="' + posts[i].sno + '"   onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id="post_settings' + posts[i].sno + '"> <li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_subtext">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        } else {
          output += '<div class="post1" id="' + posts[i].sno + '"  onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id = "post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_img" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="' + posts[i].img + '"> </div>' +
            '<div class="post_subtext" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')" ><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        }
        getVotedata(posts[i].sno);
      }
      document.getElementsByClassName('posts')[0].innerHTML = output;
    }
    
    xhr.send(params);
    var xhr2 = new XMLHttpRequest();
    var params2 = "community_name=" + community_name;

    xhr2.open('POST', './PhpScripts/admins_load_data_script.php', true);
    xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr2.onload = function() { 
     admins= JSON.parse(this.responseText);
     var output = "";
      for (let i in admins) {
        output += ' <a href="profile_page.php?u='+admins[i].username+'"> <div class="admin_main"><div class="admin_name">' + admins[i].username + '</div>' +
        '<div class="profile_img_and_about">'+
         '<div class="admin_profile_img"> <img src="' + admins[i].profile_img+ '"></div>' +
         '<div class="admin_about">' + admins[i].about + '</div></div></div></a>';
      }

    document.getElementsByClassName('admins')[0].innerHTML = output ;
  
  }
    xhr2.send(params2);
}
  else if (obj.hasOwnProperty('all_community')) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', './PhpScripts/all_community_load_data_script.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      // console.log(this.responseText);
      posts = JSON.parse(this.responseText);
      var output = "";
      for (let i = posts.length-1; i >= 0; i--) {
        let ago = time_ago(posts[i].time);
        if (posts[i].img == "") {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings_profile" id="post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_subtext">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        } else {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings_profile" id = "post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_img" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="' + posts[i].img + '"> </div>' +
            '<div class="post_subtext" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')" ><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        }
        getVotedata(posts[i].sno);
      }
      // console.log(output);

      document.getElementsByClassName('posts')[0].innerHTML = output;
    }
    xhr.send();

  } else if (obj.hasOwnProperty('id')) {


    var id = obj.id;
    var c_id = obj.c_id;
    var params4 = "id=" + id;
    var xhr = new XMLHttpRequest();

    xhr.open('POST', './PhpScripts/loadPostOnCommentsPage.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      // console.log(this.responseText);
      posts = JSON.parse(this.responseText);
      // console.log(posts);
      var output = "";
      for (let i = posts.length-1; i >= 0; i--) {
        let ago = time_ago(posts[i].time);

        if (posts[i].img == "") {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id="post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_subtext">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        } else {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id = "post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_img" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="' + posts[i].img + '"> </div>' +
            '<div class="post_subtext" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')" ><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        }
        getVotedata(posts[i].sno);
      }
      // console.log(output);

      document.getElementsByClassName('center')[0].innerHTML = output;
    }
    xhr.send(params4);



    var username = '<?php echo $username; ?>';

    function addcomment_function() {
      document.getElementsByClassName('error_msg')[0].innerHTML = "";

      var xhr2 = new XMLHttpRequest();

      var commentData = document.getElementById('input_data').value;
      var params = "commentData=" + commentData + "&id=" + id + "&commented_by=" + username;

      xhr2.open('POST', './PhpScripts/add_comment_script.php', true);
      xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr2.onload = function() {
        var error = this.responseText;
        if (error == "Please Enter a valid Comment") {

          document.getElementsByClassName('error_msg')[0].innerHTML = error;

        }
        loadCommentsPage();
      }

      xhr2.send(params);
      document.getElementById('input_data').value = "";

    }

    function loadCommentsPage() {

      var xhr3 = new XMLHttpRequest();
      var params = "id=" + id + "&c_id=" + c_id;

      xhr3.open('POST', './PhpScripts/load_comments_script.php', true);
      xhr3.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr3.onload = function() {
        // console.log(this.responseText);



        if (this.responseText == "") {
          document.getElementsByClassName('comments_data_main_div')[0].innerHTML = "";

        } else {

          comments = JSON.parse(this.responseText);

          // console.log(comments);
          output = "";
          for (var i = comments.length - 1; i >= 0; i--) {

            output += '<div class="comments_data_div"> <div class="username"><a href="./profile_page.php?u=' + comments[i].commented_by + '">' + comments[i].commented_by + '</a></div>' +
              '<div class="comment_data">' + comments[i].comment + '</div></div>';

          }

          document.getElementsByClassName('comments_data_main_div')[0].innerHTML = output;
        }

      }
      xhr3.send(params);

    }
    window.onload = loadCommentsPage;
  } else if (obj.hasOwnProperty('profile_user')) {

    let user = obj.profile_user;
    var xhr = new XMLHttpRequest();
    // var params="community_name="+community_name;

    let params_profile_user = "u=" + user;
    // console.log(blocked_users);

    xhr.open('POST', 'PhpScripts/profile_page_load_posts_script.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      // console.log(this.responseText);
      posts = JSON.parse(this.responseText);
      var output = "";
      for (let i = posts.length-1; i >= 0; i--) {

        let ago = time_ago(posts[i].time);
        if (posts[i].img == "") {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id="post_settings' + posts[i].sno + '"> <li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_subtext">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        } else {
          output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
            '<div class="postnameinfo">' +
            '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
            '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id = "post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
            '</div>' +
            '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
            '<div class="post_img" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="' + posts[i].img + '"> </div>' +
            '<div class="post_subtext" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].description + '</div>' +
            '<div class="post_btns">' +
            '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
            '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
            '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
            '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')" ><img src="Assets/comment.png" alt=""></div>' +
            '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
        }
        getVotedata(posts[i].sno);
      }
      // console.log(output);
      document.getElementsByClassName('center')[0].innerHTML = output;
    }
    xhr.send(params_profile_user);
  } else {
    let blocked_users = <?php echo json_encode($datas_blocked_users); ?>;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './PhpScripts/front_page_load_data_script.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      // console.log(this.responseText);
      posts = JSON.parse(this.responseText);
      var output = "";
      for (let i = posts.length-1; i >= 0; i--) {
        let post_sno = posts[i].sno;


        let ago = time_ago(posts[i].time);
        if (!blocked_users.includes(posts[i].uploaded_by)) {
          if (posts[i].img == "") {
            output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
              '<div class="postnameinfo">' +
              '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
              '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '"> ' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id="post_settings' + posts[i].sno + '"> <li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
              '</div>' +
              '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
              '<div class="post_subtext">' + posts[i].description + '</div>' +
              '<div class="post_btns">' +
              '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
              '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
              '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
              '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="Assets/comment.png" alt=""></div>' +
              '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
          } else {
            output += '<div class="post1" id="' + posts[i].sno + '" data-aos="zoom-in-down" onmouseover="mouseoverfunc(this,\'' + posts[i].uploaded_by + '\',' + '\'' + posts[i].community + '\' ' + ',' + posts[i].sno + ')" onmouseleave="mouseleavefunc(this,' + posts[i].sno + ')" >' +
              '<div class="postnameinfo">' +
              '<div class="post_community_name">' + '<a href="community_page.php?C=' + posts[i].community + '">' + posts[i].community + '</a></div>' +
              '<div class="post_user_name"> Posted by&nbsp' + '<a href="./profile_page.php?u=' + posts[i].uploaded_by + '">' + posts[i].uploaded_by + '</a>' + '<span>&#10247;</span>' + '</div>' + '<div class = "post_settings" id = "post_settings' + posts[i].sno + '"><li onclick="delete_post(' + posts[i].sno + ')" id = "delete_post">Delete Post</li></div>' +
              '</div>' +
              '<div class="post_text" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].title + '</div>' +
              '<div class="post_img" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')"><img src="' + posts[i].img + '"> </div>' +
              '<div class="post_subtext" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')">' + posts[i].description + '</div>' +
              '<div class="post_btns">' +
              '<div class="post_upvote" onclick="upvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "upvote_img' + posts[i].sno + '" src="Assets/upvote.png" alt=""></div>' +
              '<div id = "count_votes_for_' + posts[i].sno + '"  class="count_votes">' + posts[i].votes + '</div>' +
              '<div class="post_downvote" onclick="downvoteClicked(' + posts[i].sno + "," + i + ')"><img id= "downvote_img' + posts[i].sno + '" src="Assets/downvote.png" alt=""></div>' +
              '<div class="post_comment" onclick="redirect_comment_page(' + posts[i].sno + "," + i + ')" ><img src="Assets/comment.png" alt=""></div>' +
              '</div>' + '<div class="posted_time" id = "posted_time">' + ago + '</div>' + '</div>';
          }
          getVotedata(post_sno);
        }
      }
      // console.log(output);
      document.getElementsByClassName('center')[0].innerHTML = output;

    }
    xhr.send();


  }



  function redirect_comment_page(id, class_no) {

    var a = "";
    a = document.getElementsByClassName("post1")[class_no].innerHTML;
    url = `comments_page.php?id=${id}`;
    console.log(url);
    window.location = url;
    // var xhr2=new XMLHttpRequest();
    var params2 = "data=" + a;
    console.log(params2);
    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', './comments_page.php', true);
    xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr2.onload = function() {

    }

    xhr2.send(params2);
  }


  // upvote 

  function upvoteClicked(i, class_no) {
    var username = '<?php echo $_SESSION['username'];  ?>';
    var params3 = "post_id=" + i + "&upvote=" + true + "&username=" + username;

    // if(document.getElementById('upvote_img'+i).src = "http://localhost/Project_Collage/Assets/upvoted.png"){
    //   document.getElementById('upvote_img'+i).src = "./Assets/upvote.png";
    //   console.log(document.getElementById('upvote_img'+i).src);
    // }else if(document.getElementById('upvote_img'+i).src = "http://localhost/Project_Collage/Assets/upvote.png"){
    //   document.getElementById('upvote_img'+i).src = "./Assets/upvoted.png";
    //   console.log(document.getElementById('upvote_img'+i).src);
    // }
    var xhr3 = new XMLHttpRequest();
    xhr3.open('POST', './PhpScripts/voted_script.php', true);
    xhr3.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr3.onload = function() {
      if (document.getElementById('count_votes_for_' + i).innerHTML <= this.responseText) {
        document.getElementById('downvote_img' + i).src = "./Assets/downvote.png";
        document.getElementById('upvote_img' + i).src = "./Assets/upvoted.png";
      } else if (document.getElementById('count_votes_for_' + i).innerHTML > this.responseText) {
        document.getElementById('upvote_img' + i).src = "./Assets/upvote.png";
      }
      document.getElementById('count_votes_for_' + i).innerHTML = this.responseText;

    }

    xhr3.send(params3);
  }

  function downvoteClicked(i, class_no) {

    var username = '<?php echo $_SESSION['username'];  ?>';
    var params3 = "post_id=" + i + "&downvote=" + true + "&username=" + username;

    var xhr3 = new XMLHttpRequest();
    xhr3.open('POST', './PhpScripts/voted_script.php', true);
    xhr3.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr3.onload = function() {
      if (document.getElementById('count_votes_for_' + i).innerHTML >= this.responseText) {
        document.getElementById('upvote_img' + i).src = "./Assets/upvote.png";
        document.getElementById('downvote_img' + i).src = "./Assets/downvoted.png";
      } else if (document.getElementById('count_votes_for_' + i).innerHTML < this.responseText) {
        document.getElementById('downvote_img' + i).src = "./Assets/downvote.png";
      }

      document.getElementById('count_votes_for_' + i).innerHTML = this.responseText;

    }

    xhr3.send(params3);
  }




  function mouseoverfunc(e, posted_by, posted_community, post_number) {
    let selectpost = e.querySelector('div.post_user_name');
    let selectpostSpan = selectpost.querySelector('span');
    let post_settings = document.getElementById('post_settings' + post_number);
    let passedArray =
      <?php
      echo json_encode($user_admin);
      ?>;

    let bool = false;
    passedArray.forEach(element => {
      if (element.communities == posted_community) {
        bool = true;
      }
    });

    if (e.onmouseover && ('<?php echo $_SESSION['username']; ?>' == posted_by || bool)) {
      selectpostSpan.style.display = 'block';
    }
    // selectpostSpan.style.display = 'block';
    selectpostSpan.onclick = function() {
      if (post_settings.style.display == 'block') {
        post_settings.style.display = 'none';
      } else {
        post_settings.style.display = 'block';
      }

    }
  }

  function mouseleavefunc(e, post_number) {
    let selectpost = e.querySelector('div.post_user_name');
    let selectpostSpan = selectpost.querySelector('span');
    let post_settings = document.getElementById('post_settings' + post_number);
    post_settings.style.display = 'none';
    selectpostSpan.style.display = 'none';
  }

  function delete_post(post_number) {
   
      let params_del = "post_sno=" + post_number;

      let xhrd = new XMLHttpRequest();
      xhrd.open('POST', './PhpScripts/delete_post.php', true);
      xhrd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      xhrd.onload = function() {
        let data_xhrd = this.responseText;
        // console.log(data_xhrd);

        if (data_xhrd == 'successfull') {
          document.getElementById('' + post_number).remove();
        }
      }

      xhrd.send(params_del);
    

  }

  function time_ago(timestamp) {
    let postDate = new Date(timestamp);
    let currentTime = new Date();


    // To calculate the time difference of two dates
    let time_diff = currentTime.getTime() - postDate.getTime();
    let seconds = time_diff / 1000;
    let minutes = 0;
    let hours = 0;
    let days = 0;
    let weeks = 0;
    let months = 0;
    let years = 0;

    minutes = Math.round(seconds / 60); // value 60 is seconds  
    hours = Math.round(seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    days = Math.round(seconds / 86400); //86400 = 24 * 60 * 60;  
    weeks = Math.round(seconds / 604800); // 7*24*60*60;  
    months = Math.round(seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    years = Math.round(seconds / 31553280);


    // To calculate the no. of days between two dates
    // let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24)

    if (seconds <= 60) {
      return "Just Now";
    } else if (minutes <= 60) {
      if (minutes == 1) {
        return "one minute ago";
      } else {
        return minutes + " minutes ago";
      }
    } else if (hours <= 24) {
      if (hours == 1) {
        return "an hour ago";
      } else {
        return hours + " hrs ago";
      }
    } else if (days <= 7) {
      if (days == 1) {
        return "yesterday";
      } else {
        return days + " days ago";
      }
    } else if (weeks <= 4.3) //4.3 == 52/12  
    {
      if (weeks == 1) {
        return "a week ago";
      } else {
        return weeks + " weeks ago";
      }
    } else if (months <= 12) {
      if (months == 1) {
        return "a month ago";
      } else {
        return months + " months ago";
      }
    } else {
      if (years == 1) {
        return "one year ago";
      } else {
        return years + " years ago";
      }
    }
  }

  function getVotedata(post_number) {
    let params_del = "post_sno=" + post_number;

    let xhv = new XMLHttpRequest();
    xhv.open('POST', 'post-1/getUserVotedata_script.php', true);
    xhv.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhv.onload = function() {
      let data_xhv = this.responseText;
      if (data_xhv == 'upvote') {
        // console.log(document.querySelector('.post_upvote').childNodes);
        document.getElementById('upvote_img' + post_number).src = "./Assets/upvoted.png";

      } else if (data_xhv == 'downvote') {
        // console.log(document.querySelector('.post_upvote').childNodes);
        document.getElementById('downvote_img' + post_number).src = "./Assets/downvoted.png";
      }


    }

    xhv.send(params_del);
  }
</script>