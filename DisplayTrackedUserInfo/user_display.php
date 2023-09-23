

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>UserInfoDisplayed</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div class="navbar">
            <a href="/CSE442-542/2023-Spring/cse-442r/homepage.html">Lifesavers</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Login/login.php" class="logout">Log Out</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/sleep.html" class="btn">Sleep</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Exercise/exercise.php" class="btn"><b>Exercise</b></a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Food/food.php" class="btn">Nutrition</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/UserInfoTesting/user_display.php" class="btn">Tracked Info</a>
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

echo "<div>";
$sql = "SELECT name, calories, fat, cholesterol, sodium, sugar, carbs, protein FROM food_users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Food</caption><tr><th>Name</th><th>Calories</th><th>Fat</th><th>Cholesterol</th><th>Sodium</th><th>Sugar</th>
    <th>Carbs</th><th>Protein</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["calories"]. "</td><td>" . $row["fat"]. "</td><td>" . $row["cholesterol"].
            "</td><td>" . $row["sodium"]. "</td><td>" . $row["sugar"]. "</td><td>" . $row["carbs"]. "</td><td>" . $row["protein"].
            "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Nutrition</br>";
}   
echo "</div>";

echo "<div>";
$sql = "SELECT ExName, Intensity, CaloriesBurned, Date, Duration, heart_rate FROM cust_exercise WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Custom Exercises</caption>
    <tr><th>Name</th><th>Intensity</th><th>Calories Burned</th><th>Duration</th><th>Heart Rate</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ExName"]. "</td><td>" . $row["Intensity"]. "</td><td>" . $row["CaloriesBurned"]. "</td>
            <td>" . $row["Duration"]. "</td><td>" .$row["heart_rate"]. "</td><td>". $row["Date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Custom Exercises</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, intensity, date, heart_rate, calories_burnt, miles FROM Running WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Runs</caption>
    <tr><th>Duration</th><th>Intensity</th><th>Heart Rate</th><th>Calories Burned</th><th>Miles</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["intensity"]. "</td><td>" . $row["heart_rate"]. "</td>
            <td>" . $row["calories_burnt"]. "</td><td>" .$row["miles"]. "</td><td>" . $row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Running</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, intensity, date, heart_rate, calories_burnt, miles FROM Cycling WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Cycles</caption>
    <tr><th>Duration</th><th>Intensity</th><th>Heart Rate</th><th>Calories Burned</th><th>Miles</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["intensity"]. "</td><td>" . $row["heart_rate"]. "</td>
            <td>" . $row["calories_burnt"]. "</td><td>" .$row["miles"]. "</td><td>" . $row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Cycling</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, intensity, date, heart_rate, calories_burnt, miles, laps FROM Swimming WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Swims</caption>
    <tr><th>Duration</th><th>Intensity</th><th>Heart Rate</th><th>Calories Burned</th><th>Miles</th><th>Laps</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["intensity"]. "</td><td>" . $row["heart_rate"]. "</td>
            <td>" . $row["calories_burnt"]. "</td><td>" .$row["miles"]. "</td><td>" .$row["laps"]. "</td><td>" . $row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Swimming</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, weight, reps, date, heart_rate, calories_burnt FROM deadlifts WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Deadlifts</caption>
    <tr><th>Duration</th><th>Weight</th><th>Reps</th><th>Heart Rate</th><th>Calories Burned</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["weight"]. "</td><td>" . $row["reps"]. "</td>
            <td>" . $row["heart_rate"]. "</td><td>" .$row["calories_burnt"]. "</td><td>" .$row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Deadlifts</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, weights, reps, date, heart_rate, calories_burnt FROM Weightlifts WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Weightlifts</caption>
    <tr><th>Duration</th><th>Weight</th><th>Reps</th><th>Heart Rate</th><th>Calories Burned</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["weight"]. "</td><td>" . $row["reps"]. "</td>
            <td>" . $row["heart_rate"]. "</td><td>" .$row["calories_burnt"]. "</td><td>" .$row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Weightlifts</br>";
} 
echo "</div>";

echo "<div>";
$sql = "SELECT duration, weights, reps, date, heart_rate, calories_burnt FROM squats WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><caption>Tracked Squats</caption>
    <tr><th>Duration</th><th>Weight</th><th>Reps</th><th>Heart Rate</th><th>Calories Burned</th><th>Date</th>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["duration"]. "</td><td>" . $row["weight"]. "</td><td>" . $row["reps"]. "</td>
            <td>" . $row["heart_rate"]. "</td><td>" .$row["calories_burnt"]. "</td><td>" .$row["date"]. "</td></tr>";
            echo "</table";
    } 
} else {
    echo "<br>0 results for Squats</br>";
} 
echo "</div>";

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