
<!DOCTYPE html>
<html> 
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <form action="login.php" method="post">
            <h1>LIFESAVERS</h1>
            <h1>Login</h1>
            <?php if (isset($GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error'];?></p>
            <?php } ?>

            <div class="textBox">
                <input type="text" name="user" placeholder="Username">
            </div>
            <div>
                <input type="password" name="pass" placeholder="Password">
            </div>
            <input type="submit" value="Login" class="loginButton">
            <div class="signUp">
                Don't have an Account? Create one here!
                </br>
                <a href="../Signup/signup.php">Sign up</a>
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

    if (empty($username)) {
        echo "Please enter a username";
        exit();
    }
    else if (empty($password)) {
        echo "Please enter a password";
        exit();
    }
    else {
        $sql = "SELECT * FROM login_users WHERE user_name='$username'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['user_name'] === $username && password_verify($password, $row['password'])) {
                echo "<div>Successfully Logged In</div>";
                header("Location: ../homepage.html");
                exit();
            }
            else {
                echo "<div>Error: invalid username or password</div>";
                exit();
            }
            
        }
        else {
            echo "<div>Error: invalid username or password</div>";
            exit();
        }
    }
}

mysqli_close($conn);
?>
