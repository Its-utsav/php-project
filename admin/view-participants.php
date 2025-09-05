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
            <th scope="col">competition Title</th>
            <th scope="col">joinDate</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $competitionID = $_GET['competitionID'];
        $q = "SELECT 
            users.name as username,
            users.id as userId,
            competitions.title as competitionTitle,
            registrations.created_at as joinDate
         FROM registrations JOIN users ON registrations.user_id = users.id JOIN competitions ON registrations.competition_id = competitions.id WHERE competitions.id = $competitionID";
        $result =  mysqli_query($conn, $q);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr>

                            <td>" . $row['userId'] . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['competitionTitle'] . "</td>
                            <td>" . $row['joinDate'] . "</td>
                      
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