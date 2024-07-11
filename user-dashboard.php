<?php include('partials-front/menu.php'); ?>
<!--main content section starts here-->
<div class="main">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <?php 
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br>

        <div class="col-4 text-center">
            <?php
            $user_id = $_SESSION['user_id'];
            //sql query
            $sql = "SELECT * FROM tbl_order WHERE uid = $user_id";
            //execute query
            $res = mysqli_query($conn, $sql);
            //count
            $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1>
            Total Orders
        </div>

        <div class="clearfix"></div>

        <table class="tbl-full">
            <tr>
                <th>SN</th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            <?php 
            if ($res && mysqli_num_rows($res) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $item = $row['item'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $item; ?></td>
                        <td> Rs.<?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td> Rs.<?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td><?php echo $status; ?></td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">No orders found.</td>
                </tr>
            <?php
            }
            ?>
        </table>

    </div>
</div>
<!--main content section ends here-->
<?php include('partials-front/footer.php'); ?>
