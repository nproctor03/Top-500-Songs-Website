<?php
session_start();

if (isset($_POST['favourite'])) {
    // print_r($_POST);

    include('includes/dbconn.php');

    //grab values from $_POST and perform basic security using htmlentities();
    $bool = $dbconn->real_escape_string($_POST['favourite']);
    $acc = $dbconn->real_escape_string($_POST['userid']);
    $song = $dbconn->real_escape_string($_POST['songid']);
    // print_r($review);
    // print_r($rating);
    // print_r($songid);
    // print_r($userid);

    //check if record exists. if it does not, we need to use an insert statement instead of an update. 
    $sql = "SELECT favourite_id FROM favourites WHERE song_id = '$song' AND account_id ='$acc'";
    $result = $dbconn->query($sql);
    $num = mysqli_num_rows($result);

    if ($num > 0) {

        $sql = "UPDATE `favourites` SET `favourite` = '$bool' WHERE account_id ='$acc' AND song_id ='$song'";

        $update = $dbconn->query($sql);
        if (!$update) {
            echo "Oops, looks like something went wrong. Please try again later or contact the development team.";
        } else {
            echo "Record Updated";
        }
    } else {
        $sql = "INSERT INTO `favourites` (`account_id`, `song_id`, `favourite`) VALUES ('$acc', '$song', '$bool');";
        $insert = $dbconn->query($sql);

        if (!$insert) {
            echo "Oops, looks like something went wrong. Please try again later or contact the development team.";
        } else {
            echo "Record Inserted";
        }
    }
    // $stmt->bind_param("iiis", $userid, $songid, $rating, $review);
    // $stmt->execute();

    mysqli_close($dbconn);
}
