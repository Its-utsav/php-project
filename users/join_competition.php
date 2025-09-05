<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();
$competitionID = $_GET['competitionID'] ?? "";
if (!$competitionID) {
    redirect("/college-competition-portal/users/competition.php");
}

$q = "INSERT INTO registrations (user_id,competition_id ) VALUES (" . $_SESSION['user_id'] . "," . $competitionID . " )";
$result =  mysqli_query($conn, $q);


if ($result) {
    echo "Register successfully redirect to my competition page";
    redirect("/college-competition-portal/users/my-competition.php");
} else {
    echo "Failed to insert records " . mysqli_error($conn);
}
?>

<?php
include("../includes/footer.php");
?>