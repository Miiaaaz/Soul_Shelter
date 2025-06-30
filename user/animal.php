<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

$id = $_GET['id'] ?? null;

if (!$id) {
  header("Location: view-animals.php?msg=Invalid animal ID&type=error");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM animals WHERE animal_id = ? AND status = 'available'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();

if (!$animal) {
  header("Location: view-animals.php?msg=Animal not found&type=error");
  exit;
}
?>

<main class="container" data-aos="fade-up">
  <div class="animal-detail-box">
    <img src="../assets/images/<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>">

    <div class="animal-detail-info">
      <h1><?= htmlspecialchars($animal['name']) ?></h1>
      <p><strong>Species:</strong> <?= htmlspecialchars($animal['species']) ?></p>
      <p><strong>Breed:</strong> <?= htmlspecialchars($animal['breed']) ?></p>
      <p><strong>Age:</strong> <?= htmlspecialchars($animal['age']) ?> years</p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($animal['gender']) == 'jantan' ? 'Male' : 'Female' ?></p>
      <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($animal['description'])) ?></p>

      <a href="adopt-form.php?id=<?= $animal['animal_id'] ?>" class="btn">Adopt Me</a>
      <a href="view-animals.php" class="btn btn-outline">← Back to Animals</a>
    </div>
  </div>
</main>

<style>
.animal-detail-box {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  align-items: flex-start;
  margin-top: 2rem;
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.animal-detail-box img {
  max-width: 350px;
  width: 100%;
  border-radius: 10px;
  object-fit: cover;
}

.animal-detail-info {
  flex: 1;
  min-width: 250px;
}

.animal-detail-info h1 {
  margin-top: 0;
  margin-bottom: 1rem;
  font-size: 2rem;
}

.animal-detail-info p {
  margin: 0.4rem 0;
  line-height: 1.5;
}

.btn {
  display: inline-block;
  margin-top: 1.5rem;
  margin-right: 1rem;
  padding: 0.7rem 1.4rem;
  background: #ff7043;
  color: white;
  border-radius: 6px;
  text-decoration: none;
}

.btn:hover {
  background: #ff5722;
}

.btn-outline {
  background: transparent;
  border: 2px solid #ff7043;
  color: #ff7043;
}

.btn-outline:hover {
  background: #ff7043;
  color: white;
}

/* Dark Mode */
body.dark-mode .animal-detail-box {
  background: #2a2a2a;
  color: #eee;
}

body.dark-mode .animal-detail-info p {
  color: #ccc;
}
</style>

<?php include('../includes/footer.php'); ?>
