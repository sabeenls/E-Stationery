<?php

//include constants.php file here
include('../config/constants.php');

//1 get the id of admin to be deleted
$id = $_GET['id'];
//2 create sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn, $sql);

//check wether the query executed or not
if($res==TRUE)
{
    //query executed sucessfully and admin deleted
    //echo "Admin Deleted";
    //create session variable to display msg
    $_SESSION['delete'] = "Admin Deleted Sucessfully";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

else
{
    //failed to delete admin
    //echo "Admin failed to Deleted";
    $_SESSION['delete'] = "Failed to Admin Deleted. Try Again";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//3 redirect to manage admin page with message sucess or error
?>