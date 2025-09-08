<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");

requireAdminLogin();
?>
<!-- page contins the list of competition -->
<div class="container mt-5">
  <h2 class="mb-4">Competitions</h2>

  <?php
  $q = "SELECT id, title, description FROM competitions ORDER BY date DESC, time DESC";
  $result =  mysqli_query($conn, $q);

  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        echo "<div class='card mb-4'>
          <div class='card-body'>
            <h4 class='card-title'>" . htmlspecialchars($row['title']) . "</h4>
            <p class='card-text'>" . htmlspecialchars($row['description']) . "</p>
          </div>
          <div class='card-footer'>
        
          <a href='/college-competition-portal/admin/competition-form.php/?competitionID=" . htmlspecialchars($row['id']) . "' class='btn btn-primary' >Update</a>
          <a href='/college-competition-portal/admin/view-participants.php/?competitionID=" . htmlspecialchars($row['id']) . "' class='btn btn-primary' >View participants</a>
         
          </div>
        </div>";
      }
    } else {
      echo "<div class='alert alert-info'>No competitions found , Click the Add New Competition button to add new competition.</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Failed to fetch records: " . mysqli_error($conn) . "</div>";
  }
  ?>

  <?php
  include("../includes/footer.php");
  ?>