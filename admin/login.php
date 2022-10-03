<?php include('config/const.php');

?>
<html>

<head>
    <title>Login System</title>

    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login text-center">
        <h1>Login</h1>

        <br><br>
        <?php

        if (isset($_SESSION['login'])) { //login session

            echo $_SESSION['login']; //display message
            unset($_SESSION['login']); //removing session message
        }

        if (isset($_SESSION['no-login-message'])) { //no-login-message session check user login or not

            echo $_SESSION['no-login-message']; //display message
            unset($_SESSION['no-login-message']); //removing session message
        }

        if (isset($_SESSION['timeout'])) { //timeout session check user login or not

            echo $_SESSION['timeout']; //display message
            unset($_SESSION['timeout']); //removing session message
        }
        ?>
        <br>
        <form action="" method="POST">
            Username :
            <input type="text" name="username" placeholder="Enter Your Username">
            <br><br>
            Password :
            <input type="text" name="password" placeholder="Enter Your Password">
            <br><br>
            <button type="submit" name="submit" class="btn">submit</button>
            <!-- <input type="submit" value="Login" name="submit" class="btn-primary"> -->
        </form>
        <br><br>
        <p>Created By - <a href="#">Tharindu</a></p>
    </div>
</body>

</html>

<?php
//check whether submit btn click or not
if (isset($_POST['submit'])) {
    //process the login

    //get the data from login form
    // $username = $_POST['username'];
    // $password = md5($_POST['password']);

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password =  mysqli_real_escape_string($conn, (md5($_POST['password'])));
    // //sql to check whether the username and password exits or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // //execute the query
    $res = mysqli_query($conn, $sql);

    // //count rows to check wether the user exits or not
    $count = mysqli_num_rows($res);
    echo $count;

    if ($count == 1) {

        //user found and login success
        $_SESSION['login'] = " <div class='success'>Login Successfull</div>";
        $_SESSION['user'] = $username; //to check whether the user logged in or not and logout will unset it
        $_SESSION['login_time'] = time();

        //redirect home page dashbord
        header("location:" . SITEURL . 'admin/');
    } else {

        //no user and login fail
        $_SESSION['login'] = " <div class='error'>Login UnSuccessfull</div>";

        //redirect to login page
        header("location:" . SITEURL . 'admin/login.php');
    }
}



?>