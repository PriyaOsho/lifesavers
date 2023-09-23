<!DOCTYPE html>
<html>
    <head>
        <title>Reset password</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <form action="reset.php" method="post">
            <h1>LIFESAVERS</h1>
            <h1>Reset Password</h1>
            <div class="textBox">
                <input type="password" name="newpass" placeholder="New Password">
				<input type="hidden" name="key" value="<?php echo $_GET['key'];?>">
            </div>
            <input type="submit" value="Reset" class="loginButton">
        </form>
    </body>
</html>
<?php
require_once "../db_conn.php";

if (isset($_GET['key'])) {
	$urlKey = base64_decode($_GET['key']);
	list($id, $user_name, $password, $token, $logintime) = explode(" ", $urlKey);
	$stmt = $conn->prepare("SELECT * FROM login_users WHERE id=? AND user_name=? AND password=? AND token=? AND logintime=?");
	$stmt->bind_param("issss", $id, $user_name, $password, $token, $logintime);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if (mysqli_num_rows($result) === 1) {
		
	}else 
	{
		echo "<br><div><p style='color: red; text-align: center'>Link expired, please request a new reset link.</p></div>";
		header("Location: ../Login/login.php");
	}
}
if (isset($_POST['newpass'])) {
	$newpass = $_POST['newpass'];
	$key = $_POST['key'];
	if (empty($newpass)) {
		echo "Please enter a new password";
	}
	else{
		$hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
		list($id, $user_name, $password, $token, $logintime) = explode(" ", base64_decode($key));
		$stmt = $conn->prepare("SELECT * FROM login_users WHERE id=? AND user_name=? AND password=? AND token=? AND logintime=?");
		$stmt->bind_param("issss", $id, $user_name, $password, $token, $logintime);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if (mysqli_num_rows($result) === 1) {
			$changepass_stmt = $conn->prepare("UPDATE login_users SET password=? WHERE user_name=? AND logintime=?");
			$changepass_stmt->bind_param("sss", $hashed_password, $user_name, $logintime);
			$changepass_stmt->execute();
			$changepass_stmt->close();
			header("Location: ../Login/login.php");
		}
		else {
			echo "<br><div><p style='color: red; text-align: center'>Link expired, please request a new reset link.</p></div>";
			exit();
		}
	}
}
mysqli_close();
?>