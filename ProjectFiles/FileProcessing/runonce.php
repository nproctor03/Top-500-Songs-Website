<?php

//establish db connection
include('includes/dbconn.php')

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- Add cleaned genre data to the database
    <?php

    //Open desired file
    $file = fopen("FileProcessing/cleaned_genres.csv", 'r');

    //loop through each line of the file
    while (($data = fgetcsv($file)) != false) {

        foreach ($data as $i) {
            //Insert into relevant tables
            //echo "<p>INSERT INTO genre (Genre) Values ('{$i}');</p>";
            $sql = "INSERT INTO genre (genres) Values ('{$i}');";
            $result = $dbconn->query($sql);

            if (!$result) {
                print_r("mysql error" . $dbconn->error);
            }
        }
    }

    fclose($file);
    ?> -->


    <!-- Add cleaned song datato the database-->

    <?php

    // Open desired file
        $songs = fopen("FileProcessing/cleaned_data.csv", 'r');

        while (($data = fgetcsv($songs)) != false) {

        $data = array_filter($data);

        $ranking = $data[0];
        $year = $data[1];
        $album = $data[2];
        $artist = $data[3];
        $genre = $data[4];

        //Search genre table to get genre id.
        $genreid = mysqli_query($dbconn, "SELECT id FROM genre WHERE genres ='$genre'");

        if (!$genreid) {
            echo 'Error' . mysqli_error($dbconn);
        }

        $row = mysqli_fetch_row($genreid);
        $id = $row[0];
        $sql = "INSERT INTO songs (ranking, year, album, artist, genre) VALUES('$ranking','$year','$album','$artist', '$id');";


        $result = $dbconn->query($sql);
        //grabs the last insert id and assigs it to the $song id variable. 
        $songID = mysqli_insert_id($dbconn);

        if (!$result) {
            print_r("mysql error" . $dbconn->error);
        }

        //Loop through subgenres and add them to subgenre table and link to song.
        for ($i = 5; $i < count($data); $i++) {

            $subgenre = trim($data[$i]);
            $subgenreID = mysqli_query($dbconn, "SELECT id FROM genre WHERE genres ='$subgenre';");
            $row = mysqli_fetch_row($subgenreID);

            $genreid = $row[0];
            $sql = "INSERT INTO song_subgenres (song_id, genre_id) VALUES('$songID', '$genreid'); ";

            $result = $dbconn->query($sql);

            if (!$result) {
                print_r("mysql error" . $dbconn->error);
            }
        }
    }

    ?>

</body>

</html>