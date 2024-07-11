<?php include('partials/menu.php'); ?>

<?php 

// Initialize error array
$err = [];

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Validate and sanitize inputs
    $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';

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

    if(empty($_POST['password'])) {
        $err['password'] = "Enter Password";
    }

    // Check if there are no errors
    if(empty($err)) {
        // Password encryption using password_hash()
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES (?, ?, ?)";

        // Prepare statement
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters and execute
            mysqli_stmt_bind_param($stmt, "sss", $full_name, $username, $password);

            // Execute statement
            if(mysqli_stmt_execute($stmt)) {
                // Set success message in session
                $_SESSION['add'] = "Admin Added Successfully";
                // Redirect to manage-admin page
                header("location:".SITEURL.'admin/manage-admin.php');
                exit;
            } else {
                // Set error message in session
                $_SESSION['add'] = "Failed to add Admin";
                // Redirect back to add-admin page
                header("location:".SITEURL.'admin/add-admin.php');
                exit;
            }
        } else {
            // SQL statement preparation failed
            $_SESSION['add'] = "Database error: Unable to prepare statement.";
            header("location:".SITEURL.'admin/add-admin.php');
            exit;
        }
    }
}
?>

<div class="main">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>

        <?php
        if(isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr><td colspan="2"><span class="error"><?php if(isset($err['full_name'])) echo $err['full_name']; ?></span></td></tr>
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name" value="<?php if(isset($full_name)) echo htmlspecialchars($full_name); ?>">
                    </td>
                </tr>

                <tr><td colspan="2"><span class="error"><?php if(isset($err['username'])) echo $err['username']; ?></span></td></tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username" value="<?php if(isset($username)) echo htmlspecialchars($username); ?>">
                    </td>
                </tr>

                <tr><td colspan="2"><span class="error"><?php if(isset($err['password'])) echo $err['password']; ?></span></td></tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
