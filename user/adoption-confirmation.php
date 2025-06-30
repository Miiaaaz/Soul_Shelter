<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php?msg=Please login to view confirmation&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

$request_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$request_id) {
  header("Location: my-requests.php?msg=Invalid request&type=error");
  exit;
}

$sql = "SELECT a.*, an.name AS animal_name, an.breed, an.species, an.image,
               u.name AS user_name, u.phone
        FROM adoptions a
        JOIN animals an ON a.animal_id = an.animal_id
        JOIN users u ON a.user_id = u.user_id
        WHERE a.adoption_id = ? AND a.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $request_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();

if (!$request) {
  header("Location: my-requests.php?msg=Request not found&type=error");
  exit;
}
?>

<main class="container" data-aos="fade-up">
  <div class="card-box printable-area">
    <h1>🐾 Adoption Confirmation</h1>

    <div class="animal-confirm-box">
      <img src="../assets/images/<?= htmlspecialchars($request['image']) ?>" alt="<?= $request['animal_name'] ?>">

      <div class="details">
        <h2><?= htmlspecialchars($request['animal_name']) ?></h2>
        <p><strong>Species:</strong> <?= $request['species'] ?></p>
        <p><strong>Breed:</strong> <?= $request['breed'] ?></p>
        <p><strong>Status:</strong> <?= ucfirst($request['status']) ?></p>

        <?php if (strtolower($request['status']) === 'approved'): ?>
          <div class="approval-msg">
            🎉 <strong>Congratulations!</strong> Your adoption request has been <strong>approved</strong>!<br>
            Please <strong>print this confirmation</strong> and bring it to the shelter when picking up your pet. 🐶🐱
          </div>
        <?php endif; ?>

        <p><strong>Requested On:</strong> <?= date("d M Y, h:i A", strtotime($request['request_date'])) ?></p>
      </div>
    </div>

    <hr>

    <h3>👤 Applicant Info</h3>
    <p><strong>Name:</strong> <?= htmlspecialchars($request['user_name']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($request['phone']) ?></p>

    <div class="print-controls">
      <button onclick="window.print()" class="btn">🖨️ Print / Save as PDF</button>
      <a href="my-requests.php" class="btn btn-outline">← Back to My Requests</a>
    </div>
  </div>
</main>

<style>
.container {
  padding: 2rem;
  max-width: 800px;
  margin: auto;
}

.card-box {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.animal-confirm-box {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
}

.animal-confirm-box img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.details {
  flex: 1;
  min-width: 220px;
}

.print-controls {
  margin-top: 2rem;
}

.approval-msg {
  background: #e6fbe6;
  border-left: 6px solid #34a853;
  padding: 1rem 1.2rem;
  border-radius: 10px;
  margin-top: 1rem;
  font-weight: bold;
  color: #2e7d32;
  font-size: 1rem;
  font-family: 'Fredoka', sans-serif;
}

body.dark-mode .approval-msg {
  background: #204d24;
  color: #a8f4a8;
  border-left: 6px solid #55d66a;
}

/* Print Styling */
@media print {
  body * {
    visibility: hidden;
  }
  .printable-area, .printable-area * {
    visibility: visible;
  }
  .printable-area {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
}

body.dark-mode .card-box {
  background: #2a2a2a;
  color: white;
}
</style>

<?php include('../includes/footer.php'); ?>
