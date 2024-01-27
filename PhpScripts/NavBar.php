<?php
session_start();
include './dbh/dbh.php';

if(!isset($_SESSION['username'])){
  header('Location:login_page.php');
}
else{

  $username = $_SESSION['username'];


  $sql2 = "SELECT profile_img FROM `convine_dbs`.`users` WHERE username='$username';";
  $result2 = mysqli_query($conn, $sql2);
  if (mysqli_num_rows($result2) > 0) {
    $datas2 = array();
    while ($row2 = mysqli_fetch_assoc($result2)) {
      $datas2[] = $row2['profile_img'];
    }
    $profile_img_src = $datas2[0];
  }

  $sql3 = "SELECT * FROM `convine_dbs`.`users` WHERE username='$username';";
  $result3 = mysqli_query($conn, $sql3);

  if (mysqli_num_rows($result3) > 0) {

    $session_user = mysqli_fetch_assoc($result3);
  }

  $sql4 = "SELECT communities,community_img FROM `convine_dbs`.`communities_table`";
  $datas4 = array();
  $result4 = mysqli_query($conn, $sql4);
  if (mysqli_num_rows($result4) > 0) {
    while ($row4 = mysqli_fetch_assoc($result4)) {
      $datas4[] = $row4;
    }
  }

  $sql5 = "SELECT username,profile_img FROM `convine_dbs`.`users`;";
  $datas5 = array();
  $result5 = mysqli_query($conn, $sql5);
  if (mysqli_num_rows($result5) > 0) {
    while ($row5 = mysqli_fetch_assoc($result5)) {
      $datas5[] = $row5;
    }
  }


  $sql = "SELECT A.*, B.* FROM `convine_dbs`.`communities_table` AS A INNER JOIN `convine_dbs`.`joined_users` AS B ON A.communities = B.communities WHERE joined_users = '$username';";
  $result = mysqli_query($conn, $sql);
  $datas = array();

  $i = 0;
  $joined_communities = "";

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

      $datas[] = $row;
    }

    while ($i < sizeof($datas)) {
      $joined_communities .= "<a href='./community_page.php?C={$datas[$i]['communities']}'> <div><img id='nav_{$datas[$i]['communities']}_communities_img' src='{$datas[$i]['community_img']}' alt='n'>  {$datas[$i]['communities']}  </div></a>";
      $i++;
    }
  }
}
?>


<nav>
  <div class="left_div_of_navbar">
    <div class="logo_container">
      <a href="front_page.php">
        <img src="./Assets/convine.png" alt="" />
      </a>
    </div>


    <label class="home_btn_container" for="joined_communities_checkbox">
      <input class="checkbox" type="checkbox" name="joined_communities_checkbox" id="joined_communities_checkbox">
      <div id="left" for="joined_communities_checkbox">
        <div class="create_community" id="create_community">Create Community
        </div>

        <div class="joined_community_hardcoded">Joined Communites</div>
        <div class="joined_community" id="joined_communities">
          <?php
          echo $joined_communities;
          ?>
        </div>
      </div>
      <div class="home_btn">
        <img src="Assets/home.png" alt="" />
      </div>
      <i class="arrow down"></i>
    </label>

    <div class="home_drop_down">
    </div>

  </div>
  <div class="center_div_of_navbar">
    <div class="searchbar">
      <input type="text" name="" id="search" placeholder="Search Here" />
    </div>

  </div>



  <div class="right_div_of_navbar">
    <div class="settings_container">
      <a href="./settings.php" title="settings">
        <img src="./Assets/settings.png" alt="settings" title="settings" />
      </a>
    </div>

    <div class="all_container">
      <a href="all_community.php">
        <img src="./Assets/all.png" alt="" />
      </a>
    </div>

    <div class="chat_container">
      <a href="./chat_system.php">
        <img src="./Assets/chat.png" alt="" />
      </a>
    </div>

    <div class="plus_container">
      <a href="./add_post.php">
        <img src="./Assets/plus.png" alt="" />
      </a>
    </div>


    <div class="profile_username_container">

      <div class="profile">
        <?php
        echo "<a href='./profile_page.php?u=$username'>";

        echo "<img id='nav_profile_img' src='$profile_img_src' alt=''  />";


        echo "</a>";
        ?>
      </div>

      <div class="navusername">

        <?php
        echo "<a href='./profile_page.php?u=$username'>";
        echo $_SESSION['username'];
        echo "</a>";
        ?>
      </div>

    </div>
  </div>
  <div class="hamburger" id="hamburger">
    <img src="Assets/Hamburger_icon.png" alt="n">
  </div>
</nav>

<div class="search_table" id="search_table">
  <div class="select_search" role="tablist" aria-label="Sample Tabs">
    <a class="nav_search" aria-selected="true" aria-controls="panel-communities" id="tab-1" tabindex="0">Community</a>
    <a class="nav_search" aria-selected="false" aria-controls="panel-users" id="tab-2" tabindex="-1">Users</a>
    <!-- <a role="tab" aria-selected="false" aria-controls="panel-4" id="tab-4" tabindex="-1">Chat & Messaging</a> -->
  </div>
  <div id="search_result" class="search_result">
    <div role="panel" id="panel-communities">
      <div id="search_communities" class="search_communities">
        this1
      </div>
    </div>

    <div role="panel" id="panel-users" hidden>
      <div class="search_users">
        this
      </div>

    </div>
  </div>
</div>


<div class="hamburger_menu" id="hamburger_menu">
  <div class="span_close"><span id="close_hamburger">&times;</span></div>
  <div class="hamburger_profile">
    <div class="profile_username_img"><a href="profile_page.php?u=<?php echo $session_user['username']; ?>"><img src="<?php echo $session_user['profile_img']; ?>" alt=""></a>
    </div>
    <div class="profile_username_text"><a href="profile_page.php?u=<?php echo $session_user['username']; ?>"><?php echo $session_user['username']; ?></a></div>
  </div>

  <div class="icon_lists">
    <a href="front_page.php">
      <div><img src="Assets/Home.png" alt=""></div>Home
    </a>
    <a href="add_post.php">
      <div><img src="Assets/plus.png" alt=""></div>Create Post
    </a>
    <a href="all_community.php">
      <div><img src="Assets/all.png" alt=""></div>Home
    </a>
    <a href="chat_system.php">
      <div><img src="Assets/chat.png" alt=""></div>Chat
    </a>
    <a id="create_community_hamburger">
      <div><img src="Assets/create_community.png" alt=""></div>Create Commnunity
    </a>
    <a href="settings.php">
      <div><img src="Assets/settings.png" alt=""></div>Settings
    </a>


    <div class="hamburger_joined_communities">
      <?php echo $joined_communities; ?>
    </div>
  </div>
</div>


<!--box for change email-->
<div id="myModal1" class="modal">

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

</div>


<style>
  img {
    user-select: none;
  }

  a {
    color: black;
  }

  nav {
    display: flex;
    height: 50px;
    overflow: hidden;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    width: 100%;
    background-color: #ffffff;
    margin: auto;
    z-index: 20;
  }

  nav>div {
    margin: 10px;
  }

  .logo_container,
  .home_btn,
  .all_container,
  .settings_container,
  .chat_container,
  .plus_container {
    height: 30px;
    width: auto;
    margin: 10px;
  }

  .profile {
    height: 30px;
    width: 30px;
    margin-right: 5px;
  }

  .home_btn_container,
  .profile_username_container {
    padding: 2px 20px 2px 2px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 30px;
    cursor: pointer;
    border: 1px solid rgb(199, 199, 199);
    border-radius: 3px;
  }

  .profile>a>img {

    border-radius: 100%;
  }

  .settings_container>a>img,
  .logo_container>a>img,
  .all_container>a>img,
  .chat_container>a>img,
  .plus_container>a>img,
  .profile>a>img {
    height: 100%;
    width: 100%;
  }

  .home_btn>img {
    height: 30px;
    width: 30px;
  }


  .right_div_of_navbar,
  .left_div_of_navbar,
  .center_div_of_navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
  }

  .searchbar {
    height: fit-content;
  }

  .searchbar>input {
    width: 50vw;
    height: 40px;
    padding-left: 20px;
    border-radius: 3px;
    background-color: #F6F7F8;
    outline: none;
    font-size: 18px;
    border: none;
    border: 1px solid rgb(226, 226, 226);
    background-color: white;
  }

  .searchbar input:hover {
    background-color: white;
    border: 1px solid #4f45d3;
    /* border-radius: 2px; */
  }

  .search_submit_btn {
    border-radius: 0px 20px 20px 0px;
    border-top: 2px solid #d3d3d3;
    border-left: 0px solid #d3d3d3;
    border-bottom: 2px solid #d3d3d3;
    border-right: 2px solid #d3d3d3;
    padding-right: 5px;

  }

  .search_submit_btn img {
    height: 28px;
    width: 30px;

  }

  .select_search {
    display: flex;
    width: 100%;
    justify-content: space-between;
    height: 30px;
    /* align-items: center; */
  }

  .select_search>a {
    display: flex;
    width: 100%;
    margin: auto;
    /* border-bottom: 1px solid black; */
    /* text-align: center; */
    align-items: center;
    height: 100%;
    justify-content: center;
  }

  /* .select_search>a:hover{
    border-bottom: 1px solid #4f45d3;
  } */

  .search_table {
    display: none;
    z-index: 2;
    width: 50vw;
    top: 55px;
    position: fixed;
    border: 1px solid rgb(226, 226, 226);
    background-color: white;
    border-radius: 3px;
    left: 50%;
    transform: translate(-49%, 0);
    margin-right: 5px;
  }

  .search_result {
    width: 100%;
  }

  .search_communities,
  .search_users {
    width: 100%;
    margin: 10px 20px;
    align-items: center;
    height: fit-content;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
  }

  .search_communities>a,
  .search_users>a {
    display: flex;
    flex-direction: row;
    align-items: center;
    text-decoration: none;
  }

  .search_communities>a>img,
  .search_users>a>img {
    display: flex;
    width: 30px;
    height: 30px;
    margin: 5px 5px 0 0;
    border-radius: 100%;
  }

  .hamburger {
    /* display: flex; */
    display: none;
    height: 40px;
    width: 40px;
    /* z-index: 2; */
  }

  .span_close {
    width: 100%;
    height: fit-content;
    background-color: rgb(226, 226, 226);
    font-size: 30px;
  }

  #close_hamburger {
    position: absolute;
    right: 20px;
    top: 5px;
    cursor: pointer;
    border-radius: 50%;
    margin: 2px;
    font-weight: bolder;
  }


  .hamburger>img {

    height: 30px;
    width: 30px;
    cursor: pointer;
    margin: auto;
    justify-content: center;
  }

  .hamburger_menu {
    width: 40vw;
    height: 100%;
    overflow: auto;
    position: fixed;
    right: 5px;
    top: 5px;
    left: 100%;
    background-color: rgb(250, 245, 245);
    /* border: 2px solid black; */
    transition: 0.3s ease-in-out;
    z-index: 100;
  }

  .icon_lists {
    width: 100%;


  }

  .icon_lists>a {
    list-style-type: none;
    align-items: center;
    height: 40px;
    display: flex;
    font-size: 18px;
    padding: 5px;
  }

  .icon_lists>a>div {
    width: 35px;
    height: 35px;
    margin: auto 5px;
    align-items: center;
    /* border: 2px solid black;  */
    cursor: pointer;
  }

  .icon_lists>a>div>img {
    width: 30px;
    height: 30px;
    background-color: white;
    border-radius: 50%;
    margin: auto;
    align-items: center;
  }

  .hamburger_joined_communities {
    border-top: 2px solid gray;
    width: 100%;
    margin: auto;
    margin-top: 5px;
    padding-top: 10px;
    overflow: auto;
    font-family: 'Roboto Slab', serif;
    height: fit-content;
  }



  .hamburger_joined_communities>a>div {
    height: fit-content;
    align-items: center;
    width: auto;
    margin: 7px;
    text-align: left;
    font-size: 18px;
    display: flex;
    padding: 5px;
  }

  .hamburger_joined_communities>a>div>img {
    width: 35px;
    height: 35px;
    border-radius: 100%;
    margin-right: 10px;
  }

  .hamburger_profile {
    height: 50px;
    display: flex;
    font-size: 26px;
    align-items: center;
    padding: 0px 10px;
    background-color: rgb(125, 249, 255);
  }

  .profile_username_img {
    width: 35px;
    height: 35px;
  }

  .profile_username_text {
    display: inline;
    width: fit-content;
    margin-left: 10px;
  }

  .profile_username_img>a>img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
  }

  .hamburger_profile>a {
    align-items: center;
    margin: auto 0;
  }

  #left {

    height: fit-content;
    overflow-y: auto;
    width: 20%;
    display: none;
  }

  #joined_communities_checkbox:checked~#left {
    position: absolute;
    display: block;
    background-color: rgb(255, 255, 255);
    border-radius: 5px;
    top: 50px;
  }


  .create_community {
    height: fit-content;
    align-items: center;
    width: auto;
    margin: 10px;
    padding: 10px 15px;
    text-align: center;
    font-size: 25px;
    margin-bottom: 20px;
    border-radius: 10px;
    background-color: rgb(247, 247, 247);
  }

  .create_community>button {
    background-color: inherit;
    border: none;
    color: rgb(255, 115, 0);
    font-size: 24px;
    cursor: pointer;
    width: 100%;
    height: 100%;
    z-index: 1;
  }

  .create_community:hover {
    background-color: rgb(239 228 228);
  }

  .joined_community_hardcoded {
    height: fit-content;
    align-items: center;
    width: 100%;
    margin: auto;
    padding: 10px 15px;
    text-align: center;
    font-size: 30px;
    margin-bottom: 20px;
    border-radius: 10px;
    background-color: rgb(196 121 238);
    position: absolute;
    top: 40px;
    display: none;
  }

  .joined_community {
    font-family: 'Roboto Slab', serif;

  }

  .joined_community>a>div {
    height: fit-content;
    align-items: center;
    width: auto;
    margin: 7px;
    padding: 10px 25px;
    text-align: left;
    font-size: 25px;
    display: flex;
  }

  .joined_community>a>div>img {
    width: 35px;
    height: 35px;
    border-radius: 100%;
    margin-right: 10px;
  }

  a {
    text-decoration: none;
  }

  a:visited {
    color: black;
  }

  .joined_community>a>div:hover {
    background-color: rgb(241, 241, 241);
    border-radius: 10px;
  }

  .arrow {
    border: solid black;
    border-width: 0 3px 3px 0;
    display: inline-block;
    padding: 3px;
    margin-left: 60px;
  }

  .down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
  }

  .checkbox {
    visibility: hidden;
    display: none;
  }

  #left {

    height: fit-content;
    overflow-y: auto;
    width: 20%;
    display: none;
  }



  #joined_communities_checkbox:checked~#left {
    position: fixed;
    display: block;
    background-color: rgb(255, 255, 255);
    border-radius: 5px;
    top: 50px;
    z-index: 30000000000;
  }


  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 2;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */ 
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
    backdrop-filter: blur(5px);
   
  }

  .modal_parent{
    border-radius: 10px;
  }
  /* Modal Content */
  .modal-header {
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    height: fit-content;
    background-color:   #4963fa;
  }

  .modal-header>p {
    font-weight: bold;
    font-size: 22px;
  }

  .modal-content {
    padding: 20px;
    width: 30%;
    height: fit-content;
    background-color: #fefefe;
    margin: auto;
    display: block;
  }

  .modal-content>p {
    font-size: 16px;
    margin: 1px 0px;
    color: #7c7c7c;
  }

  /* The Close Button */
  .close {
    position: relative;
    width: fit-content;
    margin: auto;
    float: right;
    color: #000;
    font-size: 28px;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  #send-otp,
  #new_password_btn,
  #submit_otp,
  #submit_community,
  #edit_submit_community {
    width: 40%;
    margin: auto;
    height: 40px;
    color: white;
    background-color: #4caf50;
    outline: none;
    border: none;
    cursor: pointer;
    align-items: center;
  }

  #alert_email,
  #alert_pass,
  #alert_otp,
  #alert_create_communitiy,
  #alert_edit_communitiy {
    width: fit-content;
    overflow: hidden;
    padding: 10px;
    background-color: #cff9b6;
    color: black;
    margin: 5px 0;
    display: none;
  }

  .block_user_div>input,
  #create_community_name,
  #create_community_desc,
  input[type=email],
  input[type=password],
  input[type=number],
  textarea {
    padding: 10px;
    font-size: 15px;
    margin: 10px 0px;
    width: 100%;
    position: relative;
    resize: vertical;
  }

  #community_img {
    width: 125px;
    height: 125px;
    margin: 10px;
    display: block;
    border-radius: 100%;
  }

  #edit_community_img {
    width: 125px;
    height: 125px;
    margin: 10px;
    display: block;
    border-radius: 100%;
  }

  .profile_photo {
    width: fit-content;
    margin: auto;
    position: relative;
  }

  #edit_community_img_1,
  #edit_edit_community_img {
    position: absolute;
    width: 20px;
    height: 20px;
    bottom: 15px;
    right: 5px;
    margin: 0;
    background-color: inherit;
    border-radius: 100%;
    cursor: pointer;
  }

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  @media only screen and (max-width: 1200px) {

    .left_div_of_navbar,
    .right_div_of_navbar {
      display: none;
    }

    .hamburger {
      display: block;
    }

    .center_div_of_navbar,
    .searchbar {
      width: 100%;
      justify-content: left;
    }

    .searchbar>input {
      width: 100%;
    }

    .search_table {
      width: 90%;
      left: 45%;
    }

    .hamburger_menu {
      width: 50%;
    }

    .modal-header,
    .modal-content {
      width: 50%;
    }
  }

  @media screen and (max-width:500px){
    .modal-header,
    .modal-content {
      width: 80%;
    }
  }
</style>


<script>
  window.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.nav_search');


    // Add a click event handler to each tab
    tabs.forEach(tab => {
      tab.addEventListener('click', changeTabs_nav);
      if (tab.getAttribute('aria-selected') == 'true') {
        // tab.style.color = 'black';
        tab.style.borderBottom = '2px solid #4f45d3';
      }
    });
  });

  function changeTabs_nav(e) {

    const target = e.target;
    const parent = target.parentNode;
    // const grandparent = parent.parentNode;
    // console.log(target);
    // console.log(parent);


    // Remove all current selected tabs
    parent
      .querySelectorAll('[aria-selected="true"]').forEach(element => {
        element.setAttribute('aria-selected', false);
        element.style.color = '#7c7c7c';
        element.style.borderBottom = 'none';
      });

    // // Set this tab as selected
    target.setAttribute('aria-selected', true);

    // // Hide all tab panels
    document.getElementById('search_result')
      .querySelectorAll('[role="panel"]');
    document.getElementById('search_result')
      .querySelectorAll('[role="panel"]')
      .forEach(p => p.setAttribute('hidden', true));

    // Show the selected panel
    document.getElementById('search_result')
      .querySelector(`#${target.getAttribute('aria-controls')}`)
      .removeAttribute('hidden');



    // let tabi = target.getAttribute('tabindex');

    if (target.getAttribute('aria-selected') == 'true') {
      target.style.color = 'black';
      target.style.borderBottom = '2px solid #4f45d3';
    }


  }


  let searched_communities = [<?php echo json_encode($datas4) ?>];
  let searched_users = [<?php echo json_encode($datas5) ?>];

  document.getElementById('search').addEventListener('input', function() {


    document.getElementById('search_table').style.display = 'block';
    let search_val = document.getElementById('search').value;
    search_val = search_val.toLocaleLowerCase();
    // console.log(search_val);


    if (search_val == null || search_val == '') {
      document.getElementById('search_table').style.display = 'none';
    } else {
      let data_communities = '';
      searched_communities.forEach(element => {
        element.forEach(e => {
          if (e.communities.includes(search_val)) {
            data_communities += `<div class="search_communities">
            <a href='community_page.php?C=` + e.communities + `'">
              <img src="` + e.community_img + `" alt="">
              ` + e.communities + `
            </a>
          </div>`;
          }
        })
      });
      document.getElementById('panel-communities').innerHTML = data_communities;

      let data_users = '';
      searched_users.forEach(element => {
        element.forEach(e => {
          if (e.username.includes(search_val)) {
            data_users += `<div class="search_users">
            <a href='profile_page.php?u=` + e.username + `'">
              <img src="` + e.profile_img + `" alt="">
              ` + e.username + `
            </a>
          </div>`;
          }
        })
      });
      document.getElementById('panel-users').innerHTML = data_users;
    }

  });



  document.getElementById('create_community_hamburger').addEventListener('click', create_community_func);
  document.getElementById('create_community').addEventListener('click', create_community_func);

  function create_community_func(e) {
    document.getElementById('hamburger_menu').style.display = 'none';
    e.preventDefault();
    document.getElementById('myModal1').innerHTML = `<div class = "modal_parent"><div class="modal-header">
                                <p id= "create_community_span" class="close">&times;</p>
                                <p>Create Community</p>
                              </div>

      <div class="modal-content">
      <h4>Community Image</h4>
            <p>Images must be in .png or .jpg format</p>
            <div class="profile_photo">
                <form id="community_img_form" method="POST" enctype="multipart/form-data">
                    <img id="community_img" src="Assets/all.png" alt="">
                    <label for="community_img_file"><img id="edit_community_img_1" src="Assets/edit_img.png" alt=""></label>
                    <input type="file" hidden id="community_img_file" name="myfile" accept=".jpg,.png,.ico,.jpeg">
                </form>
            </div>
          NOTE: <p>Make sure to write your community name perfect , You can't change it later.</p>
          <input type="text" name="community_name" id="create_community_name" placeholder="Write Your Community Name here!!" required>
          <p>About Your Community:</p>
          <input type="text" name="community_desc" id="create_community_desc" placeholder="Write something about your community Here!(Optional)" maxlength="255">
          <button type="submit" id="submit_community">Create Community</button>
          <p id="alert_create_communitiy"></p>
      </div>
      </div>`;
    document.getElementById('myModal1').style.display = 'block';

    let create_community_span = document.getElementById('create_community_span');

    create_community_span.onclick = function() {
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
    document.getElementById('community_img_file').addEventListener('input', function() {

      document.getElementById('community_img').src = URL.createObjectURL(this.files[0]);
      document.getElementById('community_img').onload = function() {
        URL.revokeObjectURL(document.getElementById('community_img').src) // free memory
      }
      imgProperty = this.files[0];
    });
    console.log();
    document.getElementById('submit_community').addEventListener('click', function() {
      let community_name = document.getElementById('create_community_name').value

      if (community_name != null && community_name != '') {
        // let img_name = imgProperty.name;
        // let img_extention = img_name.split('.').pop().toLowerCase();

        let formData = new FormData(document.getElementById('community_img_form'));

        formData.append("myfile", imgProperty);
        formData.append("community_name", document.getElementById('create_community_name').value.toLocaleLowerCase());
        formData.append("community_desc", document.getElementById('create_community_desc').value);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'PhpScripts/create_edit_community_script.php', true);

        xhr.onload = function() {
          let data = this.responseText;
          document.getElementById('alert_create_communitiy').style.display = 'block';
          document.getElementById('alert_create_communitiy').innerText = data;
          console.log(data);

          if (data == 'Community created successfully!') {
            setTimeout(() => {
              document.getElementById('myModal1').style.display = 'none';
              document.getElementById('alert_create_communitiy').style.display = 'none';
            }, 1000);
          }
          document.getElementById('create_community_name').value = '';
          document.getElementById('create_community_desc').value = '';
        }

        xhr.send(formData);
      } else {
        document.getElementById('alert_create_communitiy').style.display = 'block';
        document.getElementById('alert_create_communitiy').innerText = 'Community Name cannot be Null!';
      }
    });
  };

  document.getElementById('hamburger').onclick = function() {
    document.getElementById('hamburger_menu').style.left = ' 50%';
  }

  document.getElementById('close_hamburger').onclick = function() {
    document.getElementById('hamburger_menu').style.left = '100%';
  }
</script>


<!-- let add_community_to_nav  = document.createElement('a');
            add_community_to_nav.setAttribute('href','./community_page.php?C='+ document.getElementById('create_community_name').value.toLocaleLowerCase());
            add_community_to_nav.innerHTML = `<div><img id='nav_` + document.getElementById('create_community_name').value.toLocaleLowerCase() + `_communities_img' src='`+ URL.createObjectURL(this.files[0]) + `' alt='n'>  ` + document.getElementById('create_community_name').value.toLocaleLowerCase() + `</div>`;
            document.getElementById('joined_communities').appendChild(add_community_to_nav); -->