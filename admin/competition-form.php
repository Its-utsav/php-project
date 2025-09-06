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
        <p id="titlewarn" class="invalid-feedback" style="display: none"></p>
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
        <p id="descwarn" class="invalid-feedback" style="display: none"></p>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date"
            <?php
            if (isset($_GET['competitionID'])) {
                echo "value="  . htmlspecialchars($date);
            }
            ?>>
        <p id="datewarn" class="invalid-feedback" style="display: none"></p>
    </div>
    <div class="form-group">
        <label for="time">Time:</label>
        <input type="time" class="form-control" id="time" name="time"
            <?php
            if (isset($_GET['competitionID'])) {
                echo "value="  . htmlspecialchars($time);
            }
            ?>>
        <p id="timewarn" class="invalid-feedback" style="display: none"></p>
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