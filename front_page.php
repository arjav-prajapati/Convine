<?php
include "./PhpScripts/NavBar.php";
include "./PhpScripts/community_admins_script.php";

date_default_timezone_set('Asia/Kolkata');

$sql_blocked_users = "SELECT * FROM `convine_dbs`.`blocked_users` WHERE blocked_by = '{$session_user['username']}'";

$result_blocked_users =  mysqli_query($conn, $sql_blocked_users);
if ($result_blocked_users) {
    $datas_blocked_users = array();
    while ($row_blocked_users = mysqli_fetch_assoc($result_blocked_users)) {
      $datas_blocked_users[] = $row_blocked_users['username'];
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <div class="post93"></div>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
  <link rel="stylesheet" href="CSS/front_page.css" />

  <script src="./JavaScripts/timeAgo.js"></script>
  <!-- Tranition -->
  <?php include "./PhpScripts/transition.php"; ?>

  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&family=Montserrat:wght@300;700;900&family=Poppins&family=Roboto+Slab:wght@400&family=Sacramento&family=Ubuntu&display=swap" rel="stylesheet" />
  <title>Document</title>
</head>

<body>


  <div class="main">
    <!-- <div class="left_ghost"></div> -->

    <div class="center">




    </div>
  </div>

  <!-- <div class="right_ghost"></div> -->

  <!-- <div class="right"> -->
  <!-- <div class="send_message_btn"> -->
  <!-- <button>Send Message</button> -->
  <!-- </div> -->
  <!-- <div class="send_message_to_users"> -->
  <!-- <div><img src="Assets/cristiano.jpg" alt="" /> Cristiano</div>
          <div><img src="Assets/omen.png" alt="" /> Omen</div>
          <div><img src="Assets/tony.jpg" alt="" /> Tony Stark</div>
          <div><img src="Assets/tenz.png" alt="" /> Tyson</div> -->
  <!-- </div> -->
  <!-- </div> -->

  </div>

</body>
<script>
 
  let blocked_users = <?php echo json_encode($datas_blocked_users); ?>;
  obj={};
</script>


<?php include "./post-1/post1.php";?>

<!-- <script type="text/javascript">
        function zoom() {
            document.body.style.zoom = "100%" 
        }
</script>

<body onload="zoom()"> -->
</html>