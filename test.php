
<!DOCTYPE html>
<html> 
    <head>
        <title>LOGIN</title>
    </head>

    <body>
        <form action="test.php" method="post">
            <h2>LOGIN</h2>
            
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error'];?></p>

            <?php } ?>

             <label>User Name</label>
             <input type="text" name="username" placeholder="User Name"><br>

             <label>Password</label>
             <input type="password" name="password" placeholder="Password"><br>

             <button type="submit">Login</button>
        </form>
    </body>
</html>

<?php 
session_start();

require_once "db_conn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        echo "Please enter a username";
        exit();
    }
    else if (empty($password)) {
        echo "Please enter a password";
        exit();
    }
    else {
        $sql = "SELECT * FROM login_users WHERE user_name='$username' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['user_name'] === $username && $row['password'] === $password) {
                echo "Successfully Logged In";
                exit();
            }
            else {
                echo "Error: invalid username or password";
                exit();
            }
        }
        else {
            echo "Error: invalid username or password";
            exit();
        }
    }
}

mysqli_close($conn);
?>
