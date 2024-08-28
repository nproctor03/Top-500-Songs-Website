<?php

include('includes/dbconn.php');
$reviewid = $dbconn->real_escape_string($_GET['id']);

$stmt = $dbconn->prepare("DELETE FROM `user_reviews` WHERE `user_reviews`.`review_id` = ?");
$stmt->bind_param("i", $reviewid);
$stmt->execute();


if (!$stmt) {
    echo $dbconn->error;
    echo "<p> Something went wrong </p>";
} else {
    echo ("Success");
    header("Location: useraccount.php");
}
