<?php include('reusable_part/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h3>Add Food</h3>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) { //upload-image check success or not

            echo $_SESSION['upload']; //display message
            unset($_SESSION['upload']); //removing session message
        }

        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" id="" placeholder="Title of Food">
                    </td>
                </tr>

                <tr>
                    <td>Description :</td>
                    <td>
                        <textarea name="description" cols='30' rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price :</td>
                    <td>
                        <input type="number" name="price" id="">
                    </td>
                </tr>

                <tr>
                    <td>Select Image :</td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>

                <tr>
                    <td>Category :</td>
                    <td>
                        <select name="category" id="">

                            <?php
                            //create php code to display categories from database
                            //create sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            //execute the query
                            $res = mysqli_query($conn, $sql);

                            //count the rows to check whether we will have categories or not
                            $count = mysqli_num_rows($res);

                            //if count is greate thhan 0 we have categories else we dont have categories
                            if ($count > 0) {

                                //we have categories

                                while ($row = mysqli_fetch_assoc($res)) {

                                    //get the details of the categories
                                    $id = $row['id'];
                                    $title = $row['title'];

                            ?>

                                    <option value="<?php echo $id ?>"><?php echo $title ?></option>

                                <?php
                                }
                            } else {

                                //we dont have categories
                                ?>

                                <option value="0">No Category Found</option>

                            <?php
                            }
                            //display drop down
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured :</td>
                    <td>
                        <input type="radio" name="featured" id="" value="Yes">Yes
                        <input type="radio" name="featured" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active :</td>
                    <td>
                        <input type="radio" name="active" id="" value="Yes">Yes
                        <input type="radio" name="active" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        //check whether submit btn click or not
        if (isset($_POST['submit'])) {
            //add food database
            //echo " clicked";

            //get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            //check whether radio btn for featured and active are checked or not
            if (isset($_POST['featured'])) {

                $featured = $_POST['featured'];
            } else {

                //set for default value
                $featured = "No";
            }

            if (isset($_POST['active'])) {

                $active = $_POST['active'];
            } else {

                //set for default value
                $active = "No";
            }

            //upload the image if selected
            //check whether the select image is clicked or not and upload the image oly if the image is selected
            if (isset($_FILES['image']['name'])) { //check image chhose btn click or not
                //get the details of the selected image

                $image_name =  $_FILES['image']['name'];

                //check whether image is selected or not and uplod image if only selected

                if ($image_name != "") {

                    //image is selected
                    //rename the image
                    //get the extention of selected image(jpg,png,jpeg)
                    $temp = explode('.', $image_name);
                    $ext = end($temp);
                    // $ext = end(explode('.', $image_name)); //get tje end dot value
                    //create new name for image
                    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext; //new image name mayber=>'Food-Name-3434.jpg'

                    //upload the image
                    //get the src path and destination path
                    //source path is current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //destination path for the image uploaded
                    $dst = "../images/food/" . $image_name;

                    //finally upload the food image
                    $upload = move_uploaded_file($src, $dst);

                    //check whether image upload or not
                    if ($upload == false) {
                        //failed to upload image
                        //redirect to add food page
                        $_SESSION['uplaod'] = " <div class='error'>Failed to upload the image</div> ";
                        //redirect
                        header("location:" . SITEURL . 'admin/add-food.php');
                        //stop the process
                        die();
                    }
                } else {
                }
            } else {

                //setting image default value is blank
                $image_name = "";
            }
            //insert into database

            //createsql query to save add food
            //for numeric value not need pass value insie quotes '' but for string value it is compulsory to add quotes ''

            $sql2 = "INSERT INTO tbl_food SET
                     title = '$title',
                     description = '$description',
                     price = $price,
                     image_name ='$image_name',
                     category_id =$category,
                     featured = '$featured',
                     active = '$active'
                     ";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //check whether data inset is not
            if ($res2 == true) {

                //data inserted sucessfully
                $_SESSION['add'] = " <div class='success'>Food Added Successfull</div> ";

                //redirect manage-food.php
                header("location:" . SITEURL . 'admin/manage-food.php');
            } else {
                //esle fail to insert data
                $_SESSION['add'] = " <div class='error'>Food Added Unsuccessfull</div> ";

                //redirect manage-food.php
                header("location:" . SITEURL . 'admin/manage-food.php');
            }

            //redirect with message to manage food page
        }

        ?>
    </div>
</div>



<?php
//echo "fdsfd"; //check successfull link or not

?>
<?php include('reusable_part/footer.php'); ?>