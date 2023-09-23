<?php
$servername = "oceanus.cse.buffalo.edu";
$username = "rtkeenen";
$password = "50301840";
$db = "cse442_2023_spring_team_r_db";

$conn = new mysqli($servername, $username, $password, $db);

// checking connection
if ($conn->connect_error) {
    die("Error, connection failed: " . $conn->connect_error);
}
?>