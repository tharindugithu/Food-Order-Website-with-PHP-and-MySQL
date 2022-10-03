<?php include('reusable_part/menu.php'); ?>
<div class="main-content ">
    <div class="wrapper">
        <h3>Manage Food</h3>
        <br><br>
        <a href="<?php echo SITEURL ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br>
        <?php

        if (isset($_SESSION['add'])) { //add-image check success or not

            echo $_SESSION['add']; //display message
            unset($_SESSION['add']); //removing session message
        }

        if (isset($_SESSION['unathorized'])) { //unathorized-access check success or not

            echo $_SESSION['unathorized']; //display message
            unset($_SESSION['unathorized']); //removing session message
        }

        if (isset($_SESSION['delete'])) { //delete-image check success or not

            echo $_SESSION['delete']; //display message
            unset($_SESSION['delete']); //removing session message
        }

        if (isset($_SESSION['upload'])) { //upload-image check success or not

            echo $_SESSION['upload']; //display message
            unset($_SESSION['upload']); //removing session message
        }

        if (isset($_SESSION['remove-failed'])) { //remove-failed-image check success or not

            echo $_SESSION['remove-failed']; //display message
            unset($_SESSION['remove-failed']); //removing session message
        }

        if (isset($_SESSION['update'])) { //update check success or not

            echo $_SESSION['update']; //display message
            unset($_SESSION['update']); //removing session message
        }

        ?>
        <table class="tbl-full">
            <tr>
                <th>Serial Number </th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th class="text-center">Action</th>
            </tr>
            <?php
            //create sql query to get all the food 
            $sql = "SELECT * FROM tbl_food";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count rows to check whether we have foods or not
            $count = mysqli_num_rows($res);
            $increment = 1; //create serial number variable and set default values as 1
            if ($count > 0) {
                //we have food in database
                //get the foods from database and display
                while ($row = mysqli_fetch_assoc($res)) {

                    //get the value individual columns
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>
                    <tr>
                        <td><?php echo $increment ?></td>
                        <td><?php echo $title ?></td>
                        <td>$<?php echo $price ?></td>
                        <td>
                            <?php
                            //check whether image have or have not
                            if ($image_name == "") {
                                //we do have image,and display error message
                                echo " <div class='error'>Image not Added</div> ";
                            } else {
                                //we have image and display the image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="" width="100px">
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $featured ?></td>
                        <td><?php echo $active ?></td>
                        <td class="text-center">
                            <a href="<?php echo SITEURL ?>admin/delete-food.php?id=<?php echo $id ?>&image_name=<?php echo $image_name ?>" class="btn-secondary">Delete food</a>
                            <a href="<?php echo SITEURL ?>admin/update-food.php?id=<?php echo $id ?>&image_name=<?php echo $image_name ?>" class="btn-danger">Update food</a>
                        </td>
                    </tr>
            <?php
                    $increment++;
                }
            } else {
                //foood not added in databse
                echo " <tr>
                    <td colspan='7' class='error'>Food Not Added Yet.</td>
                </tr> ";
            }

            ?>

            <!-- <tr>
                <td>Serial Number</td>
                <td>FullName</td>
                <td>UserName</td>
                <td><a href="#" class="btn-secondary">Delete Admin</a>
                    <a href="#" class="btn-danger">Update Admin</a>
                </td>
            </tr>
            <tr>
                <td>Serial Number</td>
                <td>FullName</td>
                <td>UserName</td>
                <td><a href="#" class="btn-secondary">Delete Admin</a>
                    <a href="#" class="btn-danger">Update Admin</a>
                </td>
            </tr> -->
        </table>
    </div>
</div>

<?php include('reusable_part/footer.php'); ?>