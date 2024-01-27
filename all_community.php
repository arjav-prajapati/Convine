<?php
include "./PhpScripts/NavBar.php";
include "./PhpScripts/community_admins_script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <link rel="stylesheet" href="CSS/all_community.css" />
    <title>Document</title>
</head>
<body>
<div class="main">
        <div class="all_communities_posts">All posts from all Communities</div>
      <div class="center">

      <div class="posts">
    
    </div>
      </div>
      
</div>
</body>
<script> 
  var obj = {
    all_community: "all_communities"
  };
</script>


<?php include "./post-1/post1.php"; ?>

  
</html>
 
