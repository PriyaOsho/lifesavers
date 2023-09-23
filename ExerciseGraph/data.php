
<?php
session_start();
require_once "db_conn.php";
header('Content-Type: application/json');

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

$userid = getUserId($conn);

$query = "SELECT duration, heart_rate, calories_burnt FROM cust_exercise WHERE cust_exercise.user_id = '$userid' 
        UNION SELECT duration, heart_rate, calories_burnt FROM Cycling WHERE Cycling.user_id = '$userid' 
        UNION SELECT duration, heart_rate, calories_burnt FROM Running WHERE Running.user_id = '$userid' 
        UNION SELECT duration, heart_rate, calories_burnt FROM deadlifts WHERE deadlifts.user_id = '$userid'
        UNION SELECT duration, heart_rate, calories_burnt FROM squats WHERE squats.user_id = '$userid'
        UNION SELECT duration, heart_rate, calories_burnt FROM Swimming WHERE Swimming.user_id = '$userid'
        UNION SELECT duration, heart_rate, calories_burnt FROM Weightlifts WHERE Weightlifts.user_id = '$userid'";

$result = mysqli_query($conn, $query);


$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);

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
?>