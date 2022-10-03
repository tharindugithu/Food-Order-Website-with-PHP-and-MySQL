<?php include('reusable_part/menu.php'); ?>
<div class="main-content ">
    <div class="wrapper">
        <h3>Manage Order</h3>
        <br><br>
        <?php

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>
        <br><br>
        <table class="tbl-full">
            <tr>
                <th>Serial Number</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th class="text-center">Action</th>
            </tr>
            <?php
            //get all the orders from database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows
            $count = mysqli_num_rows($res);
            $sn = 1;
            if ($count > 0) {
                //order available
                while ($row = mysqli_fetch_assoc($res)) {
                    //get all the order details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
            ?>
                    <tr>
                        <td><?php echo  $sn; ?></td>
                        <td><?php echo $food; ?></td>
                        <td>$<?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <?php
                            //Ordered,On Delivery,Delivered,Cancelled
                            if ($status == 'Orderded') {

                                echo " <label>$status</label> ";
                            } else if ($status == 'On Delivery') {

                                echo " <label style='color:orange'>$status</label> ";
                            } else if ($status == 'Delivered') {

                                echo " <label style='color:green'>$status</label> ";
                            } else {

                                echo " <label style='color:red'>$status</label> ";
                            }
                            ?>
                        </td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td class="text-center">

                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>
            <?php
                    $sn++;
                }
            } else {
                //order not available
                echo " <div class='error'>Order Not Available</div> ";
            }
            ?>



        </table>
    </div>
</div>
<?php include('reusable_part/footer.php'); ?>