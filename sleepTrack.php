<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lifesavers</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="sleepStyle.css">
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
    	<h1>Sleep</h1>
    	<form action="sleepTrack.php" method="POST">
    		<label for="Hours">How many hours?:</label>
    		<input hour="1"><br>

    		<label for="Minutes">How many minutes did you sleep?:</label>
    		<select min="1">
    		</select><br>

    		<input type="submit" name="submit" id="submit" value="Submit">
    	</form>
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

if(isset($_POST['submit'])) {

	$params_needed = ["Hours", "Minutes"];
	$given_params = array_keys($_POST);
	$missing_params = array_diff($params_needed, $given_params);

	if (!empty($missing_params)) {
		echo "<div class='alert2'>
				<strong>Error!</strong> Sleep was not logged.
	  		</div>";
	} else {
		$id= getUserId($conn);
		$Hours = $_POST['Hours'];
		$Minutes = $_POST['Minutes'];
		

	
		date_default_timezone_set('America/New_York');
		$currdate = date("Y-m-d H:i:s");
	
		$sql = "INSERT INTO Sleep (user_id, Hours, Minutes, date) VALUES ('$id', '$Hours', '$Minutes', '$currdate')";
	
		if (mysqli_query($conn, $sql)) {
			echo "<div class='alert1'>
					<strong>Success</strong> Sleep successfully logged.
				  </div>";
		} else {
			echo "<div class='alert2'>
					<strong>Error!</strong> Sleep was not logged.
				  </div>"
				  . mysqli_error($conn);
		}
	}
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