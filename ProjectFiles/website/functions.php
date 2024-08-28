<?php

//filter function. 
function filterdata(string $data)
{
    include('includes/dbconn.php');
    $searchdata = htmlentities('' . $data . '%');
    $searchdata = $dbconn->real_escape_string($searchdata);

    $query = mysqli_query($dbconn, "SELECT songs.id, songs.ranking, songs.album, songs.artist, songs.url FROM songs INNER JOIN genre on songs.genre=genre.id WHERE songs.artist LIKE '%$searchdata%' OR songs.album LIKE '%$searchdata%' OR genre.genres LIKE '%$searchdata%' ORDER BY songs.ranking ASC");


    if (!$query) {
        echo ($dbconn->error);
    } else {

        if ($row = mysqli_fetch_row($query)) {
            do {;
                $id = $row[0];
                $rank = $row[1];
                $album = $row[2];
                $artist = $row[3];
                $url = $row[4];
                echo "<div>
                        <div class='uk-card-default  uk-card- uk-card-body uk-card-hover'>
                            <div class='uk-card-body'>
                                <img src='$url' class='album_art'>
                            </div>
                            <div class='uk-card-footer card-footer'>
                                <h3 class='uk-card-title song-name'><a href='albuminfo.php?id=$id'>$rank: $album</a></h3>
                                <h4>$artist</h4>
                            </div>
                        </div>
                    </div>";
            } while ($row = mysqli_fetch_row($query));
        } else {
            echo "<p>Oops.. check your search data and try again!</p>";
        }
    }
    //mysqli_close($query);
}
