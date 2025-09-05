<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();
?>
<!-- page contins the list of competition -->
<div class=" mt-5">
  <h2 class="mb-4">Competitions</h2>

  <?php
  $q = "SELECT * FROM competitions";
  $result =  mysqli_query($conn, $q);

  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        echo "<div class='card mb-4'>
          <div class='card-body'>
            <h4 class='card-title'>" . $row['title'] . "</h4>
            <p class='card-text'>" . $row['description'] . "</p>
          </div>
          <div class='card-footer'>
           <a href='/college-competition-portal/users/join_competition.php/?competitionID=" . $row['id'] . "' class='btn btn-primary' >Join</a>
         
          </div>
        </div>";
      }
    }
    //  // see participant
    // <a href='register.html' class='btn btn-primary'>Participate</a>
  } else {
    echo "Failed to fetch records " . mysqli_error($conn);
  }
  ?>

  <?php
  include("../includes/footer.php");
  ?>