<?php
 include "./PhpScripts/NavBar.php";
 include './dbh/dbh.php';
$useername=$_SESSION['username'];
$sql="SELECT communities from `convine_dbs`.`joined_users` WHERE joined_users='$username'";
$result=mysqli_query($conn,$sql); 
if(mysqli_num_rows($result)>0){
    $datas=array();    
    while($row = mysqli_fetch_assoc($result)){
        $datas[]=$row['communities']; 
    }

    $i=0;
    $select_communities="";
    while($i<sizeof($datas)){
        // $select_communities .= "<div><img src='C/$datas[$i]/Community_Profile_picture/$datas[$i].jpg' alt='n'>  $datas[$i]  </div>";
        $select_communities .="<option value='$datas[$i]'>$datas[$i]</option>";
        $i++;
    }
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0" />
    <link rel="stylesheet" href="./CSS/add_post.css">
    <title>Document</title>
</head>
<body>
    <div class="main_add_post">
        <div>
        <div class="joined_community">
            </div>
           
       
        </div>
        <form action="PhpScripts/add_post_script.php" method="POST" enctype="multipart/form-data">
            <label for="cars">Choose a community:</label>
                 <select name="community_name" id="community_name">
                 <option value="none" selected disabled hidden >Select Community</option>
                <?php
                 echo $select_communities;
                ?>
             
                 </select>

            <div><input type="text" class="title" name="title" id="" placeholder="Title" value="<?php 
                if(isset($_SESSION['title'])){
                echo $_SESSION['title'];
                $_SESSION['title']="";
                } ?>"></div>
            <div><textarea rows="5" type="text" class="desc" name="desc" id="" placeholder="Add Description(optional)"><?php if(isset($_SESSION['title'])){
                echo $_SESSION['desc'];
                $_SESSION['desc']="";
            } ?></textarea> </div>
            <div class="error_msg">  
                <?php
                if(isset($_GET['error'])){

                    if($_GET['error']=="empty_title"){
                        echo "Please Enter a title";
                    }
                    else if($_GET['error']=="no_community_selected"){
                        echo "Please Select a community";
                    }
                    else if($_GET['error']=="invalid_file_type"){
                        echo "Invalid file type";
                    }
                    else if($_GET['error']=="big_file_size"){
                        echo "Your File is too Big!";
                    }
                    
                }
                    ?>
            </div>
                  
            <div class="div_img_label">
                <img  id="profileDisplay" alt="" onclick="triggerClick()" style="display:none">
                <label for="img" class="img_label" id="label_invisible()" onclick="img_visible()">Upload an image</label>  
                <input type="file" class="img" name="img" accept="image/*" id="img" onchange="displayImage(this)">
        </div>
           <div class="div_post_submit">

               <button type="submit" name="submit_button" class="submit_button" >Post</button>
           </div> 
        </form>
    </div>
</body>
<script>
    function img_visible(){
        document.getElementById('profileDisplay').style="display:block";
    }
    function triggerClick(){
        document.querySelector('#img').click();
    }  
    function displayImage(e){
        
        if(e.files[0]){
            var reader= new FileReader();
            reader.onload= function(e){
                document.querySelector('#profileDisplay').setAttribute('src',e.target.result);
                document.getElementById('label_invisible()').style="display:none";
         
            }
         reader.readAsDataURL(e.files[0]);
     }
 }
    </script>
</html>