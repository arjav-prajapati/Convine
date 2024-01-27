<?php
include "./PhpScripts/NavBar.php";
include "./dbh/dbh.php";
$id=$_GET['id'];
if(isset($_GET['c_id'])){

    $c_id=$_GET['c_id'];
}

 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    
    <!-- <link rel="stylesheet" href="Project_Collage/CSS/front_page.css"> -->
    <link rel="stylesheet" href="./CSS/comments_page.css">
    
    
    <title>Document</title>
</head>
<body>

<div class="center">
            </div>
                                    <div class="comments_div">
                                        <div class="add_comment_div">
                                            <!-- <input type="text" name="" id="input_data"> -->
                                            <div class="textarea_container"><textarea id="input_data" name=""  cols="" rows="3" placeholder="Add Your Comment"></textarea>
                                            <button type="submit" onclick="addcomment_function()">Add Comment</button></div>
                                            <div class="error_msg"></div>
                                            <div class="comments_data_main_div">
                                                
                                        </div>
                                    </div>
                                </div>
</body>
<script>
    
    var obj= { id : "<?php echo $id ?>" , c_id: <?php if(isset($c_id)){echo $c_id;} else {echo 0;} ?>};
    
</script>

<?php include "./post-1/post1.php";?>
</html>