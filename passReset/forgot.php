<!DOCTYPE html>
<html>
    <head>
        <title>Forgot password</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <form action="forgot.php" method="post">
            <h1>LIFESAVERS</h1>
            <h1>Reset Password</h1>
            <?php if (isset($GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error'];?></p>
            <?php } ?>

            <div class="textBox">
                <input type="text" name="user" placeholder="Email address">
            </div>
            <input type="submit" value="Reset" class="loginButton">
        </form>
    </body>
</html>
<?php 
session_start();
require_once "../db_conn.php";

if (isset($_POST['user'])) {
    $username = $_POST['user'];
    if (empty($username)) {
        echo "Please enter an email";
        exit();
    }
    else {
        $stmt = $conn->prepare("SELECT * FROM login_users WHERE user_name=?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
			$resetKey = urlencode(base64_encode("{$row["id"]} {$row["user_name"]} {$row["password"]} {$row["token"]} {$row["logintime"]}"));
			$subject = "Account password reset requested.";
			$txt = "Reset password: https://www-student.cse.buffalo.edu/CSE442-542/2023-Spring/cse-442r/passReset/reset.php?key={$resetKey}";
			mail($username, $subject, $txt);
        }
        echo "<div>An email has been sent with a link to reset your password, if an account exists.</div>";
    }
}

function generateRandomString($length) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

mysqli_close($conn);
?>
