<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lifesavers</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="exercise-styles2.css">
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
    	<h1>Running</h1>
        <form action="running.php" method="POST">
    		<label for="duration">Duration (minutes):</label>
    		<input type="number" id="duration" name="duration" min="1"><br>

    		<label for="intensity">Intensity:</label>
    		<select id="intensity" name="intensity">
    			<option value="low">Low</option>
    			<option value="medium">Medium</option>
    			<option value="high">High</option>
    		</select><br>

    		<label for="heart-rate">Heart Rate:</label>
    		<input type="number" id="heart-rate" name="heart-rate" min="1"><br>

    		<label for="calories">Calories Burnt:</label>
    		<input type="number" id="calories" name="calories" min="1"><br>

    		<label for="miles">Miles:</label>
    		<input type="number" id="miles" name="miles" min="0.01" step="0.01"><br>

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

	$params_needed = ["miles", "duration", "intensity", "heart-rate", "calories"];
	$given_params = array_keys($_POST);
	$missing_params = array_diff($params_needed, $given_params);

	if (!empty($missing_params)) {
		echo "<div class='alert2'>
				<strong>Error!</strong> Workout was not logged.
	  		</div>";
	} else {
		$id= getUserId($conn);
		$miles = $_POST['miles'];
		$duration = $_POST['duration'];
		$intensity = $_POST['intensity'];
		$heart_rate = $_POST['heart-rate'];
		$calories = $_POST['calories'];
	
		date_default_timezone_set('America/New_York');
		$currdate = date("Y-m-d H:i:s");
	
		$sql = "INSERT INTO Running (user_id, duration, intensity, date, heart_rate, calories_burnt, miles) VALUES ('$id', '$duration', '$intensity', '$currdate', '$heart_rate', '$calories', '$miles')";
	
		if (mysqli_query($conn, $sql)) {
			echo "<div class='alert1'>
					<strong>Success</strong> Workout successfully logged.
				  </div>";
		} else {
			echo "<div class='alert2'>
					<strong>Error!</strong> Workout was not logged.
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