<?php
//check is session is already started.
if (!isset($_SESSION)) {
    session_start();
}
//check if user account type is set. If it is not, set it to 0 (guest account).
if (!isset($_SESSION['account_type'])) {
    $_SESSION['account_type'] = 0;
}
//check if user search has been set. If not, set to 0. 
if (isset($_GET['user_search'])) {
    $search = $_GET['user_search'];
} else {
    $search = '';
}


//set up api connection.
$endpoint = "http://nproctor03.webhosting6.eeecs.qub.ac.uk/ProjectFiles/api/api.php?all";

//If user has entered a search query, 
if (isset($_GET['query'])) {
    $endpoint = "http://nproctor03.webhosting6.eeecs.qub.ac.uk/ProjectFiles/api.php" . "?query=" . $_GET['query'];
}


$resource = file_get_contents($endpoint);
$data = json_decode($resource, true);


//establish db connection.
//include('includes/dbconn.php');
//include('functions.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit-icons.min.js "></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel='stylesheet' href='ui.css'>
    <title>Rolling Stones Top 500</title>
</head>

<body>
    <?php
    include('includes/navbar.php');
    ?>

    <div id="banner-padding">
        <div class="container column">
            <div>
                <h1 class="my-subtitle">The Rolling Stone 500 Greatest Songs Of All Time!</h1>
                <h4>The worlds greatest songs, alll in one place. </h4>
                <!-- #showcase adds and positions background image within the banner-->
                <section id="showcase"></section>
            </div>
        </div>
    </div>

    <main>
        <div>
            <div class="column container">
                <div class='uk-child-width-1-3@m uk-grid-small uk-grid-match' uk-grid>

                    <?php

                    foreach ($data as $row) {

                        $id = $row['id'];
                        $rank = $row['ranking'];
                        $album = $row['album'];
                        $artist = $row['artist'];
                        $url = $row['url'];
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
                    } ?>
    </main>
    <div id="myfooter">
        <footer id="footer-link">
            <a href="index.php">Back to top</a>
        </footer>
    </div>

</body>
<script>
    $(document).ready(function() {

        //Onclick function for the review submit button. 
        $('#searchbutton').click(function() {

            //get the values passed in by the user
            var input = $('#searchbar').val();
            window.location.href = "index.php?query=" + input;
        });

    })
</script>
<script src="myfunctions.js"></script>;

</html>