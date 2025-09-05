<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");
requireLogin();
?>
<ul class="list-unstyled d-flex flex-wrap justify-content-center">

    <li class="m-2">
        <a href="/college-competition-portal/users/my-competition.php" class="btn btn-outline-primary  py-2">See participted Competitions</a>
    </li>
</ul>

<?php
include("../includes/footer.php");
?>