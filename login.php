<?php include('includes/header.php'); ?>
<main class="login-page">
  <div class="login-card" data-aos="zoom-in">
    <div class="login-image">
      <img src="/animalshelter/assets/images/login-pet.png"
        alt="Cute Animal Login"
        style="display: block; margin: 0 auto; width: 130%;">
    </div>

    <?php
    if (isset($_GET['msg'])) {
      $type = $_GET['type'] ?? 'error';
      $msg = htmlspecialchars($_GET['msg']);
      echo "<div class='alert $type' data-aos='fade-down'>$msg</div>";
    }
    ?>

    <form action="login-process.php" method="POST" class="login-form">
      <h2>Welcome Back! 🐾</h2>
      <p>Log in to adopt your new best friend!</p>
      
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required placeholder="Enter your username">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <button type="submit" class="btn">Login</button>
      <p class="register-link">Don't have an account? <a href="register.php">Sign Up 🐶</a></p>
    </form>
  </div>
</main>

<!-- 🐾 Loading Overlay -->
<div id="loading-overlay" style="display: none; position: fixed; inset: 0; background: rgba(255,255,255,0.9); z-index: 9999; justify-content: center; align-items: center; flex-direction: column; font-family: 'Fredoka', sans-serif;">
  <img src="/animalshelter/assets/images/paw-loading.gif" alt="Loading..." style="width: 80px; height: 80px; margin-bottom: 1rem;">
  <div id="loading-text" style="font-size: 1.2rem; color: #444;">Logging in...</div>
</div>

<script>
  const form = document.querySelector('form');
  const overlay = document.getElementById('loading-overlay');
  const loadingText = document.getElementById('loading-text');

  form.addEventListener('submit', function () {
    const username = document.querySelector('input[name="username"]').value;
    overlay.style.display = 'flex';
    loadingText.textContent = "Welcome, " + username + "! 🐾";
  });
</script>

<?php include('includes/footer.php'); ?>
