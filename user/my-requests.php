<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php?msg=Please login to view requests&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT a.*, an.name AS animal_name
        FROM adoptions a
        JOIN animals an ON a.animal_id = an.animal_id
        WHERE a.user_id = ?
        ORDER BY a.request_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container" data-aos="fade-up">
  <h1>📬 My Adoption Requests</h1>

  <?php if ($result->num_rows > 0): ?>
    <div class="card-box">
      <table class="animal-table">
        <thead>
          <tr>
            <th>Animal</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Confirmation</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['animal_name']) ?></td>
              <td><?= date("d M Y, h:i A", strtotime($row['request_date'])) ?></td>
              <td>
                <?php
                  $status = $row['status'];
                  $color = $status === 'approved' ? 'green' : ($status === 'rejected' ? 'red' : 'orange');
                  echo "<span style='color: $color; font-weight: bold;'>".ucfirst($status)."</span>";
                ?>
              </td>
              <td>
                <?php if ($status === 'approved' || $status === 'pending'): ?>
                  <a href="adoption-confirmation.php?id=<?= $row['adoption_id'] ?>" class="btn small-btn">View</a>
                <?php else: ?>
                  <span style="color: gray;">N/A</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="card-box">
      <p>You have not submitted any adoption requests yet.</p>
      <a href="view-animals.php" class="btn">Browse Animals</a>
    </div>
  <?php endif; ?>
</main>

<style>
.container {
  padding: 2rem;
  max-width: 1000px;
  margin: auto;
}

.card-box {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  margin-top: 1.5rem;
}

.animal-table {
  width: 100%;
  border-collapse: collapse;
}

.animal-table th, .animal-table td {
  padding: 12px 16px;
  border: 1px solid #ddd;
  text-align: center;
}

.animal-table th {
  background-color: #ffe0b2;
}


body.dark-mode .card-box {
  background: #2a2a2a;
  color: white;
}

body.dark-mode .animal-table th {
  background: #333;
  color: #eee;
}

body.dark-mode .animal-table td {
  background: #222;
  color: #ccc;
}
</style>

<?php include('../includes/footer.php'); ?>
