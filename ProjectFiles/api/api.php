<?php

header("Content-Type: application/json");

//Return information about all albums in the database.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['all'])) {

    include('../website/includes/dbconn.php');
    //If no query parameter has been set, return all songs. 
    $query = mysqli_query($dbconn, "SELECT songs.id, songs.ranking, songs.year, songs.album, songs.artist, genre.genres, songs.url FROM songs INNER JOIN genre on songs.genre=genre.id ORDER BY songs.ranking ASC");

    if (!$query) {
        echo ($dbconn->error);
    } else {
        // build a response array
        $api_response = array();

        while ($row = mysqli_fetch_assoc($query)) {

            array_push($api_response, $row);
        }
        $response = json_encode($api_response);
        //echo out the response
        echo $response;
    }
}


//Return information about a song specified by the song ID.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    include('../website/includes/dbconn.php');

    $id = $_GET['id'];
    $stmt = $dbconn->prepare("SELECT songs.id, songs.ranking, songs.year, songs.album, songs.artist, genre.genres, songs.url FROM songs INNER JOIN genre ON songs.genre = genre.id WHERE songs.id=?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if (!$stmt) {
        echo ($dbconn->error);
    } else {

        $result = $stmt->get_result();
        $api_response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            array_push($api_response, $row);
        }
        //print_r($api_response);

        //get $subgenres and add to array. 

        $subgenres = '';
        $stmt = mysqli_prepare($dbconn, "SELECT genres FROM song_subgenres INNER JOIN genre ON song_subgenres.genre_id = genre.id WHERE song_id = ?;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = mysqli_fetch_assoc($result)) {
            $subgenres .= $row['genres'] . ', ';
        }
        //remove final ", " from subgenres. 
        $subgenres = substr($subgenres, 0, strlen($subgenres) - 2);
        $api_response[0]['subgenres'] = $subgenres;
    }

    //get average user rating if it exits
    $stmt = mysqli_prepare($dbconn, "SELECT AVG(rating) AS userscore FROM user_reviews WHERE song_id =?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = mysqli_fetch_assoc($result);
    $userscore = $row['userscore'];
    $userscore = number_format($userscore, 1, ".", ",");
    $api_response[0]['userscore'] = $userscore;

    $response = json_encode($api_response);
    echo $response;
}


//Return song data based on query paramaters passed in by user.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {

    include('../website/includes/dbconn.php');

    $query = $_GET['query'];
    $searchdata = htmlentities($query);
    $searchdata = $dbconn->real_escape_string($searchdata);
    $query = mysqli_query($dbconn, "SELECT songs.id, songs.ranking, songs.year, songs.album, songs.artist, genre.genres, songs.url FROM songs INNER JOIN genre on songs.genre=genre.id WHERE songs.artist LIKE '%$searchdata%' OR songs.album LIKE '%$searchdata%' OR genre.genres LIKE '%$searchdata%' ORDER BY songs.ranking ASC");

    if (!$query) {
        echo ($dbconn->error);
    } else {
        // build a response array
        $api_response = array();

        while ($row = mysqli_fetch_assoc($query)) {

            array_push($api_response, $row);
        }

        $response = json_encode($api_response);
        // echo out the response
        echo $response;
    }
}



//Return song reviews based on id. 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['review'])) {
    include('../website/includes/dbconn.php');
    $id = $_GET['review'];
    $stmt = mysqli_prepare($dbconn, "SELECT rating, review, datecreated, user_name FROM user_reviews INNER JOIN account on account.account_id = user_reviews.account_id WHERE song_id = ? AND admin_approved =1 ORDER BY datecreated desc LIMIT 0,10;");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if (!$stmt) {
        echo ($dbconn->error);
    } else {

        $result = $stmt->get_result();
        $api_response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            array_push($api_response, $row);
        }
    }

    $response = json_encode($api_response);
    echo $response;
}


//POST new user review to database to wait for admin approval. 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['postreview'])) {

    include('../website/includes/dbconn.php');

    //grab values from $_POST and perform basic security using htmlentities();
    $review = $dbconn->real_escape_string($_POST['review']);
    $rating = $dbconn->real_escape_string($_POST['rating']);
    $songid = $dbconn->real_escape_string($_POST['songid']);
    $userid = $dbconn->real_escape_string($_POST['userid']);

    $stmt = $dbconn->prepare("INSERT INTO `user_reviews` (`account_id`, `song_id`, `rating`, `review`, `admin_approved`, `datecreated`) VALUES (?, ?, ?, ?, '0', current_timestamp());");
    $stmt->bind_param("iiis", $userid, $songid, $rating, $review);
    $stmt->execute();

    if (!$stmt) {
        echo "Oops, looks like something went wrong. Please try again later or contact the development team.";
    } else {
        echo "Submitted for approval";
    }

    mysqli_close($dbconn);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['deletereview'])) {

    include('../website/includes/dbconn.php');

    //grab values from $_POST and perform basic security using htmlentities();
    $reviewid = $dbconn->real_escape_string($_POST['reviewid']);
    //echo($reviewid);
    $stmt = $dbconn->prepare("DELETE FROM `user_reviews` WHERE `user_reviews`.`review_id` = ?");
    $stmt->bind_param("i", $reviewid);
    $stmt->execute();



    if (!$stmt) {
        echo $dbconn->error;
        echo "<p> Something went wrong </p>";
    } else {
        echo ("Success");
    }
}
