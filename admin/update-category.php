<?php include('reusable_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h3>Update Category</h3>

        <br><br>

        <?php

        //check whether id set or not
        if (isset($_GET['id'])) {

            //get id and al other details
            // echo "ok";
            $id = $_GET['id'];

            //create sql query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows check whether id valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {

                //get all the data 
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {

                //redirect to manage category with message
                $_SESSION['no-category-found'] = " <div class='error'>Category not found</div> ";

                //redirect
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
        } else {

            //redirect to manage category 
            header("location:" . SITEURL . 'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image :</td>
                    <td>
                        <?php
                        if ($current_image != "") {

                            //display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="" srcset="" width="100px">
                        <?php

                        } else {
                            echo " <div class='error'>Image not added</div> ";
                        }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image</td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>

                <tr>
                    <td>Featured :</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" id="" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active :</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" id="" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    // echo "clicked";
    //get all the values from form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //updating new image if selected
    //check whether image selected or not
    if (isset($_FILES['image']['name'])) {

        //get the image details
        $image_name = $_FILES['image']['name'];

        //check whether image name available or not
        if ($image_name != "") {
            //image is available
            //upload the new image


            //auto rename image
            //get the extetion our image(jpg,png) eg-: food.jpg
            $ext = end(explode('.', $image_name)); //get tje end dot value

            //rename the image
            $image_name = "Food_Category_" . rand(000, 900) . '.' . $ext; //eg. Food_Category_453.jpg

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/" . $image_name;


            //we can now upload the image 
            $upload = move_uploaded_file($source_path, $destination_path);

            //check whether image uploaded or not
            //and if the image is not uploaded then we will stop the process and redirect with error message

            if ($upload == false) {

                //set session error message
                $_SESSION['upload'] = " <div class = 'error'>Failed to upload image </div> ";

                //redirect to the manage category page
                header("location:" . SITEURL . 'admin/manage-category.php');

                //stop the process because image not uploded to db then we don need to pass other detail in database
                die();
            }

            //remove the current image if image is available
            if ($current_image != "") {
                $remove_path = "../images/category/" . $current_image;

                //remove the image
                $remove = unlink($remove_path);

                //check whether image remove or not
                //if fail to remove then display message and stop the process

                if ($remove == false) {

                    //fail to remove image
                    $_SESSION['failed-remove'] = " <div class='error'>Failed to remove image </div> ";

                    //redirect manage category page
                    header("location:" . SITEURL . 'admin/manage-category.php');

                    die(); //for stop the process

                }
            }
        } else {

            //set current image name as image_name
            $image_name = $current_image;
        }
    } else {

        //set current image name as image_name
        $image_name = $current_image;
    }

    //update the data base
    $sql2 = "UPDATE tbl_category SET 
            title ='$title',
            image_name='$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id

            ";

    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //check whether query execute or not
    if ($res2 == true) {

        //categery added
        $_SESSION['update'] = " <div class='success'>Category Upadated successfully</div> ";
        //redirect to manage category page
        header("location:" . SITEURL . 'admin/manage-category.php');
    } else {

        //failed to add category
        $_SESSION['update'] = " <div class='error'>Category Update unsuccessfully</div> ";
        //redirect to manage category page
        header("location:" . SITEURL . 'admin/manage-category.php');
    }

    //redirect to manage category with message

}

?>

<?php include('reusable_part/footer.php'); ?>