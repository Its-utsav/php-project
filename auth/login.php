<?php
include("../includes/header.php");
?>

<div class="container">
  <h1 class="text-center">Login Page</h1>
  <form id="form" action="../server/main.php" method="POST">
    <!-- email -->
    <div class="form-group">
      <label for="email">Email:</label>
      <input
        type="email"
        class="form-control"
        id="email"
        name="email"
        placeholder="Enter Your Email" />
      <p id="emailwarn" class="invalid-feedback" style="display: none"></p>
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
        placeholder="Enter Password" />
      <p id="passwarn" class="invalid-feedback" style="display: none"></p>
    </div>
    <input type="hidden" name="login" value="true" />
    <!-- button -->
    <div class="form-group">
      <button name="login" type="submit" class="btn btn-primary">Login</button>
      <button type="reset" value="Reset" class="btn btn-secondary">Reset</button>
    </div>
  </form>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailWarn = document.getElementById("emailwarn");
    const passWarn = document.getElementById("passwarn");


    emailInput.addEventListener("change", function() {
      const email = emailInput.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        emailWarn.textContent = "Enter a valid email.";
        emailWarn.style.display = "block";
        emailInput.classList.add("is-invalid");
      } else {
        emailWarn.style.display = "none";
        emailInput.classList.remove("is-invalid");
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


    document.getElementById("form").addEventListener("submit", function(e) {
      const email = emailInput.value.trim();
      const password = passwordInput.value;
      let valid = true;

      if (email.indexOf("@") < 1 || email.lastIndexOf(".") - email.indexOf("@") < 2) {
        emailWarn.textContent = "Enter a valid email.";
        emailWarn.style.display = "block";
        emailInput.classList.add("is-invalid");
        valid = false;
      }

      if (password.length < 4) {
        passWarn.textContent = "Password must be at least 4 characters long.";
        passWarn.style.display = "block";
        passwordInput.classList.add("is-invalid");
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  });
</script>