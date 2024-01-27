<?php
include "./PhpScripts/NavBar.php";
include "./dbh/dbh.php";
include "./PhpScripts/community_admins_script.php";

$community_name = $_GET['C'];

$sql = "SELECT * FROM `convine_dbs`.`communities_table` WHERE communities='{$community_name}'";

$result = mysqli_query($conn, $sql);

if ($result) {
  $selected_community = array();
  if (mysqli_num_rows($result) > 0) {
    $selected_community = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $selected_community[] = $row;
    }
  }
}


$sql_join_joined_hardcoded = "SELECT * FROM `convine_dbs`.`joined_users` WHERE communities = '{$_GET['C']}' AND joined_users = '{$session_user['username']}'";
$result_join_joined_hardcoded = mysqli_query($conn, $sql_join_joined_hardcoded);
$datas_join_joined_hardcoded = false;
if (mysqli_num_rows($result_join_joined_hardcoded) == 1) {
  $datas_join_joined_hardcoded = true;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
  <title>Community Page</title>
  <link rel="stylesheet" href="./CSS/community_page.css">
  <!-- <link rel="stylesheet" href="CSS/front_page.css"> -->
  <?php include "./PhpScripts/transition.php"; ?>

</head>

<body>




  <div class="divide_community_profile">
    <!--This is upper rectangle which is dividing posts and upper rectangle-->
    
    <div class="sub_center_profile">
      <!--This is a division for circular image-->
      <div class="sub_center_profile_img">

        <img id="community_html_img" src="
        <?php
            echo $selected_community[0]['community_img'];
            ?>
            " alt="INDIA">
          </div>
            <div class="community_profile_content">
      <!--whole desc. including name , desc. and Unfollow button-->
      <div class="header_communityname_n_join">
        <!-- Name and join button div-->
        <div class="header_community_name"><?php echo $selected_community[0]['communities']; ?></div>

        <div class="header_community_join"><button type="submit" onclick="join_button()" id="join_button"><?php
                                                                                                          if ($datas_join_joined_hardcoded) {
                                                                                                            echo 'Joined';
                                                                                                          } else {
                                                                                                            echo 'Join';
                                                                                                          }
                                                                                                          ?></button></div>
        <div id="edit_community" class="edit_community">
          <button id="edit_community_btn"><img src="Assets/edit_img.png" alt=""></button>
        </div>
      </div>

      <div class="community_page_description">
        <!--community desc.-->
        <div name="community_desc" id="community_desc"><?php echo $selected_community[0]['description']; ?></div>
      </div>
    </div>      
    </div>

    
  </div>

  <div class="mainer">

<div class="button-box">
  <button id="button-2" onclick="openPosts()">Posts</button>
  <button id="button-1" onclick="openAdmins()">Admins</button>
</div>

<div class="main" id="adminsContent">  
  <div class="admins" ></div>  
</div>

<div class="main"  id="posts-content">  
    <div class="center"> <!-- posts to show --></div>
    <div class="posts">
    
    </div>
  </div>


  
</div>
  </div>
</body>


<script>
  var adminsContent=document.getElementById('adminsContent');
      var postsContent=document.getElementById('posts-content');
      
      var btn1=document.getElementById('button-1');
      var btn2=document.getElementById('button-2');

      function openAdmins(){
        adminsContent.style.transform="translateX(0)";
        postsContent.style.transform="translateX(100%)";
        btn1.style.color="#4f45d3";
        btn2.style.color="#000";
        adminsContent.style.transitionDelay="0.3s";
        adminsContent.style.display="block";
        postsContent.style.display="none";
        postsContent.style.transitionDelay="0.3s";
        
      }
      function openPosts(){ 
        adminsContent.style.transform="translateX(100%)";
        postsContent.style.transform="translateX(0)";
        btn2.style.color="#4f45d3";
        btn1.style.color="#000";
        adminsContent.style.transitionDelay="0.3s";
        adminsContent.style.display="none";
        postsContent.style.display="block";
        postsContent.style.transitionDelay="0.3s";
      }
</script>

<script>
  var obj = {
    community_name: "<?php echo $community_name ?>"
  };
</script>


<?php include "./post-1/post1.php"; ?>

<script>
  document.getElementById('edit_community_btn').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('myModal1').innerHTML = `<div class="modal-header">
                                <p id= "edit_community_span" class="close">&times;</p>
                                <p>Edit Community</p>
                              </div>

      <div class="modal-content">
      <h4>Community Image</h4>
            <p>Change Your Img from here!</p>
            <div class="profile_photo">
                <form id="edit_community_img_form" method="POST" enctype="multipart/form-data">
                    <img id="edit_community_img" src="<?php echo $selected_community[0]['community_img']; ?>" alt="">
                    <label for="edit_community_img_file"><img id="edit_edit_community_img" src="Assets/edit_img.png" alt=""></label>
                    <input type="file" hidden id="edit_community_img_file" name="edit_img" accept=".jpg,.png,.ico,.jpeg">
                </form>
            </div>
          
          <p>Change Your community description here</p>
          <textarea name="edit_community_desc" id="edit_community_desc" cols="60" rows="2" placeholder="Write something about your community Here!(Optional)" maxlength="255" ><?php echo $selected_community[0]['description']; ?></textarea>
          <button type="submit" id="edit_submit_community">Save</button>
          <p id="alert_edit_communitiy"></p>
      </div>`;
    document.getElementById('myModal1').style.display = 'block';

    let edit_community_span = document.getElementById('edit_community_span');

    edit_community_span.onclick = function() {
      document.getElementById('myModal1').style.display = "none";
      document.querySelectorAll('input').values = '';
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == document.getElementById('myModal1')) {
        document.getElementById('myModal1').style.display = "none";
      }
    }

    var imgProperty;
    var formData = new FormData(document.getElementById('edit_community_img_form'));

    document.getElementById('edit_community_img_file').addEventListener('change', function() {

      document.getElementById('edit_community_img').src = URL.createObjectURL(this.files[0]);
      document.getElementById('edit_community_img').onload = function() {
        URL.revokeObjectURL(document.getElementById('edit_community_img').src) // free memory
      }
      imgProperty = this.files[0];

      if (imgProperty != null && imgProperty != '') {
        formData.append("edit_img", imgProperty);
      }
    });

    document.getElementById('edit_submit_community').addEventListener('click', function() {

      // let img_name = imgProperty.name;
      // let img_extention = img_name.split('.').pop().toLowerCase();


      formData.append("edit_name", '<?php echo $community_name; ?>');
      formData.append("edit_desc", document.getElementById('edit_community_desc').value);

      let xhr = new XMLHttpRequest();
      xhr.open('POST', 'PhpScripts/create_edit_community_script.php', true);

      xhr.onload = function() {
        let data = this.responseText;



        if (data != 'cannot change' && data != 'Desc change successfully') {
          document.getElementById('alert_edit_communitiy').style.display = 'block';
          document.getElementById('alert_edit_communitiy').innerText = 'Edited successfully!';
          console.log(data);
          setTimeout(() => {
            document.getElementById('community_html_img').src = data;
            document.getElementById('myModal1').style.display = 'none';
            document.getElementById('alert_edit_communitiy').style.display = 'none';
            document.getElementById('nav_' + '<?php echo $community_name; ?>' + '_communities_img').src = data;
          }, 500);
        } else {
          if (data == 'Desc change successfully') {
            document.getElementById('alert_edit_communitiy').style.display = 'block';
            document.getElementById('alert_edit_communitiy').innerText = data;
            setTimeout(() => {
              // document.getElementById('alert_edit_communitiy').innerText = 'Edited successfully!';
              document.getElementById('myModal1').style.display = 'none';
              document.getElementById('alert_edit_communitiy').style.display = 'none';
            }, 500);
          } else {
            document.getElementById('alert_edit_communitiy').innerText = 'Cannot change :(';
          }
        }
        document.getElementById('community_desc').innerText = document.getElementById('edit_community_desc').value;
        document.getElementById('edit_community_desc').value = document.getElementById('edit_community_desc').value;;
      }

      xhr.send(formData);

    });
  });

  let passedArray =
    <?php echo json_encode($user_admin); ?>;

  passedArray.forEach(element => {
    if (element.communities == '<?php echo $community_name; ?>') {
      document.getElementById('edit_community').style.display = 'block';
    }
  });



  function join_button() {
    var join_button_value = document.getElementById("join_button").innerText;

    if (document.getElementById("join_button").innerText == "Join") {
      document.getElementById("join_button").innerText = "Joined";

      let xhr = new XMLHttpRequest();
      let community = '<?php echo $_GET['C']; ?>';
      let followedBy = '<?php echo $_SESSION['username']; ?>';
      let action = "join";

      let params = "username=" + followedBy + "&community=" + community + "&action=" + action;

      xhr.open('POST', './PhpScripts/join_community_script.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {

        // console.log(this.responseText);
        join_button_value.innerText = this.responseText;
        console.log(this.responseText);
      }

      xhr.send(params);
    } else {
      document.getElementById("join_button").innerText = "Join";
      let xhr = new XMLHttpRequest();
      let community = '<?php echo $_GET['C']; ?>';
      let followedBy = '<?php echo $_SESSION['username']; ?>';
      let action = "leave";

      let params = "username=" + followedBy + "&community=" + community + "&action=" + action;

      xhr.open('POST', './PhpScripts/join_community_script.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {

        // console.log(this.responseText);
        join_button_value.innerText = this.responseText;
        console.log(this.responseText);
      }

      xhr.send(params);
    }
  }





</script>


</html>