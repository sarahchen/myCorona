<?php
    session_start();
    include('connect.php');

    if(($_SESSION['logged-in']) == false) {
        header('Location: explore.php');
    }

    $username = $_SESSION['login_user'];
    $store_id = $_GET['id'];

// ADD USER TO STORE FOLLOWERS
    // Get Currect Store Followers
    $qStore1 = 'select followers from stores where id="'.$store_id.'";';
    $submitStore1 = mysqli_query($qStore1);
    $factsStore1 = mysqli_fetch_object($submitStore1);

    $followers = $factsStore1->followers;
    // Add New Follower
    $new_followers = $followers . ',' . $username;
    $qStore2 = 'update stores set followers="'.$new_followers.'" where id="'.$store_id.'";';
    $submitStore2 = mysqli_query($qStore2);

    if(!$submitStore2) {
        echo 'ERROR. Could Not Add Followers';
    }

// ADD STORE TO USER LIKES
    // Get Current User Likes
    $qUser1 = 'select likes from users where username="'.$username.'";';
    $submitUser1 = mysqli_query($qUser1);
    $factsUser1 = mysqli_fetch_object($submitUser1);

    $likes = $factsUser1->likes;
    // Add New Like
    $new_likes = $likes . ',' . $store_id;
    $qUser2 = 'update users set likes="'.$new_likes.'" where username="'.$username.'";';
    $submitUser2 = mysqli_query($qUser2);

    if(!$submitUser2) {
        echo 'ERROR. Could Not Add Likes';
    }

    header('Location: store.php');



?>