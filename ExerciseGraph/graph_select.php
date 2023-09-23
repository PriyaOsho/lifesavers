<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Exercise Graph</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="navbar">
        <a href="/CSE442-542/2023-Spring/cse-442r/homepage.php">Lifesavers</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Login/login.php" class="logout">Log Out</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/sleep.html" class="btn">Sleep</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Exercise/exercise.php" class="btn"><b>Exercise</b></a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Food/food.php" class="btn">Nutrition</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/UserInfoTesting/user_display.php" class="btn">Tracked Info</a>
    </div>

    <div class="date-select">
        <p>Select a range of dates to display graph information from</p>
        <form name="Filter" method="POST">
        From:
        <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
        <br/>
        To:
        <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
        <input type="submit" name="submit" value="Select"/>
        </form>
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

$user_id = getUserId($conn);

$from_date = date('Y-m-d', strtotime($_POST['dateFrom']));
$to_date = date('Y-m-d', strtotime($_POST['dateTo']));

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