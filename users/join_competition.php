<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();
$competitionID = $_GET['competitionID'] ?? "";
if (!$competitionID) {
    redirect("/college-competition-portal/users/competition.php");
}

$userID = (int)$_SESSION['user_id'];
$competitionID = (int)$_GET['competitionID'];
$check_sql = "SELECT id FROM registrations WHERE user_id = $userID AND competition_id = $competitionID";
$check_result = mysqli_query($conn, $check_sql);

if ($check_result && mysqli_num_rows($check_result) > 0) {
    echo "You have already joined this competition.";

    redirect("/college-competition-portal/users/my-competition.php", 1);
    exit();
}

$q = "INSERT INTO registrations (user_id,competition_id ) VALUES (" . $userID . "," . $competitionID . " )";
$result =  mysqli_query($conn, $q);


if ($result) {
    echo "Register successfully redirect to my competition page";
    redirect("/college-competition-portal/users/my-competition.php");
    exit();
} else {
    echo "<div class='alert alert-danger'>Failed to fetch records: " . mysqli_error($conn) . "</div>";
    exit();
}
?>

<?php
include("../includes/footer.php");
?>