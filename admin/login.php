<?php
include('../config/constants.php');

$err = [];

if(isset($_POST['submit'])) {
    if(isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $username = trim($_POST['username']);
    } else {
        $err['username'] = "Enter username";
    }

    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $err['password'] = "Enter password";
    }

    if(empty($err)) {
        $sql = "SELECT * FROM tbl_admin WHERE username='$username'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $row = mysqli_fetch_assoc($res);
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['login'] = "Login Successful";
                    $_SESSION['user'] = $username;
                    header('Location: ' . SITEURL . 'admin/');
                    exit;
                }
            } else {
                $_SESSION['login'] = "<span class='error text-center'>Incorrect Username or Password</span>";
                header('Location: ' . SITEURL . 'admin/login.php');
                exit;
            }
        } else {
            $_SESSION['login'] = "Database error: Unable to execute query.";
            header('Location: ' . SITEURL . 'admin/login.php');
            exit;
        }
    }
}
?>

<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    
    <div class="login">
        <h1 class="text-center">Admin Login</h1>
        <br><br>

        <!-- Error message display -->
        <?php 
        if(isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <span class="error"><?php if(isset($err['username'])) echo $err['username'] . "<br>"; ?></span>
            <input type="text" name="username" placeholder="Enter Username">
            <br><br>
            Password: <br>
            <span class="error"><?php if(isset($err['password'])) echo $err['password'] . "<br>"; ?></span>
            <input type="password" name="password" placeholder="Enter Password">
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <!-- Login form ends here -->

        
    </div>
</body>
</html>
