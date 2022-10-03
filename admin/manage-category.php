<?php include('reusable_part/menu.php'); ?>

<div class="main-content ">
    <div class="wrapper">
        <h3>Manage Category</h3>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) { //add-category check success or not

            echo $_SESSION['add']; //display message
            unset($_SESSION['add']); //removing session message
        }

        if (isset($_SESSION['remove'])) { //remove-category check success or not

            echo $_SESSION['remove']; //display message
            unset($_SESSION['remove']); //removing session message
        }

        if (isset($_SESSION['delete'])) { //delete-category check success or not

            echo $_SESSION['delete']; //display message
            unset($_SESSION['delete']); //removing session message
        }

        if (isset($_SESSION['no-category-found'])) { //no-category-found-category check success or not

            echo $_SESSION['no-category-found']; //display message
            unset($_SESSION['no-category-found']); //removing session message
        }

        if (isset($_SESSION['update'])) { //update-category check success or not

            echo $_SESSION['update']; //display message
            unset($_SESSION['update']); //removing session message
        }

        if (isset($_SESSION['upload'])) { //upload-image (update category) check success or not

            echo $_SESSION['upload']; //display message
            unset($_SESSION['upload']); //removing session message
        }

        if (isset($_SESSION['failed-remove'])) { //failed-remove-image (update category) check success or not

            echo $_SESSION['failed-remove']; //display message
            unset($_SESSION['failed-remove']); //removing session message
        }



        ?>
        <br><br>
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <!-- or use below code line both are same -->
        <!-- <a href="add-category.php" class="btn-primary">Add Category</a> -->
        <br><br>
        <table class="tbl-full">

            <tr>
                <th>Serial Number</th>
                <th>Title</th>
                <th></th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>

            </tr>

            <?php
            //query to get all categories in database
            $sql = "SELECT * FROM tbl_category";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows
            $count = mysqli_num_rows($res);
            $increment = 1;
            //check whether we hava data in database
            if ($count > 0) {
                //we hava data
                //get the data and display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>
                    <tr>
                        <td><?php echo $increment; ?></td>
                        <td>
                            <?php echo $title; ?>
                        <td>
                        <td>
                            <?php
                            //check whether image available or not
                            if ($image_name != "") {
                                //Display the image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name ?>" width="100px">
                            <?php
                            } else {
                                //Display the message
                                echo " <div class='error'>No image aded</div> ";
                            }

                            // echo $image_name; 
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id ?>&image_name=<?php echo $image_name ?> " class='btn-secondary'>Delete Category</a>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id ?>" class="btn-danger">Update Category</a>
                        </td>

                    </tr>


                <?php
                    $increment++;
                }
            } else {
                //we have no data
                //we will display the message inside table
                ?>
                <!-- break the php code -->
                <tr>
                    <td colspan="6">
                        <div class="error">No Category</div>
                    </td>
                </tr>

            <?php

            }

            ?>




            <!-- dummy data -->
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