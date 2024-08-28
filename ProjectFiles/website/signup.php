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

    <title>Sign Up</title>
</head>

<body>

    <?php
    include('includes/navbar.php');
    ?>

    <Main>
        <div class="container nav-padding">
            <div class="row">
                <div class="col sign-up-text">
                    <p>
                    <h1>Sign-up below to leave reviews and select your favourite albums!</h1>
                    </p>
                </div>
            </div>
            <div class=" row">
                <div class="col-2"></div>
                <div class="col-8">
                    <form method='POST'>
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type=" text" id="name" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control" name="surname" id="surname">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordhelp" required>
                            <div id="passwordhelp" class="form-text">Password must be between 8-12 characters in
                                length.
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" id="createaccount">Submit</button>
                    </form>

                </div>
                <div class="col-2"></div>
            </div>
            </form>
        </div>
    </Main>

</body>
<script>
    $(document).ready(function() {

        //https://www.w3resource.com/javascript/form/email-validation.php
        function ValidateEmail(email) {
            var valid = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (valid.test(email)) {
                return true;
            } else {
                return false;
            }

        }
        //Onclick function for the review submit button. 
        $('#createaccount').click(function() {

            //get the values passed in by the user
            var firstname = $('#name').val(),
                surname = $('#surname').val(),
                username = $('#username').val(),
                email = $('#email').val(),
                password = $('#password').val(),

                data = {};
            console.log(firstname);

            //ensure user hasnt entered an empty string. 
            if (firstname.length > 100 || firstname.length < 1) {
                alert('Name must be between 1 -100 characters.');
                return false;
            }
            //let length = userreview.length;
            if (surname.length > 100 || surname.length < 1) {
                alert('Surname must be between 1 -100 characters.');
                return false;
            }

            if (username.length > 15 || username.length < 1) {
                alert('Invalid Email');
                return false;
            }


            if (!ValidateEmail(email)) {
                alert('Invalid email. Must not be greater than 50 characters and contain @ symbol.');
                return false;
            }


            if (password.length > 12 || password.length < 8) {
                alert('Password must be between 8 and 12 characters.');
                return false;
            }

            //add data to array.
            data['name'] = firstname;
            data['surname'] = surname;
            data['username'] = username;
            data['email'] = email;
            data['password'] = password;

            //ajax call to passing a json file for insertion into the database. 
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    window.location.href = response;
                }

            });

            return false;
        });
    });
</script>


</html>