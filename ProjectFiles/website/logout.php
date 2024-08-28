<?php

//establish db connection
include('includes/dbconn.php');


session_start();

if (!isset($_SESSION['account_type'])) {
    header("Location: index.php");
} else {
    unset($_SESSION['account_type']);
    unset($_SESSION['id']);
    header("Location: index.php");
}
