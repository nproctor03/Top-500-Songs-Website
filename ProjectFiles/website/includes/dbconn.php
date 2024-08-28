<?php
$host = "nproctor03.webhosting6.eeecs.qub.ac.uk";
$user = "nproctor03";
$pw = "nK49hHPq7fJJ9rJt";
$db = "nproctor03";

$dbconn = new mysqli($host, $user, $pw, $db);

if ($dbconn->connect_error) {
    echo $conn->connect_error;
}
