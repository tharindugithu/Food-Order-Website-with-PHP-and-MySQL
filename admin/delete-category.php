<?php
include('config/const.php');
// echo "Delete page";
//check whether the id and image name value is set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {

    //get the value anda delete
    // echo "get the value and delete";
    //get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //first remove the physical image file is available
    if ($image_name != "") {

        //which means image available so remove it
        $path = "../images/category/" . $image_name;

        //remove the image
        $remove = unlink($path);

        //check whether remove is success or not
        if ($remove == false) {
            //if failed to remove image then add error message and we stop the prosses
            $_SESSION['remove'] = " <div class='error'>Fialed to remove image</div> ";
            //redirect ti manage category page
            header("location:" . SITEURL . 'admin/manage-ategory.php');
            //stop the process
            die();
        }
    }

    //delete data from database
    //sql query to delete data from data base 
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the data is delete from database or not
    if ($res == true) {

        //set success message and redirect
        $_SESSION['delete'] = " <div class='success'>Deleted Successfuly</div> ";
        //redirect manage-category
        header("location:" . SITEURL . 'admin/manage-category.php');
    } else {

        //set fail message and redirect
        $_SESSION['delete'] = " <div class='error'>Deleted UnSuccessfuly</div> ";
        //redirect manage-category
        header("location:" . SITEURL . 'admin/manage-category.php');
    }


    //redirect to manage category page with message

} else {

    //redirect to manage-category page for security purposes
    header("location:" . SITEURL . 'admin/manage-category.php');
}
