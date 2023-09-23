<html>
	<head>
	    <meta charset="utf-8" content="width=device-width, initial-scale=1">
        <title>Sign-up</title>
        <style>
        .grid-container
        {
            display: grid;
            padding: 0px;
            color: white;
            justify-content: space-evenly;
        }
        .grid-item
        {
            border: 1px solid;
            border-color: black;
            border-radius: 40px;
            border-collapse: separate;
            padding: 30px;
            font-size: 30px;
            text-align: center;
            place-items: center;
            background-color: #a2a9e9;
        }
        </style>
    </head>
    <body style="background-color: #20243E">
        <form action="signup.php" method="post">
            <h1 style="color:white; text-align: center;">Create an Account</h1>
            <p style="color:white; text-align: center;">To create an account, please enter your email and password.</p>
            
            <div class="grid-container" style="align-items: center;">
                <div>
                    <div class="grid-item">
                        <p style="color: black">
                            Email:<br><input type="text" name="user" placeholder="Enter Email">
                        </p>
                        <p style="color: black">
                            Password:<br><input type="password" name="pass" placeholder="Enter Password">
                        </p>
                        <input type="submit" value="Create Account">
                        <br><br><hr>
                        <h1 style="color: black"> Welcome to Lifesavers!</h1>
                    </div>
                </div>
            </div>
		</form>
	</body>
</html>


<?php 
session_start();

require_once "db_conn.php";

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    if (empty($username))
    {
        echo "<br><div><p style='color: red; text-align: center'>Please enter an email</p></div>";
        exit();
    }
    else if (empty($password))
    {
        echo "<br><div><p style='color: red; text-align: center'>Please enter a password</p></div>";
        exit();
    }
	else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
		echo "<br><div><p style='color: red; text-align: center'>Please enter a valid email</p></div>";
        exit();
	}
    else if (strlen($password) < 8)
    {
        echo "<br><div><p style='color: red; text-align: center'>Password must be longer than 8 characters</p></div>";
        exit();
    }
    else
    {
		$stmt = $conn->prepare("SELECT * FROM login_users WHERE user_name=?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $username) 
            {
                echo "<br><div><p style='color: red; text-align: center'>Username already exists.</p></div>";
                exit();
            }
        }
        else 
        {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$create_stmt = $conn->prepare("INSERT INTO login_users (user_name, password) VALUES (?, ?)");
			$create_stmt->bind_param("ss", $username, $hashed_password);
			$create_stmt->execute();
			$check_stmt = $conn->prepare("SELECT * FROM login_users WHERE user_name=?");
			$check_stmt->bind_param("s", $username);
			$check_stmt->execute();
			$success = $check_stmt->get_result();
			$create_stmt->close();
			$check_stmt->close();
            if (mysqli_num_rows($success) === 1)
            {
                header("Location: ../Login/login.php");
            }
        }
    }
}
mysqli_close($conn);
?>