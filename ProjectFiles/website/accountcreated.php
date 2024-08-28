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
    <title>Account Created</title>
</head>

<body>
    <?php
    include('includes/navbar.php');

    echo "<div class='container nav-padding'>

        <div class='row'>
            <div class='col sign-up-text'>
                <p>
                <h1>Your Account has been created. Please Log in below. </h1>
                </p>
                    
                <div class=' row'>
                    <div class='col-3'></div>
                        <div class='col-6'>
                            <form action='authenticate.php' method='POST'>
                                <div class='mb-3'>
                                    <label for='username' class='form-label'>Username</label>
                                    <input type='text' class='form-control' name='username' id='username' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='password' class='form-label'>Password</label>
                                    <input type='password' class='form-control' name='password' id='password' required>
                                </div>

                                <button type='submit' class='btn btn-primary'>Login</button>
                            </form>
                        </div>
                    </div>
                    <div class='col-3'></div>
                </div>

            </div>
        </div>";

    ?>
</body>

</html>