<?php include('includes/header.php'); ?>
<main class="login-page">
  <div class="login-card" data-aos="zoom-in">
    <div class="login-image">
      <img src="assets/images/register-pet.png" alt="Cute Animal Register">
    </div>
    <form action="register-process.php" method="POST" class="login-form">
      <h2>Join the Pack! 🐕</h2>
      <p>Create your account to start adopting!</p>

      <?php
      if (isset($_GET['msg'])) {
          $type = $_GET['type'] ?? 'error';
          $msg = htmlspecialchars($_GET['msg']);
          echo "<div class='alert $type' data-aos='fade-down'>$msg</div>";
      }
      ?>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required placeholder="Enter username">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Create password">

      <label for="confirm">Confirm Password</label>
      <input type="password" id="confirm" name="confirm" required placeholder="Confirm password">

      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" required placeholder="Enter your full name">

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" required placeholder="e.g. 012-3456789">

      <button type="submit" class="btn">Register</button>
      <p class="register-link">Already have an account? <a href="login.php">Log In 🐾</a></p>
    </form>
  </div>
</main>
<?php include('includes/footer.php'); ?>
