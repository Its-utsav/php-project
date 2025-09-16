<?php
require("../config/db.php");
include("../includes/header.php");
include("../includes/functions.php");

requireAdminLogin();


$isUpdate = isset($_GET['competitionID']) && is_numeric($_GET['competitionID']);
$competitionID = $isUpdate ? $_GET['competitionID'] : null;

$title = $description = $date = $time = '';
$title_err = $description_err = $date_err = $time_err = $banner_err = "";
$form_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $competitionID = $_POST['id'] ?? null;
    // for update id 
    //for new it will be null 
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $current_banner = $_POST['current_banner'] ?? '';
    $banner_name_to_save = $current_banner ?? "";


    if (isset($_FILES["banner"]) && $_FILES["banner"]["error"] == 0) {
        $upload_dir = "../uploads/";
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 10 * 1024 * 1024;

        $file_type = $_FILES["banner"]["type"];
        $file_size = $_FILES["banner"]["size"];


        if (!in_array($file_type, $allowed_types)) {
            $banner_err = "Invalid file type. Only JPEG , JPG and PNG are allowed.";
        } elseif ($file_size > $max_size) {
            $banner_err = "File is too large. Maximum size is 10 MB.";
        } else {

            $file_extension = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
            $unique_filename = time() . '_' . uniqid() . '.' . $file_extension;
            $target_file = $upload_dir . $unique_filename;

            if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {

                $banner_name_to_save = $unique_filename;

                if (!empty($current_banner) && file_exists($upload_dir . $current_banner)) {
                    unlink($upload_dir . $current_banner);
                }
            } else {
                $banner_err = "Sorry, there was an error uploading your file.";
            }
        }
    }
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
    if (empty($title_err) && empty($description_err) && empty($date_err) && empty($time_err) && empty($banner_err)) {
        $sql = "";

        if ($competitionID) {

            $sql = "UPDATE competitions SET title = '$title', description = '$description', date = '$date', time = '$time' ";
            // admin uploaded new banner AND new banner should not same as prevoius one 
            if (!empty($banner_name_to_save) && $current_banner !== $banner_name_to_save) {
                $sql .= ", banner = '$banner_name_to_save'";
            }
            $sql .= " WHERE id = $competitionID";
            $success_message = "Competition updated successfully!";
        } else {

            $sql = "INSERT INTO competitions (title, description, date, time, banner) VALUES ('$title', '$description', '$date', '$time', '$banner_name_to_save')";
            $success_message = "Competition added successfully!";
        }

        if (mysqli_query($conn, $sql)) {

            redirect("/college-competition-portal/admin/view-competition.php", 0);
            exit();
        } else {

            $form_message = "Database error: " . mysqli_error($conn);
        }
    }
} else if ($isUpdate) {
    $sql = "SELECT title, description, date, time,banner FROM competitions WHERE id = $competitionID";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $description = $row['description'];
        $date = $row['date'];
        $time = $row['time'];
        $current_banner = $row['banner'] ?? "";
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

if (!empty($form_message)) :
?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($form_message); ?>
    </div>
<?php endif; ?>
<!-- <form action="../../server/admin.php" method="post"> -->
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required
            <?php
            if ($isUpdate) {
                echo 'value="'  . htmlspecialchars($title) . '"';
            }
            ?>>
        <p id="titlewarn" class="invalid-feedback" style="display: none"><?php echo $title_err; ?></p>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $isUpdate ? trim(htmlspecialchars($description)) : ""; ?></textarea>
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

    <!-- banner -->
    <div class="form-group">
        <label for="banner">Competition Banner</label>
        <?php if ($isUpdate && !empty($current_banner)): ?>
            <div class="mb-2">
                <p>Current Banner:</p>
                <img src="/college-competition-portal/uploads/<?php echo htmlspecialchars($current_banner); ?>" alt="Current Banner" style="max-width: 300px; height: auto;">
            </div>
            <p><small>Upload a new file below to replace the current banner.</small></p>
        <?php endif; ?>
        <input type="file" class="form-control-file <?php echo (!empty($banner_err)) ? 'is-invalid' : ''; ?>" id="banner" name="banner">
        <div class="invalid-feedback d-block"><?php echo $banner_err; ?></div>
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