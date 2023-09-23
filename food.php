<?php 
session_start();
require_once "db_conn.php";

if(!isset($_SESSION['token'])){
    header("Location: ../Login/login.php");
    exit();
}


$token = $_SESSION['token'];
$timeoutstmt = $conn->prepare("SELECT * FROM login_users WHERE token=?");
$timeoutstmt->bind_param("s", $token);
$timeoutstmt->execute();
$row = mysqli_fetch_assoc($timeoutstmt->get_result());
$timeoutstmt->close();
if(time() - $row['logintime'] > 86400){
	header("Location: ../Login/login.php");
}

function getUserId($conn){
    $token = $_SESSION['token'];
    $stmt = $conn->prepare("SELECT * FROM login_users WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
	$result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $stmt->close();
    return $row['id'];
}
$id = getUserId($conn);
$foodstmt = $conn->prepare("SELECT * FROM food_users WHERE id=?");
$foodstmt->bind_param("s", $id);
$foodstmt->execute();
$result = $foodstmt->get_result();
$totalCalories = 0;
while ($foodrow = mysqli_fetch_assoc($result)) {
    $totalCalories = $totalCalories + $foodrow["calories"];
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lifesavers</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="food_styles.css">
    </head>

    <body>
        <div class="nav">
            <a href="/CSE442-542/2023-Spring/cse-442r/homepage.php">Lifesavers</a>
            <a href="/CSE442-542/2023-Spring/cse-442r/Login/login" class="split">Log Out</a>
        </div>

        <div id="mySidenav" class="sidenav">
            <a href="" class="closebtn" onclick="closeNav()">x</a>
            <a href="food_add">Add Item</a>
            <a href="food_view">View Items</a>		
        </div>
        <span style="font-size:30px;cursor:pointer; color:white; padding: 10px;" onclick="openNav()">☰ Menu</span>
        <input type="hidden" id="calories" value="<?php echo $totalCalories; ?>">
        <div class="graph" style="width: 700px">
            <canvas id="calories-graph"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="../cal-graph.js"></script>

        <script>

            function openNav()
            {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav()
            {
                document.getElementById("mySidenav").style.width = "0";
            }

            closeNav()

        </script>
    </body>
</html>