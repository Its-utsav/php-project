<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");

requireAdminLogin();
if (isset($_GET['competitionID'])) {
    $id = $_GET['competitionID'];
    $q = "SELECT * FROM competitions WHERE id = $id";
    $result =  mysqli_query($conn, $q);

    if ($result) {
        $row = mysqli_fetch_array($result);
        $id = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $date = $row['date'];
        $time = $row['time'];
    }
}
?>
<h2>
    <?php
    if (isset($_GET['competitionID'])) {
        echo  "Update";
    } else {
        echo "Add";
    }
    ?>

    Competition</h2>
<form action="../../server/admin.php" method="post">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required
            <?php
            if (isset($_GET['competitionID'])) {
                echo "value="  . htmlspecialchars($title);
            }
            ?>>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3">
            <?php
            if (isset($_GET['competitionID'])) {
                echo  trim(htmlspecialchars($description));
            }
            ?>
            </textarea>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date"
            <?php
            if (isset($_GET['competitionID'])) {
                echo "value="  . htmlspecialchars($date);
            }
            ?>>
    </div>
    <div class="form-group">
        <label for="time">Time:</label>
        <input type="time" class="form-control" id="time" name="time"
            <?php
            if (isset($_GET['competitionID'])) {
                echo "value="  . htmlspecialchars($time);
            }
            ?>>
    </div>
    <input type="hidden" value="true"

        <?php
        if (isset($_GET['competitionID'])) {
            echo  'name="admin-update-competition"';
        } else {
            echo 'name="admin-add-competition"';
        }
        ?> />
    <?php
    if (isset($_GET['competitionID'])) {
        echo '<input type="hidden" value=' . htmlspecialchars($id) . ' name="id"/>';
    }
    ?>
    <button type="submit" class="btn btn-primary">
        <?php
        if (isset($_GET['competitionID'])) {
            echo  "Update";
        } else {
            echo "Add";
        }
        ?>
        competition
    </button>
</form>

<script>
    const minDate = new Date().toISOString().split('T')[0];
    document.getElementById("date").setAttribute('min', minDate);
</script>

<?php
include("../includes/footer.php");
?>