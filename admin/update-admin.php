<?php include('partials/menu.php'); ?>
<?php
        // Initialize error array
        $err = [];

        // Check if ID is passed via GET
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Create SQL query to get admin details
            $sql = "SELECT * FROM tbl_admin WHERE id=?";
            
            // Prepare statement
            $stmt = mysqli_prepare($conn, $sql);
            
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            // Execute statement
            mysqli_stmt_execute($stmt);
            
            // Get result
            $res = mysqli_stmt_get_result($stmt);

            // Check if query executed successfully
            if ($res) {
                // Check if admin data is available
                if (mysqli_num_rows($res) == 1) {
                    // Fetch admin details
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    // Redirect if admin not found
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    exit; // Make sure to exit after header redirect
                }
            } else {
                // Handle query execution error
                die("Query execution failed: " . mysqli_error($conn));
            }
        } else {
            // Redirect if ID is not provided
            header('location:'.SITEURL.'admin/manage-admin.php');
            exit; // Make sure to exit after header redirect
        }
?>

<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    // Validate and sanitize input
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Validation for full name
    if (empty($full_name)) {
        $err['full_name'] = "Enter Full Name";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $full_name)) {
        $err['full_name'] = "Full Name must only contain letters and spaces";
    }

    // Validation for username
    if (empty($username)) {
        $err['username'] = "Enter Username";
    } elseif (!preg_match("/^[a-zA-Z0-9]{4,29}$/", $username)) {
        $err['username'] = "Username must be alphanumeric and between 4 to 29 characters";
    }

    // Debug: Display $err array for debugging

    // If no errors, proceed with update
    if (empty($err)) {
        // Create SQL query to update admin
        $sql = "UPDATE tbl_admin SET full_name=?, username=? WHERE id=?";
        
        // Prepare statement
        $stmt = mysqli_prepare($conn, $sql);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssi", $full_name, $username, $id);
        
        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['update'] = "Admin Updated Successfully";
            header('location:'.SITEURL.'admin/manage-admin.php');
            exit; // Make sure to exit after header redirect
        } else {
            $_SESSION['update'] = "Failed to update Admin";
            header('location:'.SITEURL.'admin/manage-admin.php');
            exit; // Make sure to exit after header redirect
        }
    }
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr><td colspan="7"><span class="error"><?php if(isset($err['full_name'])) echo $err['full_name']; ?></span></td></tr>
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>">
                    </td>
                </tr>
                <tr><td colspan="7"><span class="error"><?php if(isset($err['username'])) echo $err['username']; ?></span></td></tr>
                
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>
