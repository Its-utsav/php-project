<?php
require("../config/db.php");
require("../includes/functions.php");
session_start();

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirm-password'];
    $gender = $_POST['gender'];

    $q = "INSERT INTO users (name,email,phone_no,password,gender) VALUES ('$name','$email','$phone_no','$password','$gender')";
    $result =  mysqli_query($conn, $q);
    if ($result) {
        echo "Register successfully redirect to login page";
        redirect("../auth/login.php");
    } else {
        echo "Failed to insert records " . mysqli_error($conn);
    }
} else if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_id = -1;

    $q = "SELECT * FROM users WHERE email = '$email' AND password ='$password'";
    $result =  mysqli_query($conn, $q);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $user_id = $row['id'];

            echo "Login successfully redirect to competition page";

            $_SESSION['user_id'] = $user_id;

            redirect("../users/competition.php");
        }
    } else {
        echo "Failed to insert records " . mysqli_error($conn);
    }
} elseif (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    redirect("/college-competition-portal/index.php", 0);
}
