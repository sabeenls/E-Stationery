<?php include('partials/menu.php'); ?>

<?php
    // Check if ID is set
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // SQL query to fetch item details
        $sql = "SELECT * FROM tbl_items WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        // Fetch item details
        if(mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $current_image = $row['image_name'];
            $current_category = $row['category_id'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            // Item not found, redirect
            $_SESSION['update'] = "<div class='error'>Item not found.</div>";
            header('location:'.SITEURL.'admin/item.php');
            exit;
        }
    } else {
        // Redirect if ID is not set
        header('location:'.SITEURL.'admin/item.php');
        exit;
    }

    // Process form submission
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $current_image = $_POST['current_image'];
        $category = $_POST['category'];
        $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
        $active = isset($_POST['active']) ? $_POST['active'] : 'No';

        // Validate inputs
        $errors = array();

        // Validate title
        if(empty($title)) {
            $errors[] = "Title is required.";
        }

        // Validate description
        if(empty($description)) {
            $errors[] = "Description is required.";
        }

        // Validate price
        if(empty($price) || !is_numeric($price) || $price <= 0) {
            $errors[] = "Price must be a valid number greater than zero.";
        }

        // Validate category
        if($category == '0') {
            $errors[] = "Please select a category.";
        }

        // Handle file upload if new image selected
        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $new_image_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            // Validate uploaded image
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($new_image_name, PATHINFO_EXTENSION));

            if(!in_array($file_extension, $allowed_extensions)) {
                $errors[] = "Invalid file type. Allowed types: jpg, jpeg, png, gif.";
            } else {
                // Move the uploaded file
                $new_image_name = "item_".time().'.'.$file_extension; // Renaming the image file
                $destination_path = "../images/item/".$new_image_name;
                $upload = move_uploaded_file($tmp_name, $destination_path);

                // Check if image is uploaded
                if($upload == false) {
                    $errors[] = "Failed to upload the new image.";
                }

                // Remove the current image if new image is uploaded and available
                if(!empty($current_image)) {
                    $remove_path = "../images/item/".$current_image;
                    $remove = unlink($remove_path);

                    // Check if image is removed
                    if($remove == false) {
                        $errors[] = "Failed to remove the current image.";
                    }
                }
            }
        } else {
            $new_image_name = $current_image; // Retain the current image if new image is not uploaded
        }

        // If there are no errors, proceed with update
        if(empty($errors)) {
            // Update item in database
            $sql_update = "UPDATE tbl_items SET 
                title=?, 
                description=?, 
                price=?, 
                image_name=?, 
                category_id=?, 
                featured=?, 
                active=? 
                WHERE id=?";
            $stmt2 = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt2, "ssdssssi", $title, $description, $price, $new_image_name, $category, $featured, $active, $id);
            $res2 = mysqli_stmt_execute($stmt2);

            // Check if the query executed successfully
            if($res2) {
                $_SESSION['update'] = '<div class="success">Item updated successfully.</div>';
            } else {
                $_SESSION['update'] = '<div class="error">Failed to update item.</div>';
            }

            header('location:'.SITEURL.'admin/item.php');
            exit;
        }
    }
?>

<div class="main">
    <div class="wrapper">
        <h1>Update Item</h1>
        <br><br>

        <?php if(!empty($errors)): ?>
            <div class="error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" >
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo htmlspecialchars($description); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo htmlspecialchars($price); ?>" >
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php if(empty($current_image)) {
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            echo "<img src='".SITEURL."images/item/".$current_image."' width='150px'>";
                        } ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" >
                            <?php
                                // Fetch categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);

                                if(mysqli_num_rows($res) > 0) {
                                    while($row = mysqli_fetch_assoc($res)) {
                                        $category_id = $row['id'];
                                        $category_title = $row['title'];
                                        ?>
                                        <option value="<?php echo $category_id; ?>" <?php if($current_category == $category_id) echo 'selected'; ?>><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                } else {
                                    echo "<option value='0'>No Category Found</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Item" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            // Display session messages if any
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
    </div>
</div
