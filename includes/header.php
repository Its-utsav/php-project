<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Competitions - My System</title>
  <link rel="stylesheet" href="/college-competition-portal/bootstrap/bootstrap.min.css" />
</head>

<body>
  <header>
    <nav class="container mt-3">
      <div class="row">
        <div class="col-12">
          <ul class="list-unstyled d-flex flex-wrap justify-content-center">
            <li class="m-2">
              <a href="/college-competition-portal" class="btn btn-outline-primary  py-2">Home</a>
            </li>
            <li class="m-2">
              <a href="/college-competition-portal/users/competition.php" class="btn btn-outline-primary  py-2">Competitions</a>
            </li>
            <?php
            if (!isset($_SESSION['user_id'])):
            ?>
              <li class="m-2">
                <a href="/college-competition-portal/auth/register.php" class="btn btn-outline-primary  py-2">Register</a>
              </li>
              <li class="m-2">
                <a href="/college-competition-portal/auth/login.php" class="btn btn-outline-primary  py-2">Login</a>
              </li>
            <?php else: ?>
              <h1>Wow</h1>
            <?php endif; ?>
            <li class="m-2">
              <a href="/college-competition-portal/about.php" class="btn btn-outline-primary  py-2">About</a>
            </li>
            <li class="m-2">
              <a href="/college-competition-portal/sponsors.php" class="btn btn-outline-primary  py-2">Sponsors</a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
  </header>


  <main>