<?php include('reusable_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h3>Add Admin</h3>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) { //checking whether session is set or not
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name :</td>
                    <td><input type="text" name="full_name" id="" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>UserName :</td>
                    <td><input type="text" name="user_name" id="" placeholder="Enter Your UserName"></td>
                </tr>
                <tr>
                    <td>PassWord :</td>
                    <td><input type="password" name="password" id="" placeholder="Enter Your password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('reusable_part/footer.php'); ?>

<?php
//process the value and save it database 
//check submit or not
if (isset($_POST['submit'])) {


    //button click
    //get the data form
    $fname = $_POST['full_name'];
    $uname = $_POST['user_name'];
    $pword = md5($_POST['password']); //password encrypt with md5 



    //sql query save the data in database
    $sql = "INSERT INTO tbl_admin SET
             full_name='$fname', 
             username='$uname',
             password='$pword'
             ";

    //execute query and save data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //check wether the query is executed or not data is inerted or not and display appropriate message
    if ($res == true) {


        //Data inserted
        //echo "Data is inserted";
        //create session variable to display message
        $_SESSION['add'] = " <div class='success'>Admin added successfully</div>";
        //redirect page TO MANAGER ADMIN
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {


        //fail to inserted data
        //echo "Data is not inserted";
        //create session variable to display message
        $_SESSION['add'] = " <div class='error'>Admin added unsuccessfully</div> ";
        //redirect page TO MANAGER ADMIN
        header("location:" . SITEURL . 'admin/add-admin-admin.php');
    }
} else {
    //buttton not click

}
?>