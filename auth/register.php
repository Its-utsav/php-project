<?php
// get data , apply some saf safai (not empty, valid email , at least 4 ch for password) , insert it and move to login 

// email uniqe -> first check email is not exists in our DB

require("../config/db.php");
include("../includes/header.php");
require("../includes/functions.php");
$name = $email = $phone_no = $gender = "";
$name_err = $email_err = $phone_err = $pass_err = $gender_err = $form_message = "";

if (isset($_POST['register'])) {
  if (empty(trim($_POST["name"]))) {
    $name_err = "Please enter your name.";
  } else {
    $name = trim($_POST["name"]);
  }

  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter your email.";
  } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_err = "Invalid email.";
  } else {
    $email = trim($_POST["email"]);
    // user email should not be thier
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $email_err = "An account with this email already exists.";
    }
  }

  if (empty(trim($_POST["phone_no"]))) {
    $phone_err = "Please enter your phone number.";
  } elseif (!preg_match('/^[0-9]{10}$/', trim($_POST['phone_no']))) {
    $phone_err = "Phone number must be exactly 10 digits.";
  } else {
    $phone_no = trim($_POST["phone_no"]);
  }


  if (empty($_POST["password"])) {
    $pass_err = "Please enter a password.";
  } elseif (strlen($_POST["password"]) < 4) {
    $pass_err = "Password must have at least 4 characters.";
  } else {
    $password = $_POST["password"];
  }

  if (empty($_POST["confirm-password"])) {
    $pass_err = "Please confirm your password.";
  } else {
    $confirm_password = $_POST["confirm-password"];
    if (empty($pass_err) && ($password != $confirm_password)) {
      $pass_err = "Passwords did not match.";
    }
  }

  if (empty($_POST["gender"])) {
    $gender_err = "Please select your gender.";
  } else {
    $gender = $_POST["gender"];
  }

  if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($pass_err) && empty($gender_err)) {


    $q = "INSERT INTO users (name,email,phone_no,password,gender) 
          VALUES ('$name','$email','$phone_no','$password','$gender')";

    if (mysqli_query($conn, $q)) {


      $form_message = "Redirect to login page";

      redirect("../auth/login.php", 5);
      exit();
    } else {
      $form_message = "Something went wrong. Please try again later.";
    }
  }
}
?>
<div class="container">
  <h1 class="text-center">Registration form</h1>
  <?php

  if (!empty($form_message)): ?>
    <div class="alert alert-danger"><?php echo $form_message; ?></div>
  <?php endif; ?>
  <!-- <form id="form" action="../server/main.php" method="post"> -->
  <form id="form" action="" method="post">

    <!-- name -->
    <div class="form-group">
      <label for="name">Name:</label>
      <input
        type="text"
        class="form-control"
        id="name"
        name="name"
        placeholder="Enter Your Name"
        required />
      <p id="namewarn" class="invalid-feedback">
        <?php
        echo $name_err;
        ?>

      </p>
    </div>

    <!-- email -->
    <div class="form-group">
      <label for="email">Email:</label>
      <input
        type="email"
        class="form-control"
        id="email"
        name="email"
        placeholder="Enter Your Email"
        required />
      <p id="emailwarn" class="invalid-feedback">
        <?php
        echo $email_err;
        ?>
      </p>
    </div>

    <!-- phone no -->
    <div class="form-group">
      <label for="phoneNumber">Phone Number:</label>
      <input
        type="number"
        class="form-control"
        id="phoneNumber"
        name="phone_no"
        maxlength="10"
        required
        placeholder="Enter Your Phone Number" />
      <p id="phonewarn" class="invalid-feedback">
        <?php
        echo $phone_err;
        ?>
      </p>
    </div>

    <!-- password -->
    <div class="form-group">
      <label for="password">Password:</label>
      <input
        type="password"
        class="form-control"
        id="password"
        name="password"
        maxlength="10"
        placeholder="Enter Password"
        required />
      <p id="passwarn" class="invalid-feedback">
        <?php
        echo $pass_err;
        ?>
      </p>
    </div>

    <!-- confirm password -->
    <div class="form-group">
      <label for="confirm-password">Confirm password:</label>
      <input
        type="password"
        class="form-control"
        id="confirm-password"
        name="confirm-password"
        maxlength="10"

        placeholder="Enter confirm password"
        required />
      <p id="passwarn" class="invalid-feedback">

      </p>
    </div>

    <!-- gender -->
    <div class="form-group">
      <label>Gender:</label>
      <label class="form-check-label mr-3">
        <input type="radio" name="gender" value="male" required /> Male
      </label>
      <label class="form-check-label">
        <input type="radio" name="gender" value="female" required /> Female
      </label>
      <p id="genderwarn" class="invalid-feedback">
        <?php
        echo $gender_err;
        ?>
      </p>
    </div>

    <!-- button -->
    <div class="form-group">
      <button name="register" type="submit" class="btn btn-primary">Register</button>
      <button type="reset" value="Reset" class="btn btn-secondary">Reset</button>
    </div>
    <input type="hidden" name="register" value="true" />

  </form>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("form");

    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phoneNumber");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm-password");
    const genderInputs = document.getElementsByName("gender");

    const nameWarn = document.getElementById("namewarn");
    const emailWarn = document.getElementById("emailwarn");
    const phoneWarn = document.getElementById("phonewarn");
    const passWarn = document.getElementById("passwarn");
    const genderWarn = document.getElementById("genderwarn");


    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    nameInput.addEventListener("change", function() {
      const name = nameInput.value.trim();
      if (!name || !isNaN(name)) {
        nameWarn.textContent = "Enter a valid name.";
        nameWarn.style.display = "block";
        nameInput.classList.add("is-invalid");
      } else {
        nameWarn.style.display = "none";
        nameInput.classList.remove("is-invalid");
      }
    });

    emailInput.addEventListener("change", function() {
      const email = emailInput.value.trim();
      if (!emailRegex.test(email)) {
        emailWarn.textContent = "Enter a valid email.";
        emailWarn.style.display = "block";
        emailInput.classList.add("is-invalid");
      } else {
        emailWarn.style.display = "none";
        emailInput.classList.remove("is-invalid");
      }
    });

    phoneInput.addEventListener("change", function() {
      const phone = phoneInput.value.trim();
      if (!/^\d{10}$/.test(phone)) {
        phoneWarn.textContent = "Phone number must be 10 digits.";
        phoneWarn.style.display = "block";
        phoneInput.classList.add("is-invalid");
      } else {
        phoneWarn.style.display = "none";
        phoneInput.classList.remove("is-invalid");
      }
    });

    passwordInput.addEventListener("change", function() {
      const password = passwordInput.value;
      if (password.length < 4) {
        passWarn.textContent = "Password must be at least 4 characters long.";
        passWarn.style.display = "block";
        passwordInput.classList.add("is-invalid");
      } else {
        passWarn.style.display = "none";
        passwordInput.classList.remove("is-invalid");
      }
    });

    confirmInput.addEventListener("change", function() {
      const password = passwordInput.value;
      const confirm = confirmInput.value;
      if (password !== confirm) {
        passWarn.textContent = "Passwords do not match.";
        passWarn.style.display = "block";
        confirmInput.classList.add("is-invalid");
      } else {
        passWarn.style.display = "none";
        confirmInput.classList.remove("is-invalid");
      }
    });

    genderInputs.forEach((input) => {
      input.addEventListener("change", function() {
        if (!genderInputs[0].checked && !genderInputs[1].checked) {
          genderWarn.textContent = "Select a gender.";
          genderWarn.style.display = "block";
        } else {
          genderWarn.style.display = "none";
        }
      });
    });


    form.addEventListener("submit", function(e) {
      let valid = true;

      if (!nameInput.value.trim() || !isNaN(nameInput.value)) valid = false;
      if (!emailRegex.test(emailInput.value.trim())) valid = false;
      if (!/^\d{10}$/.test(phoneInput.value.trim())) valid = false;
      if (passwordInput.value.length < 4) valid = false;
      if (passwordInput.value !== confirmInput.value) valid = false;
      if (!genderInputs[0].checked && !genderInputs[1].checked) valid = false;

      if (!valid) e.preventDefault();
    });
  });
</script>