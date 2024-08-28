<?php

//establish db connection
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

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.10.0/dist/js/uikit-
        icons.min.js "></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <link rel='stylesheet' href='ui.css'>
    <title>Account Creation Failed</title>
</head>

<body>
    <?php
    include('includes/navbar.php');

    echo "<div class='container nav-padding'>

        <div class='row'>
            <div class='col sign-up-text'>
                <p>
                <h1>There has been an error creating your account.</h1>
                <h3>This username already exists. Please check your details and try again.</h3>
                </p>

                <div class='nav-padding'>
                    <a class='btn btn-success' href='signup.php' role='button'>Return To Sign Up</a>";

    ?>
</body>

</html>