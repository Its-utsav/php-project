<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");

requireAdminLogin();
?>
<h2>Users</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No.</th>
            <th scope="col">Gender</th>
            <th scope="col">Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $q = "SELECT * FROM users";
        $result =  mysqli_query($conn, $q);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['phone_no'] . "</td>
                            <td>" . $row['gender'] . "</td>
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



<?php
include("../includes/footer.php");
?>