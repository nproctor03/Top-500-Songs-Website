<?php

//establish db connection
session_start();
if (!isset($_SESSION['account_type'])) {
    $_session['account_type'] = 0;
}
include('includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/css/uikit.min.css" />

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit-icons.min.js "></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <link rel='stylesheet' href='ui.css'>

    <title>Account</title>
</head>

<body>
    <?php
    include('includes/navbar.php');
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $date = $_SESSION['timestamp'];
    ?>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class='col-3 nav-padding'>
                    <h2>Account Info</h2>
                    <div class='nav-padding'>
                        <ul class="mylist">
                            <li>
                                <?php echo "<h4>Name: $name</h4>" ?> </li>
                            <li>
                                <?php echo "<h4>Username: $username </h4>" ?> </li>
                            <li>
                                <?php echo "<h4>Email: $email</h4>" ?> </li>
                            <li>
                                <?php echo "<h4>Account created: $date</h4>" ?>
                            </li>
                            <li>
                                <?php echo "<h4>Reset password</h4>" ?>
                            </li>
                        </ul>
                        </label>
                    </div>


                    <?php

                    if ($_SESSION['account_type'] == '3') {
                    }

                    ?>

                </div>
                <div class=" col-9 nav-padding">

                    <?php

                    if ($_SESSION['account_type'] == 3) {

                        echo  "
                        <h2>Reviews To Be Approved</h2>
                        <table class='uk-table uk-table-divider uk-table-middle uk-table-small'>
                                                <caption></caption>
                                                <thead>
                                                    <tr>
                                                        <th class='uk-width-1-6'><h4>Review ID</h4></th>
                                                        <th class='uk-width-1-6'><h4>Album</h4></th>
                                                        <th><h4>Review</h4></th>
                                                        <th><h4>Approve/Reject</h4></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                </tfoot>
                                                <tbody>
                                ";


                        $sql = "SELECT user_reviews.review_id, user_reviews.review, songs.album FROM user_reviews INNER JOIN songs ON user_reviews.song_id = songs.id WHERE user_reviews.admin_approved = 0;";
                        $result = $dbconn->query($sql);

                        if ($row = mysqli_fetch_row($result)) {

                            do {
                                $reviewid = $row[0];
                                $review = $row[1];
                                $album = $row[2];
                                $approve = 'approvereview.php?id=' . $reviewid;
                                $reject = 'rejectreview.php?id=' . $reviewid;

                                echo "<tr>
                                            <td class='reviewid'>$reviewid</td>
                                            <td>$album</td>
                                            <td class='uk-text-break'>$review</td>
                                            <td><a href='$approve'><button class='btn btn-primary btn-sm button-margin'>Approve</button></a><a href='$reject'><button class='btn btn-danger btn-sm'>Reject</button></a></td>
                                        </tr>";
                            } while ($row = mysqli_fetch_row($result));
                            echo "</tbody>";
                        } else {
                            echo "<tr>
                                            <td>Wow...Such Empty. Why not go add some favourites?</td>
                                            <td><h4></h4></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>";
                        }
                    } else {

                        echo  "
                        <h2>My Favourites</h2>
                        <table class='uk-table uk-table-divider uk-table-middle uk-overflow-auto'>
                                                <caption></caption>
                                                <thead>
                                                    <tr>
                                                        <th><h4>Ranking</h4></th>
                                                        <th><h4>Artist</h4></th>
                                                        <th><h4>Album</h4></th>
                                                        <th><h4>Album Art</h4></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                </tfoot>
                                                <tbody>";

                        $id = $_SESSION['id'];
                        $sql = "SELECT * FROM songs INNER JOIN favourites on songs.id = favourites.song_id WHERE favourites.favourite =1 AND favourites.account_id ='$id';";
                        $result = $dbconn->query($sql);

                        if ($row = mysqli_fetch_row($result)) {

                            do {
                                $num = $row[0];
                                $artist = $row[4];
                                $album = $row[3];
                                $url = $row[6];
                                $rank = $row[1];

                                echo "<div class='uk-child-width-1-3@m uk-grid-small uk-grid-match' uk-grid>";
                                echo "<tr>
                                            <td><h4>$rank</h4></td>
                                            <td><h4>$artist</h4></td>
                                            <td><h4><a href='albuminfo.php?id=$num'>$album</h4></td>
                                            <td><img src='$url' class='album_art'</img></td>
                                        </tr>";
                            } while ($row = mysqli_fetch_row($result));
                            echo "</tbody>";
                        } else {
                            echo "<tr>
                                            <td>Wow...Such Empty. Why not go add some favourites?</td>
                                            <td><h4></h4></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>";
                        }
                    }

                    mysqli_close($dbconn);
                    ?>

                </div>
            </div>

        </div>
    </main>

</body>
<script src="myfunctions.js"></script>

</html>