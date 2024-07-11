<?php
include('config/constants.php');

//check login status
if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) {
    header("location: user-dashboard.php");
    exit();
}

// Initialize error array
$err = [];

// Check whether the submit button is clicked or not
if(isset($_POST['submit'])) {
    // Get data from login form and check if empty
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
        // SQL to check whether user with username exists or not
        $sql = "SELECT * FROM tbl_users WHERE username='$username'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $row = mysqli_fetch_assoc($res);
            if ($row) {
                // Verify password
                if (password_verify($password, $row['password'])) {
                    // Password matches, proceed with login
                    $_SESSION['login'] = "Login Successful";
                    $_SESSION['user'] = $username;
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    $_SESSION['user_logged_in'] = true; // Set session variable for logged in status
                    // Redirect to home page 
                    header('Location: ' . SITEURL . 'user-dashboard.php');
                    exit;
                } else {
                    // Password does not match
                    $_SESSION['login'] = "<span class='error text-center'>Username or Password didn't Match</span>";
                    // Redirect to login page 
                    header('Location: ' . SITEURL . 'login.php');
                    exit;
                }
            } else {
                // User not found
                $_SESSION['login'] = "<span class='error text-center'>Username or Password didn't Match</span>";
                // Redirect to login page 
                header('Location: ' . SITEURL . 'login.php');
                exit;
            }
        } else {
            // SQL query execution failed
            $_SESSION['login'] = "Database error: Unable to execute query.";
            header('Location: ' . SITEURL . 'login.php');
            exit;
        }
    }
}
?>

<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    
    <div class="login">
        <h1 class="text-center">Login</h1>
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
            <input type="text" name="username" placeholder="Enter Username" value="<?php if(isset($username)) echo $username; ?>">
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
