<?php include('partials/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Item</h1>

        <br><br>
        <!-- Button to add item -->
        <a href="<?php echo SITEURL; ?>admin/add-item.php" class="btn-primary">Add Item</a>
        <br><br>

        <?php 
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete'])) 
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['unauthorize'])) 
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if(isset($_SESSION['update'])) 
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                // Create SQL query to get all data
                $sql = "SELECT * FROM tbl_items";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count rows to check whether we have items or not
                $count = mysqli_num_rows($res);

                // Create serial number variable and set default value as 1
                $sn = 1;

                if($count > 0) {
                    // We have items in the database
                    // Get items from the database and display
                    while($row = mysqli_fetch_assoc($res)) {
                        // Get values from individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>Rs.<?php echo $price; ?></td>
                            <td>
                                <?php 
                                    // Check whether we have an image or not
                                    if($image_name == "") {
                                        // We do not have an image
                                        echo "<div class='error'>Image not added</div>";
                                    } else {
                                        // We have an image
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/item/<?php echo $image_name; ?>" width="100px">
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>

                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-item.php?id=<?php echo $id; ?>" class="btn-secondary">Update Item</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-item.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?> " class="btn-secondary1">Delete Item</a>  
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // No items added
                    echo "<tr><td colspan='7' class='error'>Item not added yet</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
