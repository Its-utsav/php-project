<?php
include("../includes/header.php");
?>

<div class="container">
  <h1 class="text-center">Login as <b>admin</b></h1>
  <form id="form" action="../server/admin.php" method="POST">
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
    <input type="hidden" name="admin-login" value="true" />
    <!-- button -->
    <div class="form-group">
      <button name="login" type="submit" class="btn btn-primary">Login</button>
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

      let emailWarn = document.getElementById("emailwarn");
      let passWarn = document.getElementById("passwarn");

      emailWarn.style.display = "none";
      passWarn.style.display = "none";

      let email = document.getElementById("email").value;
      let password = document.getElementById("password").value;

      let email_at = email.indexOf("@");
      let email_dot = email.lastIndexOf(".");

      let valid = true;
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

<?php
include("../includes/footer.php");
?>