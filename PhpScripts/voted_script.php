<?php 

include "../dbh/dbh.php";

$voted_by= $_POST['username'];
$post_id=$_POST['post_id'];

    if(isset($_POST['upvote'])){
        
        $sql="SELECT * FROM `convine_dbs`.`post_votes` WHERE ( post_id='$post_id' AND by_='$voted_by' );";
        $result=mysqli_query($conn,$sql) or die("Failed to query database" .mysqli_error($conn));
        $fetch=mysqli_fetch_assoc($result);
 
        if(mysqli_num_rows($result)==1){

        if ($fetch['upvote']==1) {

            $sql4="DELETE fROM `convine_dbs`.`post_votes`  WHERE ( post_id='$post_id' AND by_='$voted_by' );";
            mysqli_query($conn,$sql4) or die("Failed to query database" .mysqli_error($conn));
            
        }
        else if($fetch['downvote']==1){
            
            $sql4="UPDATE `convine_dbs`.`post_votes` SET `upvote` = '1', `downvote` = '0' WHERE `post_votes`.`post_id` = '$post_id' AND by_='$voted_by'";
            mysqli_query($conn,$sql4) or die("Failed to query database" .mysqli_error($conn));
        }


    }
        else{
            $sq13="INSERT INTO `convine_dbs`.`post_votes`(post_id,upvote,downvote,by_) VALUES('$post_id',TRUE,False,'$voted_by');";
            mysqli_query($conn,$sq13) or die (mysqli_error($conn)) ;

        }
    }
    if(isset($_POST['downvote'])){
        $sql="SELECT * FROM `convine_dbs`.`post_votes` WHERE ( post_id='$post_id' AND by_='$voted_by');";
        $result=mysqli_query($conn,$sql) or die("Failed to query database" .mysqli_error($conn));
        $fetch=mysqli_fetch_assoc($result);
 
        if(mysqli_num_rows($result)==1){

            
        if ($fetch['downvote']==1) {

            $sql4="DELETE FROM `convine_dbs`.`post_votes`  WHERE ( post_id='$post_id' AND by_='$voted_by' );";
            mysqli_query($conn,$sql4) or die("Failed to query database" .mysqli_error($conn));
            
        }
        else if($fetch['upvote']==1){
            
                $sql4="UPDATE `convine_dbs`.`post_votes` SET `upvote` = '0', `downvote` = '1' WHERE `post_votes`.`post_id` = '$post_id' AND by_='$voted_by'";
                mysqli_query($conn,$sql4);

        }
    } 

        else{
                $sq13="INSERT INTO `convine_dbs`.`post_votes`(post_id,upvote,downvote,by_) VALUES('$post_id',False,TRUE,'$voted_by');";
                mysqli_query($conn,$sq13) or die (mysqli_error($conn)) ;
                
            }
            
    }



    $sql_upvote_count="SELECT * FROM `convine_dbs`.`post_votes` WHERE ( post_id='$post_id' AND upvote=1 );";
    $sql_downvote_count="SELECT * FROM `convine_dbs`.`post_votes` WHERE ( post_id='$post_id' AND downvote=1 );";
    
    $result_upvote_count=mysqli_query($conn,$sql_upvote_count) or die("Failed to query database" .mysqli_error($conn));
    $result_downvote_count=mysqli_query($conn,$sql_downvote_count) or die("Failed to query database" .mysqli_error($conn));

    $upvotes=mysqli_num_rows($result_upvote_count);
    $downvotes=mysqli_num_rows($result_downvote_count);

    $vote=$upvotes-$downvotes;


    $sql_insert_vote="UPDATE `convine_dbs`.`posts` SET `votes` = '$vote' WHERE `posts`.`sno` = '$post_id';";
    mysqli_query($conn,$sql_insert_vote);
    
    $sql_get_vote_count="SELECT * FROM `convine_dbs`.`posts` WHERE sno='$post_id' ;";
    $result_vote_count=mysqli_query($conn,$sql_get_vote_count);
    $fetched_vote_count=mysqli_fetch_assoc($result_vote_count);
    // print_r($fetched_vote_count);
    echo $fetched_vote_count['votes'];
 