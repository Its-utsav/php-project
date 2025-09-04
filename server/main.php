<?php
require("../config/db.php");
require("../includes/functions.php");


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
}
