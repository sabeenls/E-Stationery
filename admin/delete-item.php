<?php
include('../config/constants.php');
session_start(); // Start session if not already started

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // process to delete
    // 1. get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // 2. remove the image if it is available
    if ($image_name != "") {
        // it has an image and needs to be removed from the folder
        // get the image path
        $path = "../images/item/" . $image_name;

        // remove image file from folder
        $remove = unlink($path);

        // check whether the image is removed or not
        if ($remove == false) {
            // failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to remove Image file</div>";
            // redirect to add-item page
            header('location:' . SITEURL . 'admin/add-item.php');
            // stop process
            die();
        }
    }

    // 3. delete item from db
    $sql = "DELETE FROM tbl_items WHERE id=$id";
    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // 4. Check whether the query executed or not and set the session message respectively
    if ($res == true) {
        // Item Deleted
        $_SESSION['delete'] = "<div class='success'>Item Deleted Successfully.</div>";
    } else {
        // Failed to Delete Item
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Item.</div>";
    }

    // 5. Redirect to manage items with Session Message
    header('location:' . SITEURL . 'admin/item.php');
} else {
    // unauthorized access
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
    header('location:' . SITEURL . 'admin/item.php');
}
?>
