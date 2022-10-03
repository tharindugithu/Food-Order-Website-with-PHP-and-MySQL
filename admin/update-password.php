<?php include('reusable_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h3>Change Password</h3>
        <?php
        $id = $_GET['id'];
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password :</td>
                    <td>
                        <input type="password" name="current_password" id="" placeholder="Current password">
                    </td>
                </tr>

                <tr>
                    <td>New Password :</td>
                    <td>
                        <input type="password" name="new_password" id="" placeholder="New Password">
                    </td>
                </tr>


                <tr>
                    <td>Conform Password :</td>
                    <td>
                        <input type="password" name="conform_password" id="" placeholder="Conform Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input class="btn-secondary" type="submit" name="submit" value="Change Password">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>


<?php
//check whethe submit butn click or not
if (isset($_POST['submit'])) {
    //btn clicked
    // echo "btn clicked";
    //get the data from form
    $id = $_POST['id'];
    $c_password = md5($_POST['current_password']);
    $n_password = md5($_POST['new_password']);
    $con_password = md5($_POST['conform_password']);

    //check whether the user with current id and password exits or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$c_password'"; //password is varchar or string value thats why we need to single coats['']

    //execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {

        //check whether data is available
        $count = mysqli_num_rows($res);

        if ($count == 1) {

            // user exits and password can be changed
            // echo "User is exit"
            //check whether new password and conform password match or not

            if ($n_password == $con_password) {

                //update password
                // echo "password match";
                $sql2 = "UPDATE tbl_admin SET
                        password = 'n_password'
                        WHERE id=$id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //query execute or not
                if ($res2 == true) {

                    //display the success message
                    $_SESSION['changed-pwd'] =  "<div class ='success'>Password Change Successfully</div>";

                    //redirect to manage-admin.php
                    header("location:" . SITEURL . "admin/manage-admin.php");
                } else {

                    //display the success message
                    $_SESSION['changed-pwd'] =  "<div class ='error'>Password Change UnSuccessfully</div>";

                    //redirect to manage-admin.php
                    header("location:" . SITEURL . "admin/manage-admin.php");
                }
            } else {

                //redirect to manage admin page with error
                $_SESSION['pwd-not-match'] =  "<div class ='error'>Password did not match</div>";
                header("location:" . SITEURL . "admin/manage-admin.php");
            }
        } else {

            //user does not exits and cant change password
            $_SESSION['user-not-found'] = "<div class ='error'>User not found</div>";

            //redirec to manag-admin.php
            header("location:" . SITEURL . "admin/manage-admin.php");
        }
    }



    //change password if all above is true

} else {
}

?>

<?php include('reusable_part/footer.php'); ?>