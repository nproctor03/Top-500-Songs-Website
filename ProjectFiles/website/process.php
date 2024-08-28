<?php

//establish db connection
include('includes/dbconn.php');

//Grab form values and perform basic security using htmlentities();
$name = $dbconn->real_escape_string($_POST["name"]);
$surname = $dbconn->real_escape_string($_POST["surname"]);
$username = $dbconn->real_escape_string($_POST["username"]);
$email = $dbconn->real_escape_string($_POST["email"]);
$password = $dbconn->real_escape_string($_POST["password"]);


$stmt = $dbconn->prepare("CALL CreateUserAccount(?, ?, ?, ?, ?);");
$stmt->bind_param("sssss", $name, $surname, $username, $email, $password);
$stmt->execute();


if ($stmt->errno == 1062) {
    echo "accountfailed.php";
} else {
    echo "accountcreated.php";
}
