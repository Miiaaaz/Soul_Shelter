<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-brand">
      <h2><i class="fa-solid fa-paw"></i> Soul Shelter</h2>
      <p> A Haven of Hope for Every Paw and Heartbeat. 🐶🐱</p>
    </div>
    
    <div class="footer-links">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="/index.php">Home</a></li>
        <li><a href="#">Adopt</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>

    <div class="footer-contact">
      <h4>Contact Us</h4>
      <p><i class="fa-solid fa-phone"></i> +6012-3456789</p>
      <p><i class="fa-solid fa-envelope"></i> hello@Soulshelter.org</p>
      <p><i class="fa-solid fa-location-dot"></i> Jalan Kasih Sayang, Gabenor kucing</p>
    </div>

    <div class="footer-social">
      <h4>Follow Us</h4>
      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
      <a href="#"><i class="fa-brands fa-instagram"></i></a>
      <a href="#"><i class="fa-brands fa-twitter"></i></a>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; <?php echo date('Y'); ?> Soul Shelter. All rights reserved.</p>
  </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" title="Back to Top">
  <i class="fa-solid fa-arrow-up"></i>
</button>

<script>
  // Show or hide the button
  const backToTopBtn = document.getElementById("backToTop");

  window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      backToTopBtn.style.display = "block";
    } else {
      backToTopBtn.style.display = "none";
    }
  };

  // Scroll smoothly to top
  backToTopBtn.onclick = function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
</script>



</body>
</html>
