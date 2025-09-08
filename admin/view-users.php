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
        $q = "SELECT id, name, email, phone_no, gender, created_at FROM users ORDER BY id DESC";
        $result =  mysqli_query($conn, $q);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['phone_no']) . "</td>
                            <td>" . htmlspecialchars($row['gender']) . "</td>
                            <td>" . htmlspecialchars($row['created_at']) . "</td>
                        </tr>";
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No users have registered yet.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center text-danger">Failed to fetch records: ' . mysqli_error($conn) . '</td></tr>';
        }
        ?>
    </tbody>
</table>



<?php
include("../includes/footer.php");
?>