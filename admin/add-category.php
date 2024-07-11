<?php include('partials/menu.php'); ?>

<?php
    // Check if form is submitted
    if(isset($_POST['submit'])) {
        // Initialize error variables
        $err_title = '';
        $err = 0;

        // Validate and sanitize inputs
        if(isset($_POST['title']) && !empty(trim($_POST['title']))) {
            $title = trim($_POST['title']);
            
            // Check if the title is unique
            $sql_check = "SELECT * FROM tbl_category WHERE title = ?";
            $stmt_check = mysqli_prepare($conn, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "s", $title);
            mysqli_stmt_execute($stmt_check);
            $res_check = mysqli_stmt_get_result($stmt_check);
            if(mysqli_num_rows($res_check) > 0) {
                $err_title = 'Category title already exists';
                $err++;
            }
        } else {
            $err_title = 'Enter title';
            $err++;
        }

        // Handle radio inputs (featured and active)
        $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
        $active = isset($_POST['active']) ? $_POST['active'] : "No";

        // Check if an image is uploaded
        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];

            // Check if image is selected and process upload
            if(!empty($image_name)) {
                // Get file extension
                $img_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                // Generate unique name for the image
                $image_name = "Category_" . rand(1000, 9999) . '.' . $img_ext;

                // Upload file
                $upload_dir = "../images/category/";
                $upload_path = $upload_dir . $image_name;

                if(move_uploaded_file($image_tmp, $upload_path)) {
                    // Image uploaded successfully
                } else {
                    // Failed to upload image
                    $_SESSION['upload'] = "Failed to Upload Image";
                    header('location:'.SITEURL.'admin/add-category.php');
                    exit;
                }
            } else {
                // No image selected
                $image_name = "";
                $err++;
            }
        } else {
            // No image selected
            $image_name = "";
            $err++;
        }

        // If no errors, proceed to insert into database
        if($err == 0) {
            // Prepare SQL statement
            $sql = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?)";
            
            // Prepare statement
            $stmt = mysqli_prepare($conn, $sql);
            
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssss", $title, $image_name, $featured, $active);
            
            // Execute statement
            if(mysqli_stmt_execute($stmt)) {
                // Query executed successfully
                $_SESSION['add'] = "Category Added Successfully";
                header('location:'.SITEURL.'admin/category.php');
                exit;
            } else {
                // Failed to execute query
                $_SESSION['add'] = "Failed to Add Category";
                header('location:'.SITEURL.'admin/add-category.php');
                exit;
            }
        }
    }
?>

<div class="main">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                        <span class="error"><?php if(isset($err_title)) echo $err_title; ?></span>
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form ends -->
    </div>
</div>

<?php include('partials/footer.php') ?>
