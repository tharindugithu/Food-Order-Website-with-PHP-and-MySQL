<?php
//include constant php file for site url
include('config/const.php');


//destroy the session
session_destroy(); //unset $_SESSION['user']


// //redirect to login page
header("location:" . SITEURL . 'admin/login.php');
