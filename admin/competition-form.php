<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");

requireAdminLogin();


$isUpdate = isset($_GET['competitionID']) && is_numeric($_GET['competitionID']);
$competitionID = $isUpdate ? $_GET['competitionID'] : null;

$title = $description = $date = $time = '';
$title_err = $description_err = $date_err = $time_err = '';
$form_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $competitionID = $_POST['id'] ?? null;
    // for update id 
    //for new it will be null 
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    if (strlen($title) < 3) {
        $title_err = "Title must be at least 3 characters.";
    }

    if (strlen($description) < 5) {
        $description_err = "Description must be at least 5 characters.";
    }

    // not in past
    if (empty($date) || strtotime($date) < strtotime(date("Y-m-d"))) {
        $date_err = "Date cannot be in the past.";
    }
    if (empty($time)) {
        $time_err = "Please select a time.";
    }
    if (empty($title_err) && empty($description_err) && empty($date_err) && empty($time_err)) {
        $sql = "";

        if ($competitionID) {

            $sql = "UPDATE competitions SET title = '$title', description = '$description', date = '$date', time = '$time' WHERE id = $competitionID";

            $success_message = "Competition updated successfully!";
        } else {

            $sql = "INSERT INTO competitions (title, description, date, time) VALUES ('$title', '$description', '$date', '$time')";
            $success_message = "Competition added successfully!";
        }

        if (mysqli_query($conn, $sql)) {

            redirect("/college-competition-portal/admin/view-competition.php", 0);
            exit();
        } else {
            // Display a general error if the query fails
            $form_message = "Database error: " . mysqli_error($conn);
        }
    }
} else if ($isUpdate) {
    $sql = "SELECT title, description, date, time FROM competitions WHERE id = $competitionID";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $description = $row['description'];
        $date = $row['date'];
        $time = $row['time'];
    } else {
        die("Error: Competition with this ID was not found.");
    }
}

?>
<h2>
    <?php
    if ($isUpdate) {
        echo  "Update";
    } else {
        echo "Add";
    }
    ?>

    Competition</h2>
<?php

if (!empty($error_message)) :
?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>
<!-- <form action="../../server/admin.php" method="post"> -->
<form action="" method="post">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required
            <?php
            if ($isUpdate) {
                echo "value="  . htmlspecialchars($title);
            }
            ?>>
        <p id="titlewarn" class="invalid-feedback" style="display: none"><?php echo $title_err; ?></p>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3">
            <?php
            if ($isUpdate) {
                echo  trim(htmlspecialchars($description));
            }
            ?>
            </textarea>
        <p id="descwarn" class="invalid-feedback" style="display: none"><?php echo $description_err; ?></p>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date"
            <?php
            if ($isUpdate) {
                echo "value="  . htmlspecialchars($date);
            }
            ?>>
        <p id="datewarn" class="invalid-feedback" style="display: none"><?php echo $date_err; ?></p>
    </div>
    <div class="form-group">
        <label for="time">Time:</label>
        <input type="time" class="form-control" id="time" name="time"
            <?php
            if ($isUpdate) {
                echo "value="  . htmlspecialchars($time);
            }
            ?>>
        <p id="timewarn" class="invalid-feedback" style="display: none"><?php echo $time_err; ?></p>
    </div>
    <input type="hidden" value="true"

        <?php
        if ($isUpdate) {
            echo  'name="admin-update-competition"';
        } else {
            echo 'name="admin-add-competition"';
        }
        ?> />
    <?php

    if ($isUpdate) {
        echo '<input type="hidden" value="' . htmlspecialchars($competitionID) . '" name="id"/>';
    }
    ?>
    <button type="submit" class="btn btn-primary">
        <?php
        if ($isUpdate) {
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

    document.addEventListener("DOMContentLoaded", function() {
        const titleInput = document.getElementById("title");
        const descInput = document.getElementById("description");
        const dateInput = document.getElementById("date");
        const timeInput = document.getElementById("time");

        const titleWarn = document.getElementById("titlewarn");
        const descWarn = document.getElementById("descwarn");
        const dateWarn = document.getElementById("datewarn");
        const timeWarn = document.getElementById("timewarn");


        const minDate = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', minDate);


        titleInput.addEventListener("change", function() {
            const title = titleInput.value.trim();
            if (title.length < 3) {
                titleWarn.textContent = "Title must be at least 3 characters.";
                titleWarn.style.display = "block";
                titleInput.classList.add("is-invalid");
            } else {
                titleWarn.style.display = "none";
                titleInput.classList.remove("is-invalid");
            }
        });


        descInput.addEventListener("change", function() {
            const desc = descInput.value.trim();
            if (desc.length < 5) {
                descWarn.textContent = "Description must be at least 10 characters.";
                descWarn.style.display = "block";
                descInput.classList.add("is-invalid");
            } else {
                descWarn.style.display = "none";
                descInput.classList.remove("is-invalid");
            }
        });


        dateInput.addEventListener("change", function() {
            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                dateWarn.textContent = "Date cannot be in the past.";
                dateWarn.style.display = "block";
                dateInput.classList.add("is-invalid");
            } else {
                dateWarn.style.display = "none";
                dateInput.classList.remove("is-invalid");
            }
        });


        timeInput.addEventListener("change", function() {
            if (!timeInput.value) {
                timeWarn.textContent = "Please select a time.";
                timeWarn.style.display = "block";
                timeInput.classList.add("is-invalid");
            } else {
                timeWarn.style.display = "none";
                timeInput.classList.remove("is-invalid");
            }
        });
    });
</script>


<?php
include("../includes/footer.php");
?>