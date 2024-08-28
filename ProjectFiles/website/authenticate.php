<?php

//establish db connection
session_start();
if (!isset($_SESSION['account_type'])) {
    $_session['account_type'] = 0;
}

include('includes/dbconn.php');

//grab values from $_POST 
$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $dbconn->prepare("SELECT user_name FROM account WHERE user_name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

if (!$stmt) {
    echo $dbconn->error;
    echo "<p> Something went wrong </p>";
}

$result = $stmt->get_result();
$num = $result->num_rows;

//check if username has been returned. 
if ($num > 0) {
    //retieve salt from databse
    $stmt = $dbconn->prepare("SELECT account.password FROM account WHERE account.user_name = ?;");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // if (!$stmt) {
    //     echo $dbconn->error;
    // }

    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $salt = substr($row[0], 0, 6);


    //use salt along with the user name and password that the user has passed in to check if the information the user has provided matches the information on record.

    $stmt = $dbconn->prepare("CALL CheckLoginDetails(?,?,?);");
    $stmt->bind_param("sss", $username, $password, $salt);
    $stmt->execute();

    // if (!$stmt) {
    //     echo $dbconn->error;
    //     echo "<p> Something went wrong </p>";
    // }

    $result = $stmt->get_result();
    $num = $result->num_rows;


    if ($num > 0) {
        echo "<p>success</p>";
        $row = $result->fetch_row();
        $account_type = intval($row[6]);
        $_SESSION['account_type'] = $account_type;
        $userid = intval($row[0]);
        $_SESSION['id'] = $userid;
        $name = $row[1] . ' ' . $row[2];
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $row[3];
        $_SESSION['email'] = $row[4];
        $_SESSION['timestamp'] = $row[7];


        header("Location: useraccount.php");
    } else {
        $_SESSION['Login'] = 'Failed';
        header("Location: login.php");
    }
} else {
    $_SESSION['Login'] = 'Failed';
    header("Location: login.php");
}
