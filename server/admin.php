<?php
require("../config/db.php");
require("../includes/functions.php");
session_start();

const ADMIN_EMAIL = "admin@ccp.com";
const ADMIN_PASSWORD = "abcd@admin";

if (isset($_POST['admin-login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // email -> admin@ccp.com
    // pass -> abcd@admin
    if ($email == ADMIN_EMAIL && $password == ADMIN_PASSWORD) {
        $_SESSION['admin_email'] = ADMIN_EMAIL;
        echo "Logggin successfully";
        redirect("../admin/links.php");
    }
} elseif (isset($_POST['admin-add-competition'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $q = "INSERT INTO competitions (title,description,date,time) VALUES ('$title','$description','$date','$time')";
    $result =  mysqli_query($conn, $q);
    if ($result) {
        echo "Competition created successfully ";
        redirect("../admin/view-competition.php");
    } else {
        echo "Failed to insert records " . mysqli_error($conn);
    }
} elseif (isset($_POST['admin-update-competition'])) {
    var_dump($_POST);
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];


    $q = "UPDATE competitions SET title = '$title', description = '$description',date = '$date' ,time ='$time' WHERE id = $id";
    $result =  mysqli_query($conn, $q);
    if ($result) {
        echo "Competition created successfully ";
        redirect("../admin/view-competition.php");
    } else {
        echo "Failed to update records " . mysqli_error($conn);
    }
} elseif (isset($_GET['logout'])) {
    unset($_SESSION['admin_email']);
    redirect("/college-competition-portal/index.php", 0);
} else {
    echo "somethign went wrong";
}
