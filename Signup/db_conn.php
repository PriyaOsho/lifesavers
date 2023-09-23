<?php
$servername = "localhost";
$username = "webdevv";
$password = "developmentsucks";
$db = "cse442";

$conn = new mysqli($servername, $username, $password, $db);

// checking connection
if ($conn->connect_error) {
    die("Error, connection failed: " . $conn->connect_error);
}
?>