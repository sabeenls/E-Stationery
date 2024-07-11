<?php
    //include constants file
    include('../config/constants.php');
    //echo "Delete Page";
    //check wether the id & image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get value and delete
        //echo "get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove physical image file if available 
        if($image_name !== "")

        {
            //image is available, so remove it
            $path = "../images/category/".$image_name;

            //remove the image
            $remove = unlink($path);

            //if fail to remove image then add error msg and stop process
            if($remove==false)
            {
                //setr sessio msg
                $_SESSION['remove'] = "Failed to remove category image";


                //redirect to category page
                header('location:'.SITEURL.'admin/category.php');

                //stop process
                die();
            }
        }
        //delete datqa from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check wether the data is deleted or not
        if($res==true)
        {
            //set sucess msg and redirect
            $_SESSION['delete'] = "Category deleted sucessfully";
            
            header('location:'.SITEURL.'admin/category.php');
            
        }
        else
        {
            //ste failed msg and redirect
            $_SESSION['delete'] = "Failed to delete Category";
            
            header('location:'.SITEURL.'admin/category.php');
        }
  

    }

    else
    {
        //redirect to cateory page
        header('location:'.SITEURL.'admin/category.php');

    }
?>