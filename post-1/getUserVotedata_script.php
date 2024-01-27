<?php
session_start();
include "../dbh/dbh.php"; 
if(isset($_POST['post_sno'])){
    $sql_voted_post = "SELECT * FROM `convine_dbs`.`post_votes` WHERE post_id = '{$_POST['post_sno']}' AND by_ = '{$_SESSION['username']}'";
    $voted_post =  mysqli_query($conn, $sql_voted_post);
    if ($voted_post) {
        $datas_voted_post = array();
        while ($row_voted_post = mysqli_fetch_assoc($voted_post)) {
        $datas_voted_post[] = $row_voted_post;
        }
    }


    if($datas_voted_post == null || $datas_voted_post == ''){
        echo 'nothing';
        exit();
    }else if($datas_voted_post[0]['upvote'] == 1){
        echo 'upvote';
    }else if($datas_voted_post[0]['downvote'] == 1){
        echo 'downvote';
    }

}