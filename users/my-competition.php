<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();

?>

<div class="container mt-5">
  <h2 class="mb-4">Joined Competitions</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">title</th>
        <th scope="col">date</th>
        <th scope="col">time</th>
        <th scope="col">join date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $user_id = $_SESSION['user_id'];

      $q = "SELECT * from registrations join competitions on registrations.competition_id = competitions.id  where registrations.user_id  = $user_id";
      $result =  mysqli_query($conn, $q);


      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_array($result)) {

            echo "<tr>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['time'] . "</td>
                    <td>" . $row['created_at'] . "</td>    
                  </tr>";
          }
        }
      } else {
        echo "Failed to fetch records " . mysqli_error($conn);
      }
      ?>
    </tbody>
  </table>
</div>
<?php
include("../includes/footer.php");
?>