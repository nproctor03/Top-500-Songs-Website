<?php

//establish db connection

include('includes/dbconn.php');

//grab values from $_POST and perform basic security using htmlentities();
$reviewid = $_GET['id'];
//echo($reviewid);
$stmt = $dbconn->prepare("UPDATE `user_reviews` SET `admin_approved` = '1' WHERE `user_reviews`.`review_id` = ?; ");
$stmt->bind_param("i", $reviewid);
$stmt->execute();

if (!$stmt) {
    echo $dbconn->error;
    echo "<p> Something went wrong </p>";
} else {
    echo ("Success");
    header("Location: useraccount.php");
}
