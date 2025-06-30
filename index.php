<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<main class="container">

    <!-- 🐾 WELCOME -->
<section class="hero" data-aos="fade-up">
  <h1>Welcome to 🐾 Soul Shelter</h1>
  <p>We care for rescued pets and help them find a forever home full of love.</p>
</section>

  <!-- 🎞 SLIDESHOW -->
<section class="slideshow" data-aos="fade-in">
  <div class="slideshow-container" style="position:relative; height:500px;">
    <img src="/animalshelter/assets/images/slide 1.png" class="slide active" alt="Adopt Me 1">
    <img src="/animalshelter/assets/images/slide 2.png" class="slide" alt="Adopt Me 2">
    <img src="/animalshelter/assets/images/slide 3.png" class="slide" alt="Adopt Me 3">

    <button class="slide-btn prev" onclick="changeSlide(-1)">❮</button>
    <button class="slide-btn next" onclick="changeSlide(1)">❯</button>
  </div>
</section>

  <!-- 💡 ABOUT -->
  <section class="about" data-aos="fade-right">
    <h2>About Our Shelter</h2>
    <p>At Animal Shelter, our mission is to rescue, rehabilitate, and rehome stray or abandoned animals. With a dedicated team of volunteers, we provide love, food, shelter, and medical care to all animals in need.</p>
  </section>

<!-- 🐶 FEATURED PETS -->
<section id="featured" class="featured" data-aos="zoom-in">

  <h2> 🐾 Meet Your New Best Friend! <span>Available Pets for Adoption</h2>

  <!-- 🔍 Filter Buttons -->
  <div class="filter-buttons">
    <a href="?species=all#featured" class="btn-filter <?= !isset($_GET['species']) || $_GET['species'] == 'all' ? 'active' : '' ?>">All</a>
    <a href="?species=dog#featured" class="btn-filter <?= ($_GET['species'] ?? '') == 'dog' ? 'active' : '' ?>">🐶 Dogs</a>
    
    <a href="?species=cat#featured" class="btn-filter <?= ($_GET['species'] ?? '') == 'cat' ? 'active' : '' ?>">🐱 Cats</a>
    <a href="?species=bunny#featured" class="btn-filter <?= ($_GET['species'] ?? '') == 'bunny' ? 'active' : '' ?>">🐰 bunny</a>

  </div>

  <div class="animal-list">
    <?php
    $species = $_GET['species'] ?? 'all';
    $page = $_GET['page'] ?? 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $whereClause = "WHERE status = 'available'";
    if ($species !== 'all') {
        $speciesEscaped = $conn->real_escape_string($species);
        $whereClause .= " AND species = '$speciesEscaped'";
    }

    $sql = "SELECT * FROM animals $whereClause ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    $countSql = "SELECT COUNT(*) as total FROM animals $whereClause";
    $countResult = $conn->query($countSql)->fetch_assoc();
    $totalPages = ceil($countResult['total'] / $limit);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="animal-card">';
            echo '<img src="assets/images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p>' . ucfirst($row['gender']) . ', ' . htmlspecialchars($row['age']) . ' years old</p>';
            echo '<p class="species">' . htmlspecialchars($row['species']) . ' - ' . htmlspecialchars($row['breed']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No animals available right now in this category.</p>';
    }
    ?>
  </div>

  <!-- 🔁 Pagination -->
  <div class="pagination">
    <?php if ($page > 1): ?>
      <a class="btn-paginate" href="?species=<?= $species ?>&page=<?= $page - 1 ?>">← Previous</a>
    <?php endif; ?>
    <?php if ($page < $totalPages): ?>
      <a class="btn-paginate" href="?species=<?= $species ?>&page=<?= $page + 1 ?>">Next →</a>
    <?php endif; ?>
  </div>
</section>

  <!-- 🎬 STORY & TESTIMONIAL -->
  <section class="story" data-aos="fade-up">
    <h2>Real Stories. Real Love. ❤️</h2>
    <div class="story-container">
      <div class="story-video">
        <video width="100%" controls poster="assets/images/poster.jpg">
          <source src="assets/video/shelter-story.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="testimonial">
        <blockquote>
          “Adopting Luna from Animal Shelter was the best decision ever! She brings joy to our family every day.”<br>
          <span>– Aida, Pet Lover 🐾</span>
        </blockquote>
      </div>
    </div>
  </section>



<!-- 🐾 ADOPT NOW -->
<section class="adopt-now" data-aos="zoom-in-up">
  <h2>Ready to Give a Pet a New Home?</h2>
  <p>
    <?php if (!isset($_SESSION['username'])): ?>
      Start your adoption journey with just a few clicks.
    <?php else: ?>
      You're already part of our adoption family! 🐾 Start browsing available pets.
    <?php endif; ?>
  </p>

  <?php if (!isset($_SESSION['username'])): ?>
    <a href="login.php" class="btn">🐶 Login to Adopt</a>
    <a href="register.php" class="btn btn-outline">📋 Sign Up Now</a>
  <?php else: ?>
    <a href="user/view-animals.php" class="btn">🐾 View Animals</a>
  <?php endif; ?>
</section>


</main>

<script>
  // If there's a hash like #featured, scroll to it after reload
  document.addEventListener("DOMContentLoaded", function () {
    const hash = window.location.hash;
    if (hash === "#featured") {
      const el = document.getElementById("featured");
      if (el) {
        el.scrollIntoView({ behavior: "smooth" });
      }
    }
  });

  // Append #featured to filter and pagination links
  document.querySelectorAll(".btn-filter, .btn-paginate").forEach(link => {
    link.href += "#featured";
  });
</script>


<?php include('includes/footer.php'); ?>
<script src="/animalshelter/assets/js/slideshow.js"></script>
