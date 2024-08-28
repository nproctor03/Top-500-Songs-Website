<?php
session_start();

if (isset($_POST['review'], $_POST['rating'], $_POST['songid'])) {
    //grab values from $_POST and perform basic security using htmlentities();
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $songid = $_POST['songid'];
    $userid = $_SESSION['id'];

    $endpoint = "http://localhost/ProjectFiles/api/api.php?postreview";

    $postdata = http_build_query(

        array(
            'review' => $review,
            'rating' => $rating,
            'songid' => $songid,
            'userid' => $userid
        )
    );


    $opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );


    $context = stream_context_create($opts);
    $resource = file_get_contents($endpoint, false, $context);


    if ($resource !== FALSE) {
        echo "Success";
    } else {
        echo "Problem with insert";
    }
}
