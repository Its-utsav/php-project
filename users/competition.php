<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();

$filter_month = null;


// month should be be in url
if (isset($_GET['filter_month']) && is_numeric($_GET['filter_month']) && $_GET['filter_month'] >= 1 && $_GET['filter_month'] <= 12) {
  $filter_month = (int)$_GET['filter_month'];
}

$q = "SELECT id, title, description, banner, date FROM competitions";

// not in past
$where_clauses = ["YEAR(date) >= YEAR(CURDATE())"];

if ($filter_month) {
  $where_clauses[] = "MONTH(date) = $filter_month";
}

$q .= " WHERE " . implode(" AND ", $where_clauses);


$q .= " ORDER BY date ASC";
?>
<div class="container mt-5">
  <h2 class="mb-4">Competitions</h2>

  <div class="card bg-light my-4">
    <div class="card-body">
      <h5 class="card-title">Filter by Month</h5>
      <form action="" method="GET" class="form-inline">
        <div class="form-group mr-2">
          <label for="filter_month" class="mr-2">Select Month:</label>

          <select class="form-control" name="filter_month" id="filter_month">
            <option value="">All Months</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>

        </div>
        <div class="">
          <button type="submit" class="btn btn-primary mr-2">Apply Filter</button>
          <a href="competition.php" class="btn btn-secondary">Clear Filter</a>
        </div>
      </form>
    </div>
  </div>

  <?php

  $result =  mysqli_query($conn, $q);

  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {

        echo "<div class='card mb-4'>
                    <div class='card-header font-weight-bold'>
                        Competition Date: " . date("l, F d, Y", strtotime($row['date'])) . "
                    </div>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-8'>
                                <h4 class='card-title'>" . htmlspecialchars($row['title']) . "</h4>
                                <p class='card-text'>" . nl2br(htmlspecialchars($row['description'])) . "</p>
                            </div>
                            <div class='col-md-4'>
                                <img src='/college-competition-portal/uploads/" . htmlspecialchars($row['banner']) . "' class='img-fluid rounded' alt='Competition Banner'>
                            </div>
                        </div>
                    </div>
                    <div class='card-footer'>
                        <!-- Kept your original join button as requested -->
                        <a href='/college-competition-portal/users/join_competition.php/?competitionID=" . $row['id'] . "' class='btn btn-primary'>Join Competition</a>
                    </div>
                </div>";
      }
    } else {

      echo "<div class='alert alert-info'>No upcoming competitions found matching your criteria.</div>";
    }
  } else {

    echo "<div class='alert alert-danger'>Failed to fetch records: " . mysqli_error($conn) . "</div>";
  }
  ?>
</div>

<?php
include("../includes/footer.php");
?>