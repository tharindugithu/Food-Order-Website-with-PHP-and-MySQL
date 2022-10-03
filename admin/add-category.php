<?php include('reusable_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h3>Add Category</h3>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) { //add-category check success or not

            echo $_SESSION['add']; //display message
            unset($_SESSION['add']); //removing session message
        }

        if (isset($_SESSION['upload'])) { //upload-image check success or not

            echo $_SESSION['upload']; //display message
            unset($_SESSION['upload']); //removing session message
        }

        ?>
        <br><br>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title :</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Your Category title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image" id="">
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
                        <input type="radio" name="active" value="Yes" id="">Yes
                        <input type="radio" name="active" value="No" id="">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" value="Add Category" name="submit" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
//check whether submit btn click or not
if (isset($_POST['submit'])) {

    // echo "clicked";

    //get the value from category form
    $title = $_POST['title'];

    //for radio input we need to check whether the btn is selected or not
    if (isset($_POST['featured'])) {

        //get the value from the form
        $featured = $_POST['featured'];
    } else {

        //set the default value
        $featured = "No";
    }





    //for radio input we need to check whether the btn is selected or not
    if (isset($_POST['active'])) {

        //get the value from the form
        $active = $_POST['active'];
    } else {

        //set the default value
        $active = "No";
    }


    ///check whether image selected or not and set the value for image name accoridingly
    // print_r($_FILES['image']); //print_r for print for array type of data
    // die();break the code here

    if (isset($_FILES['image']['name'])) {

        //upload the image
        //to upload the image we need image name ,source and destination path

        $image_name = $_FILES['image']['name'];

        //upload image only if image selected
        if ($image_name != "") {

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

                //redirect to the add category page
                header("location:" . SITEURL . 'admin/add-category.php');

                //stop the process because image not uploded to db then we don need to pass other detail in database
                die();
            }
        }
    } else {

        //dont upload the image and the image_name value as blank
        $image_name = "";
    }

    //create sql query to insert category into database

    $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name ='$image_name',
                    featured='$featured',
                    active='$active'  
            ";

    //execute the query and save in database
    $res = mysqli_query($conn, $sql);



    //check whether query executed or not 
    if ($res == true) {

        //query executed and category added
        $_SESSION['add'] = " <div class='success'>Category added Successfully</div> ";

        //redirect to manage category page
        header("location:" . SITEURL . 'admin/manage-category.php');
    } else {
        //fail add category
        $_SESSION['add'] = " <div class='error'>Category added Unsuccessfully</div> ";

        //redirect to manage category page
        header("location:" . SITEURL . 'admin/add-category.php');
    }
}

?>

<?php include('reusable_part/footer.php'); ?>