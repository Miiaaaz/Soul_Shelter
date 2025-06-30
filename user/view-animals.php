<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total animals
$total_query = $conn->query("SELECT COUNT(*) AS total FROM animals WHERE status = 'available'");
$total = $total_query->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Get paginated results
$sql = "SELECT * FROM animals WHERE status = 'available' ORDER BY date_added DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container" data-aos="fade-up">
  <h1>🐾 Meet Our Adoptable Friends</h1>

  <div class="animal-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="animal-card">
        <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <div class="animal-info">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p><?= htmlspecialchars($row['species']) ?> • <?= htmlspecialchars($row['breed']) ?></p>
          <a href="animal.php?id=<?= $row['animal_id'] ?>" class="btn small-btn">View Details</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Pagination Buttons -->
  <div class="pagination">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" class="btn btn-outline">← Previous</a>
    <?php endif; ?>

    <?php if ($page < $total_pages): ?>
      <a href="?page=<?= $page + 1 ?>" class="btn">Next →</a>
    <?php endif; ?>
  </div>
</main>

<style>
.container {
  padding: 2rem;
  max-width: 1200px;
  margin: auto;
}

.animal-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}

.animal-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.3s;
}

.animal-card:hover {
  transform: translateY(-5px);
}

.animal-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.animal-info {
  padding: 1rem;
  text-align: center;
}

.animal-info h3 {
  margin: 0.5rem 0 0.25rem;
}

.animal-info p {
  color: #888;
  margin-bottom: 1rem;
}

.btn.small-btn {
  padding: 0.5rem 1rem;
  background: #ff7043;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  display: inline-block;
}

.btn.small-btn:hover {
  background: #ff5722;
}

.pagination {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}

body.dark-mode .animal-card {
  background: #2a2a2a;
  color: white;
}

body.dark-mode .animal-info p {
  color: #bbb;
}
</style>

<?php include('../includes/footer.php'); ?>
