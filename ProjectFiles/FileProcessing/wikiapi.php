<?php
include('../website/includes/dbconn.php');

// Source: https://codesnippet.io/wikipedia-api-tutorial/
// https://en.wikipedia.org/w/api.php
// https://www.mediawiki.org/w/api.php?action=help&modules=query%2Bpageimages
// https://www.mediawiki.org/wiki/API:Tutorial#:~:text=To%20operate%20on%20the%20MediaWiki%20main%20site%20or,string%20in%20the%20URL%2C%20add%20the%20action%20parameter.

ini_set('max_execution_time', 300);
$sql = "SELECT * FROM songs";
$result = $dbconn->query($sql);

if (!$result) {
    echo $dbconn->error;
}

while ($row = $result->fetch_row()) {
    $album = $row[3];
    //echo "<p>$album</p>";
    //Process string to replace any ' ' with '%20'.
    $albumsearch = str_replace(' ', '%20', $album);

    //Set the API endpoint. This is the address we will call to get album information. title=$albumsearch uses the formated title string to search for the correct album. prop=pageimages specifies that we want the images associated with this webpage. pithumbsize =400 sets the maximium width of the images returned to 400 pixels. format =json sets the response format to a JSON file. formatversion=2 specifies the file to use the latest JSON format. pilicense=any specifies that we want all images regardless of usage licenses. In this case we are using any license type as it is a private non-commercial uni project. If this was a public/commercial project, licensing agreements would need to be taken into account. 
    $endpoint = "https://en.wikipedia.org/w/api.php?action=query&titles={$albumsearch}&prop=pageimages&pithumbsize=400&format=json&formatversion=2&pilicense=any";


    //file_get_contents reads the api response into a file. 
    $response = file_get_contents($endpoint);


    //Next we need to decode the JSON response object so that we can ass the image url to the database.

    $img = json_decode($response, true);

    //print out $img to check array index needed to grab img url.
    print_r($img);
    //echo "<p>$endpoint</p>";

    // if (!empty($img["query"]["pages"][0]["thumbnail"]["source"])) {
    //     $url = $img["query"]["pages"][0]["thumbnail"]["source"];
    // } else {
    //     //placeholder image. Will need to change this pathway when uploaded to EEECS server.
    //     $url = "img/404NotFound.jpeg";
    // }

    // //use of real_escape_string provides us with a album string with special characters escaped so we can use in an sql statement. 
    // $insert = $dbconn->real_escape_string($album);

    // $update = "UPDATE songs SET songs.url = '$url' WHERE songs.album = '$insert';";

    // $results = $dbconn->query($update);

    // if (!$results) {
    //     echo $dbconn->error;
    //     die();
    // }
}
    // echo "upload successful";
