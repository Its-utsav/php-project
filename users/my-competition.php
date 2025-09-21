<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();

?>

<div class="container mt-5">
  <h2 class="mb-4">Joined Competitions</h2>

  <?php

  $user_id = $_SESSION['user_id'];

  $q = "SELECT 
    competitions.title as title,
    competitions.date as date, 
    competitions.time as time, 
    registrations.created_at as join_date
    from registrations join competitions on registrations.competition_id = competitions.id  where registrations.user_id  = $user_id";
  $result =  mysqli_query($conn, $q);


  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      echo ' <table class="table  table-hover">
        <thead>
          <tr>
            <th scope="col">title</th>
            <th scope="col">date</th>
            <th scope="col">time</th>
            <th scope="col">join date</th>
          </tr>
        </thead>
        <tbody>';
      while ($row = mysqli_fetch_assoc($result)) {
        // var_dump($row);
        echo "<tr>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['time']) . "</td>
                    <td>" . htmlspecialchars($row['join_date']) . "</td>    
                  </tr>";
      }
      echo ' </tbody>
  </table>';
    } else {
      echo "<div class='alert alert-info'>You are nor take part in any competition</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Failed to fetch records: " . mysqli_error($conn) . "</div>";
  }
  ?>

</div>
<?php
include("../includes/footer.php");
?>