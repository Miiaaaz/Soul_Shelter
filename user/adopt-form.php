<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php?msg=Please login to adopt&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

$animal_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$animal_id) {
  header("Location: view-animals.php?msg=Invalid animal ID&type=error");
  exit;
}

// Fetch animal info
$stmt = $conn->prepare("SELECT * FROM animals WHERE animal_id = ? AND status = 'available'");
$stmt->bind_param("i", $animal_id);
$stmt->execute();
$animal = $stmt->get_result()->fetch_assoc();

if (!$animal) {
  header("Location: view-animals.php?msg=Animal not available&type=error");
  exit;
}

// Check if user already submitted a request
$check = $conn->prepare("SELECT * FROM adoptions WHERE animal_id = ? AND user_id = ?");
$check->bind_param("ii", $animal_id, $user_id);
$check->execute();
$existing = $check->get_result()->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$existing) {
  $insert = $conn->prepare("INSERT INTO adoptions (animal_id, user_id, status) VALUES (?, ?, 'pending')");
  $insert->bind_param("ii", $animal_id, $user_id);
  $insert->execute();

}
?>

<main class="container" data-aos="fade-up">
  <h1>🐶 Adopt <?= htmlspecialchars($animal['name']) ?></h1>

  <div class="card-box">
    <img src="../assets/images/<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" style="max-width: 300px; border-radius: 10px;">

    <div class="animal-form">
      <p><strong>Species:</strong> <?= htmlspecialchars($animal['species']) ?></p>
      <p><strong>Breed:</strong> <?= htmlspecialchars($animal['breed']) ?></p>
      <p><strong>Age:</strong> <?= htmlspecialchars($animal['age']) ?> years</p>
      <p><strong>Gender:</strong> <?= $animal['gender'] == 'jantan' ? 'Male' : 'Female' ?></p>
      <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($animal['description'])) ?></p>

      <?php if ($existing): ?>
        <p style="color: orange; margin-top: 1rem;"><strong>⚠️ You've already requested to adopt this animal.</strong></p>
      <?php else: ?>
        <form method="POST" style="margin-top: 1rem;">
          <button type="submit" class="btn">Confirm Adoption Request</button>
        </form>
      <?php endif; ?>

      <a href="view-animals.php" class="btn btn-outline">← Back</a>
    </div>
  </div>
</main>

<style>
.card-box {
  margin-top: 2rem;
  padding: 2rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
}

.animal-form {
  flex: 1;
  min-width: 250px;
}

.animal-form p {
  margin: 0.5rem 0;
}

.btn {
  padding: 0.7rem 1.5rem;
  background: #ff7043;
  color: white;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  margin-right: 1rem;
  text-decoration: none;
}

.btn:hover {
  background: #ff5722;
}

.btn-outline {
  background: transparent;
  color: #ff7043;
  border: 2px solid #ff7043;
}

.btn-outline:hover {
  background: #ff7043;
  color: white;
}

body.dark-mode .card-box {
  background: #2a2a2a;
  color: #eee;
}
</style>

<?php include('../includes/footer.php'); ?>
