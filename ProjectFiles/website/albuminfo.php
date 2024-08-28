<?php

//establish db connection
include('includes/dbconn.php');
session_start();
if (!isset($_SESSION['account_type'])) {
    $_SESSION['account_type'] = 0;
}


$endpoint = "http://localhost/ProjectFiles/api/api.php";
//$reviewendpoint = "http://localhost/ProjectFiles/api/getreviews.php";

//If user has entered a search query, 
if (isset($_GET['id'])) {
    $albumendpoint = $endpoint . "?id=" . $_GET['id'];
    $reviewendpoint = $endpoint . "?review=" . $_GET['id'];

    //print_r($reviewendpoint);
}

$albumresource = file_get_contents($albumendpoint);
$data = json_decode($albumresource, true);
//var_dump($data);
$reviewresource = file_get_contents($reviewendpoint);
$reviews = json_decode($reviewresource, true);
//var_dump($reviews);


//establish db connection.
include('includes/dbconn.php');
//include('functions.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

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
    <link rel='stylesheet' href='albuminfo.css'>
    <title>Album Info</title>
</head>

<body>
    <?php
    include('includes/navbar.php')
    ?>

    <main>

        <div class="mycontainer">
            <?php
            $year = $data[0]['year'];
            $album = $data[0]['album'];
            $artist = $data[0]['artist'];
            $genre = $data[0]['genres'];
            $url = $data[0]['url'];
            $subgenres = $data[0]['subgenres'];
            $rating = $data[0]['userscore'];
            ?>


            <div class='uk-card uk-card-default uk-card-body uk-card-hover'>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-3">
                            <img src=<?php echo "$url" ?>>
                        </div>
                        <div class="col">
                            <ul id="mylist">
                                <li class="albuminfo">
                                    <?php echo "<h1>$album</h1>" ?> </li>
                                <li>
                                    <?php echo "<h3>$artist</h3>" ?> </li>
                                <li>
                                    <?php echo "<h4>Year: $year</h4>" ?> </li>
                                <li>
                                    <?php echo "<h4>Genre: $genre</h4>" ?>
                                </li>
                                <li>
                                    <?php echo "<h4>Subgenres: $subgenres</h4>" ?>
                                </li>
                            </ul>
                            </label>
                        </div>
                    </div>
                    <span></span>
                    <?php

                    if ($rating == 0) {
                        echo "<div class=' mybutton'> <button class='btn btn-success'>No audience score yet</button>
                    </div>";
                    } else {
                        echo "<div class='mybutton'> <button class='btn btn-success'>Audience Score: $rating/10</button>
                    </div>";
                    }

                    if ($_SESSION['account_type'] > 0) {
                        //check if the user has favoruited the song. Display the appropriate button.
                        $userid = $_SESSION['id'];
                        $songid = $_GET['id'];

                        $stmt = mysqli_prepare($dbconn, "SELECT favourite FROM favourites WHERE account_id = ? AND song_id =?;");
                        $stmt->bind_param('ii', $userid, $songid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $row = mysqli_fetch_row($result);
                        $Favourite = 0;

                        //Check if there is an existing favourite record. If so, set $Favourite accordingly. If not, $Favourite is defaulted to 0(line above); 
                        if (isset($row[0])) {
                            $Favourite = $row[0];
                        }


                        if ($Favourite) {
                            echo "<div class=' mybutton'> <button class='btn btn-success' id='favouritebutton'>Unfavourite</button>
                    </div>
                    </div>";
                        } else {
                            echo "<div class=' mybutton'> <button class='btn btn-success' id='favouritebutton'>Favourite</button>
                    </div>
                    </div>";
                        }
                    }
                    ?>


                    <p class="album-info">
                    <h1>Album Info</h1>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum harum numquam incidunt
                    alias, explicabo
                    atque dolor, eos inventore eius maiores neque minima, fugiat laboriosam voluptate nesciunt aliquam
                    quae
                    mollitia. Deserunt?
                    Aliquid, iure? Fugiat ab, deleniti laudantium impedit suscipit optio blanditiis facere illo.
                    Corrupti,
                    impedit laboriosam repudiandae autem hic et deleniti repellendus quo assumenda architecto, sit
                    nostrum
                    itaque sint, quae doloremque!
                    Quidem, neque optio ratione ducimus inventore sed sequi. Temporibus ipsa minus illo in nulla cum,
                    laborum dolore modi laudantium quo animi quidem quos fugiat praesentium reprehenderit nostrum quis,
                    facere quas.
                    At molestiae enim, voluptas saepe, consequuntur praesentium ea eius ipsa optio corporis facere
                    quaerat
                    porro rem, autem maiores fuga. Ipsa harum ex sint temporibus quod qui facilis possimus labore
                    voluptas?
                    Esse aperiam repellat molestiae, iusto nemo, eveniet qui culpa quas possimus cupiditate commodi
                    pariatur
                    earum sit aliquam quaerat eligendi cumque ipsa exercitationem ipsam impedit, explicabo deserunt
                    nihil.
                    Ab, ullam doloribus.
                    </p>
                </div>
            </div>
        </div>

        <div class="mycontainer nav-padding">
            <div class="row">
                <div class="col-6">
                    <h2>User Reviews</h2>

                    <?php
                    if (count($reviews) > 0) {
                        foreach ($reviews as $row) {
                            $rating = $row['rating'];
                            $review = $row['review'];
                            $datetime = $row['datecreated'];
                            $username = $row['user_name'];

                            $time = strtotime($datetime);
                            $date = date('h:i:s d M Y', $time);
                            echo "<div class='row'>
                                        <span><b> $username: @$date </b></span>
                                        <span class='wrap'>$review</span>
                                        <p>$rating/10</p>
                                     </div>";
                        }
                    } else {
                        echo "<div class='row'>
                                    <p><h4>Looks like no one has left a review yet...</h4></p>
                                    </div>
                                 <div class='row'>
                                <div class='very-doge'>
                        
                    
                        <img src='img/dogeEmpty.jpg' alt='WOW... much empty'>
                        </div>
                        </div>
                        <div class='row'><p></p></div>";
                    }
                    ?>

                </div>
                <div class='col-6'>
                    <h2>Leave a review</h2>

                    <?php
                    //disable if user not logged in. 


                    if ($_SESSION['account_type'] == 0) {

                        echo "<form method ='post'>
                                <div class='mb-3'>
                                    <label for='disabledreview' class='form-label'>Review</label>
                                    <textarea class='form-control' id='disabledreview' name='disabledreview' rows='3' aria-describedby='reviewHelp' disabled></textarea>
                                    <div id='reviewHelp' class='form-text'>Sign in to leave a review</div>
                                </div>
                                <div class='mb-3'>
                                    <label for='rating' class='form-label'>Rating</label>
                                    <input type='range' class='form-range' id='disabledrating' name='disabledating' aria-describedby='ratingHelp' disabled>
                                    <div id='ratingHelp' class='form-text'>Sign in to rate album</div>
                                </div>
                                <button type='button' id='submitButton' class='btn btn-primary' disabled>Submit</button>
                            </form>";
                    } else {
                        // input form connected to database which allows a user to leave a review /10 and a short written review.
                        echo "<form method ='post' name='review-form'>
                                <div class='mb-3'>
                                    <label for='review' class='form-label'>Review:</label>
                                     <textarea class='form-control' id='review' name='review' rows='3' aria-describedby='reviewHelp'></textarea>
                                    <div id='reviewHelp' class='form-text'>Must between 1-300 characters</div>
                                </div>
                                <div class='mb-3'>
                                    <label for='rating' class='form-label'>Rating</label>
                                    <input type='range' class='form-range' min='0' max='10' id='rating' name='rating' onchange='updateTextInput(this.value);' aria-describedby='ratingHelp'>
                                    <span class='form-text' id='textInput' value=''> </span>
                                    <div id='ratingHelp' class='form-text'>Leave a rating between 1-10</div>
                                </div>
                                <button type='button' id='submitButton' class='btn btn-primary'>Submit</button>
                            </form>";
                    }
                    ?>
                    <!-- ajax script to update database when submit button is clicked. -->
                    <!-- https://www.tutsmake.com/php-jquery-ajax-post-tutorial-example/ -->
                </div>
            </div>
        </div>
</body>
<script src=" myfunctions.js"></script>
<script>
    $(document).ready(function() {


        //Onclick function for the review submit button. 
        $('#submitButton').click(function() {

            //get the values passed in by the user
            var userreview = $('#review').val(),
                userrating = $('#rating').val(),
                id = "<?php $id = $_GET['id'];
                        echo $id ?>";
            data = {};

            //reset the form data
            var frm = document.getElementsByName('review-form')[0];
            frm.reset();

            //ensure user hasnt entered an empty string. 
            if (userreview.trim() == '') {
                alert('You cannot submit an empty review');
                return false;
            }
            //let length = userreview.length;
            if (userreview.length > 250) {
                alert('Review must be less that 250 characters in length');
                return false;
            }

            //add data to array.
            data['review'] = userreview;
            data['rating'] = userrating;
            data['songid'] = id;

            //ajax call to passing a json file for insertion into the database. 
            $.ajax({
                url: 'processreview.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    alert(response);
                }

            });

            return false;
        });

        //Onclick function for the favourite button.
        $('#favouritebutton').click(function() {

            //Grab text from favourite button. We will use this to decide wether we need to favrouite or unfavourite.
            var status = document.querySelector('#favouritebutton').innerHTML;
            console.log(status);

            if (status == 'Favourite') {

                //Reset text of favourite button
                document.querySelector('#favouritebutton').innerHTML = "Unfavourite";

                //set values to be passed and add to data array.
                var bool = 1,
                    songid = "<?php $id = $_GET['id'];
                                echo $id ?>",
                    userid = "<?php $id = $_SESSION['id'];
                                echo $id ?>",
                    data = {};

                data['favourite'] = bool;
                data['songid'] = songid;
                data['userid'] = userid;


                //pass values to update php for processing. 
                $.ajax({
                    url: 'updatefavourite.php',
                    type: 'post',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        alert(response);
                    }
                })
            } else if (status == 'Unfavourite') {

                document.querySelector('#favouritebutton').innerHTML = "Favourite";
                var bool = 0,
                    songid = "<?php $id = $_GET['id'];
                                echo $id ?>",
                    userid = "<?php $id = $_SESSION['id'];
                                echo $id ?>",
                    data = {};

                data['favourite'] = bool;
                data['songid'] = songid;
                data['userid'] = userid;

                $.ajax({
                    url: 'updatefavourite.php',
                    type: 'post',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        alert(response);
                    }
                })

            }

        });

    });
</script>

</html>