<?php

include('partials-front/menu.php');
?>

<?php
// Check if form is submitted
if(isset($_POST['submit'])) {
    // Initialize error array
    $err = [];

    // Validate and sanitize inputs
    $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validation for full name
    if(empty($full_name)) {
        $err['full_name'] = "Enter Full Name";
    } elseif(!preg_match("/^[A-Za-z\s]+$/", $full_name)) {
        $err['full_name'] = "Full Name must only contain letters and spaces";
    }

    // Validation for username
    if(empty($username)) {
        $err['username'] = "Enter Username";
    } elseif(!preg_match("/^[a-zA-Z0-9]{4,29}$/", $username)) {
        $err['username'] = "Username must be alphanumeric and between 4 to 29 characters";
    }

    // Validation for phone
    if(empty($phone)) {
        $err['phone'] = "Contact is required";
    } elseif(!preg_match("/^9[0-9]{9}$/", $phone)) {
        $err['phone'] = "Invalid phone number, must start with 9 and be ten characters long";
    }

    // Validation for email
    if(empty($email)){
        $err['email'] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err['email'] = "Enter a valid email";
    }

    // Validation for address
    if(empty($address)){
        $err['address'] = "Address is required";
    }

    // Validation for password
    if(empty($password)){
        $err['password'] = "Password is required";
    }

    // Check if there are no errors
    if(empty($err)) {
        // Password encryption
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO tbl_users (full_name, username, phone, email, address, password) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $username, $phone, $email, $address, $password_hashed);
        
        // Execute statement
        if(mysqli_stmt_execute($stmt)) {
            // Set success message in session
            $_SESSION['add'] = "Registration Successful";
            // Redirect to login page
            header("location:".SITEURL.'login.php');
            exit;
        } else {
            // Set error message in session
            $_SESSION['add'] = "Failed to register";
            // Redirect back to registration page
            header("location:".SITEURL.'register.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">
        <div class="wrapper">

            <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            ?>

            <form action="" method="POST">
                <fieldset>
                    <legend>Register User</legend>
                    <table class="tbl-30">
                        <tr><td colspan="7"><span class="error"><?php if(isset($err['full_name'])) echo $err['full_name']; ?></span></td></tr>
                        <tr>
                            <td>Full Name:</td>
                            <td>
                                <input type="text" name="full_name" placeholder="Enter your name" value="<?php if(isset($full_name)) echo $full_name; ?>">
                            </td>
                        </tr>

                        <tr><td colspan="7"><span class="error"><?php if(isset($err['username'])) echo $err['username']; ?></span></td></tr>
                        <tr>
                            <td>Username:</td>
                            <td>
                                <input type="text" name="username" placeholder="Your Username" value="<?php if(isset($username)) echo $username; ?>">
                            </td>
                        </tr>
                        <tr><td colspan="7"><span class="error"><?php if(isset($err['phone'])) echo $err['phone']; ?></span></td></tr>
                        <tr>
                            <td>Phone:</td>
                            <td>
                                <input type="text" name="phone" placeholder="Your Phone" value="<?php if(isset($phone)) echo $phone; ?>">
                            </td>
                        </tr>
                        <tr><td colspan="7"><span class="error"><?php if(isset($err['email'])) echo $err['email']; ?></span></td></tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <input type="text" name="email" placeholder="Your Email" value="<?php if(isset($email)) echo $email; ?>">
                            </td>
                        </tr>
                        <tr><td colspan="7"><span class="error"><?php if(isset($err['address'])) echo $err['address']; ?></span></td></tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <input type="text" name="address" placeholder="Your Address" value="<?php if(isset($address)) echo $address; ?>">
                            </td>
                        </tr>
                        <tr><td colspan="7"><span class="error"><?php if(isset($err['password'])) echo $err['password']; ?></span></td></tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" placeholder="Your Password"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Register" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>
    </div>

    <?php include('partials-front/footer.php'); ?>
</body>
</html>
