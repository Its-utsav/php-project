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
    var form = document.getElementById("form");

    form.addEventListener("submit", validateForm);

    function validateForm(e) {
      e.preventDefault();

      let valid = true;

      const nameWarn = document.getElementById("namewarn");
      const name = document.getElementById("name").value;
      if (!name || !isNaN(name)) {
        nameWarn.textContent = "Enter a valid name.";
        nameWarn.style.display = "block";
        valid = false;
      } else {
        nameWarn.textContent = null;
        nameWarn.style.display = "none";
      }

      const email = document.getElementById("email").value;
      const emailWarn = document.getElementById("emailwarn");
      const email_at = email.indexOf("@");
      const email_dot = email.indexOf(".");
      if (email_at < 1 || email_dot - email_at < 2) {
        emailWarn.textContent = "Enter a valid email.";
        emailWarn.style.display = "block";
        valid = false;
      } else {
        emailWarn.textContent = null;
        emailWarn.style.display = "none";
      }

      const phoneWarn = document.getElementById("phonewarn");
      const phoneNumber = document.getElementById("phoneNumber").value;

      if (isNaN(phoneNumber) || phoneNumber.length != 10) {
        phoneWarn.textContent = "Phone number must be 10 digits.";
        phoneWarn.style.display = "block";
        valid = false;
      } else {
        phoneWarn.textContent = null;
        phoneWarn.style.display = "none";
      }

      const password = document.getElementById("password").value;
      const passWarn = document.getElementById("passwarn");
      if (password.length < 4) {
        passWarn.textContent =
          "Password must be at least 4 characters long.";
        passWarn.style.display = "block";
        valid = false;
      } else {
        passWarn.textContent = null;
        passWarn.style.display = "none";
      }

      const genderWarn = document.getElementById("genderwarn");
      const gender = document.getElementsByName("gender");
      if (!gender[0].checked && !gender[1].checked) {
        genderWarn.textContent = "Select a gender.";
        genderWarn.style.display = "block";
        valid = false;
      } else {
        genderWarn.textContent = null;
        genderWarn.style.display = "none";
      }

      if (valid) {
        this.submit();
      }
    }
  });
</script>
</body>

</html>