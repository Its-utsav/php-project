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
      <button name="register" type="submit" class="btn btn-primary">Register</button>
      <button type="reset" value="Reset" class="btn btn-secondary">Reset</button>
    </div>
  </form>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("form");

    form.addEventListener("submit", validateForm);

    function validateForm(e) {
      e.preventDefault();

      var emailWarn = document.getElementById("emailwarn");
      var passWarn = document.getElementById("passwarn");

      emailWarn.style.display = "none";
      passWarn.style.display = "none";

      var email = document.getElementById("email").value;
      var password = document.getElementById("password").value;

      var email_at = email.indexOf("@");
      var email_dot = email.lastIndexOf(".");

      var valid = true;
      if (email_at < 1 || email_dot - email_at < 2) {
        emailWarn.textContent = "Enter a valid email.";
        emailWarn.style.display = "block";
        valid = false;
      }

      if (password.length < 4) {
        passWarn.textContent =
          "Password must be at least 4 characters long.";
        passWarn.style.display = "block";
        valid = false;
      }

      if (valid) {
        form.submit();
      }
    }
  });
</script>