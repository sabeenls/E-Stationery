<?php include('partials/menu.php');?>
        <!--main content section starts here-->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>
                <br>

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //displaying session message
                        unset($_SESSION['add']); //removing session message
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['password-not-match']))
                    {
                        echo $_SESSION['password-not-match'];
                        unset($_SESSION['password-not-match']);
                    }

                    if(isset($_SESSION['change-password']))
                    {
                        echo $_SESSION['change-password'];
                        unset($_SESSION['change-password']);
                    }

                    
                
                ?>
                <br>
                <br>
                <!-- button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br>
                <br>
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //query to get all admin
                        $sql = "SELECT * FROM tbl_admin";
                        //execute query
                        $res = mysqli_query($conn, $sql);
                        //check wether the query executed or not
                        if($res==TRUE)
                        {
                            //count rows to check data in database 
                            $count = mysqli_num_rows($res); // function to get all the rows in db

                            $sn=1; //CREATE A VARIABLE and assign the value
                            //check the no. opf rows
                            if($count>0)
                            {
                                //data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //using while loop to get all the data from database
                                    //and while loop willl run as long as data in data base

                                    //get individyual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //display value in talble
                    ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    
                                    <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                        <!-- <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-secondary1">Delete Admin</a>   -->
                                    </td>
                                </tr>

                    <?php
                                }
                            }
                                else
                             {
                                 //no data in database
                             }

                        }
                    ?>



                </table>

                
            </div>
            
        </div>

        
         <!--main content section ends here-->
<?php include('partials/footer.php')?>