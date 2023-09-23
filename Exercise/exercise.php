
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lifesavers</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="exercise-styles1.css">
    </head>
    <body>
        <div class="navbar">
            <a href="/CSE442-542/2023-Spring/cse-442r/homepage.html">Lifesavers</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Login/login.php" class="logout">Log Out</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/sleep.html" class="btn">Sleep</a>
            <a href="exercise.php" class="btn"><b>Exercise</b></a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Food/food.php" class="btn">Nutrition</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/UserInfoTesting/user_display.php" class="btn">Tracked Info</a>
        </div>

        <div class="dropdown">
            <button class="dropdown-btn">Add New Workout</button>
            <div class="dropdown-content">
            <a href="running.php">Running</a>
            <a href="swimming.php">Swimming</a>
            <a href="cycling.php">Cycling</a>
            <a href="deadlifts.php">Deadlifts</a>
            <a href="weightlift.php">Weight Lifting</a>
            <a href="squats.php">Squats</a>
            <a href="custom.php">Custom</a>
            </div>
        </div>
    </body>
</html>

<?php
session_start();

require_once "db_conn.php";

if (isset($_GET['logout'])) {
	logout();
}

if(!isset($_SESSION['token'])){
    header("Location: ../Login/login.php");
}
$token = $_SESSION['token'];
$sql = "SELECT * FROM login_users WHERE token='$token'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(time() - $row['logintime'] > 86400){
	header("Location: ../Login/login.php");
}

 
function getUserId($conn){
    $token = $_SESSION['token'];
    $sql = "SELECT * FROM login_users WHERE token='$token'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['id'];
}

function logout(){
	session_unset();
	session_destroy();
}

mysqli_close($conn);
?>