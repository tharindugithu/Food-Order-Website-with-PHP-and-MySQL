<?php
include('config/const.php');
// echo "Delete food";
if (isset($_GET['id']) && isset($_GET['image_name'])) {

    //process to delete
    //echo "process to data";

    //get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //check whether the image is availble or not and delete only if availble
    if ($image_name != "") {
        //it has image and remove from that image in folder
        //get the image path
        $path = "../images/food/" . $image_name;

        //remove image file from folder
        $remove = unlink($path);

        //check whether image is successfully remove or not
        if ($remove == false) {

            //failed to remove image
            $_SESSION['upload'] = " <div class='error' >Failed to remove image</div> ";

            //redirect manage-food

            header("location:" . SITEURL . 'admin/manage-food.php');
            //stop the process
            die(); //if we failed to remove image then we dont need to add other data in database

        }
    }

    //remove the image if available
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether query is successfully executed or not
    //delete food from database
    if ($res == true) {
        //food deleted
        $_SESSION['delete'] = " <div class='success'>Food Delete Successfully</div> ";
        //redirect manage food 
        header("location:" . SITEURL . 'admin/manage-food.php');
    } else {
        //food not deleted
        $_SESSION['delete'] = " <div class='error'>Food Delete Unsuccessfully</div> ";
        //redirect manage food 
        header("location:" . SITEURL . 'admin/manage-food.php');
    }


    //redirect to manage food with session message

} else {
    //redirect to manage food page
    header("location:" . SITEURL . 'admin/manage-food.php');
    $_SESSION['unauthorized'] = " <div class='error'>Unathorized Access.</div> ";
}
