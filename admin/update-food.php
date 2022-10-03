<?php
// echo "update food"; for checking purpose
include('reusable_part/menu.php');
?>
<?php
//check whether id set or not
if (isset($_GET['id'])) {

    //get all details
    $id = $_GET['id'];

    //create sql query to get the selected food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //execute thre query
    $row2 = mysqli_fetch_assoc($res2);

    //get the individual value of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {

    //redirect to manage food
    header("locaion:" . SITEURL . 'admin/manage-food.php');
}

?>
<div class="main-content">
    <div class="wrapper">
        <h3>Update Food</h3>

        <br><br>


        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" id="" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description :</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price :</td>
                    <td>
                        <input type="number" name="price" id="" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current image: :</td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //image not availble
                            echo " <div class='error'> Image is Not Availble </div> ";
                        } else {
                            //image is availble
                        ?>
                            <img name="image_name" src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New image: :</td>
                    <td><input type="file" name="image" id=""></td>
                </tr>


                <tr>
                    <td>Category :</td>
                    <td>
                        <select name="category_id" id="">

                            <?php
                            //create sql query for show a categories if they only active
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            //execute the query
                            $res = mysqli_query($conn, $sql);

                            //count the row if = to active
                            $count = mysqli_num_rows($res);

                            //if active category  availble or not
                            if ($count > 0) {

                                //category available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];


                                    // echo" <option value='$category_id'>$category_title</option> ";
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            }  ?> value="<?php echo $category_id ?>"><?php echo $category_title ?></option>
                            <?php
                                }
                            } else {

                                //category not availble
                                echo " <option value='0'>Category is not availbe</option> ";
                            }

                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured :</td>
                    <td>
                        <input <?php if ($featured == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="featured" id="" value="Yes">Yes
                        <input <?php if ($featured == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="featured" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active :</td>
                    <td>
                        <input <?php if ($active == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="active" id="" value="Yes">Yes
                        <input <?php if ($active == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="active" id="" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>
        <?php
        //check whether btn click or not
        if (isset($_POST['submit'])) {
            // echo "clicked";checking purpose

            //get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category_id'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //upload the image if is selected

            //check whether upload btn clicked or not
            if (isset($_FILES['image']['name'])) {
                //upload btn clicked
                $image_name = $_FILES['image']['name'];

                //check whether availble or not
                if ($image_name != "") {
                    //image is avaiable
                    //rename image
                    //get the image extention
                    $temp = explode('.', $image_name);
                    $ext = end($temp);

                    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;

                    //get the source path and destiation path
                    $src_path = $_FILES['image']['tmp_name']; //source path
                    $des_path = "../images/food/" . $image_name; //destination path

                    //upload the image
                    $upload = move_uploaded_file($src_path, $des_path);

                    //check whether image is uploaded or not
                    if ($upload == false) {

                        //failed to upload
                        $_SESSION['upload'] = " <div class = 'error'>Failed To Upload New Image</div> ";

                        //redirect to manage-food 
                        header("location:" . SITEURL . 'admin/manage-food.php');

                        //stop the process beacuse image was not uploaded we dont need to other data save the database
                        die();
                    }

                    //removew the current image if available
                    //remove the image if new image is uploaded and current image exists
                    if ($current_image != "") {
                        echo $current_image;
                        //current image is avaible
                        //remove the image
                        $path = "../images/food/" . $current_image;
                        $remove = unlink($path);

                        //check whether image is successfully remove or not

                        if ($remove == false) {

                            //failed to remove current image
                            $_SESSION['remove-failed'] = " <div class='error'>Failed To Remove Current Image</div> ";

                            //redirect to manage food page
                            //header("location:" . SITEURL . 'admin/manage-food.php');

                            //stop the process
                            die();
                        }
                    }
                } else {
                    $image_name = $current_image; //default image when image is not selected 
                }
            } else {

                $image_name = $current_image; //default image when btn is not clicked
            }

            //update the food in database
            $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id  = '$category', 
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                    ";
            //execute the sql query
            $res3 = mysqli_query($conn, $sql3);

            //check whether query executed or not
            if ($res3 == true) {
                //query is executed and food updated
                $_SESSION['update'] = " <div class='success'> Food Upadated successfull </div> ";
                //redirect manage-food page
                header("location:" . SITEURL . 'admin/manage-food.php');
            } else {
                //query is not executed and food not updated
                $_SESSION['update'] = " <div class='error'> Food Upadated Unsuccessfull </div> ";
                //redirect manage-food page
                header("location:" . SITEURL . 'admin/manage-food.php');
            }
        }

        ?>
    </div>
</div>










<?php include('reusable_part/footer.php'); ?>