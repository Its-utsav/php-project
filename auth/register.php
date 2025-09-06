<?php
include("../includes/header.php");
?>
<div class="container">
  <h1 class="text-center">Registration form</h1>
  <form id="form" action="../server/main.php" method="post">

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
      <p id="namewarn" class="invalid-feedback" style="display: none"></p>
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
      <p id="emailwarn" class="invalid-feedback" style="display: none"></p>
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
      <p id="phonewarn" class="invalid-feedback" style="display: none"></p>
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
      <p id="passwarn" class="invalid-feedback" style="display: none"></p>
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
      <p id="passwarn" class="invalid-feedback" style="display: none"></p>
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
      <p id="genderwarn" class="invalid-feedback" style="display: none"></p>
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

    // Regex for email validation
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

    // Optional: still validate on submit to prevent bypass
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