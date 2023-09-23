<?php
session_start();

header('Content-Type: application/json');

require_once("db_conn.php");

//$from_date = 

//echo $_SESSION['from_date'];
//$to_date = 
//echo $_SESSION['to_date'];

$from_date = $_POST['dateFrom'];
$to_date = $_POST['dateTo'];

$query = "SELECT duration FROM cust_exercise WHERE data BETWEEN '$from_date' AND '$to_date'";

/*
$query = "SELECT duration, heart_rate, calories_burnt FROM cust_exercise WHERE cust_exercise.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM Cycling WHERE Cycling.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM Running WHERE Running.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM deadlifts WHERE deadlifts.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM squats WHERE squats.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM Swimming WHERE Swimming.user_id = 1 
        UNION SELECT duration, heart_rate, calories_burnt FROM Weightlifts WHERE Weightlifts.user_id = 1";
*/
$result = mysqli_query($conn, $query);


$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

mysqli_close($conn);

//echo json_encode($data);
?>