<?php

//athorization -acess control
//check whether user lgged in or not 
if (!isset($_SESSION['user'])) //if user session is not set
{
    //user is not logged in
    //redirect to login page with error message
    $_SESSION['no-login-message'] = " <div class='error' >Please logged in access admin panel</div>";

    //redirect login page
    header("location:" . SITEURL . "admin/login.php");
}
