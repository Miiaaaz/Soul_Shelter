<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}
include('../includes/db.php');
include('../includes/header.php');

$statusFilter = $_GET['status'] ?? 'all';

$query = "SELECT a.*, an.name AS animal_name, u.name AS user_name 
          FROM adoptions a
          JOIN animals an ON a.animal_id = an.animal_id
          JOIN users u ON a.user_id = u.user_id";

if ($statusFilter !== 'all') {
  $query .= " WHERE a.status = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $statusFilter);
} else {
  $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container" data-aos="fade-up">
  <h1>📬 Review Adoption Requests</h1>

  <form method="GET" class="filter-form">
    <label for="status">Filter by status:</label>
    <select name="status" id="status" onchange="this.form.submit()">
      <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All</option>
      <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
      <option value="approved" <?= $statusFilter === 'approved' ? 'selected' : '' ?>>Approved</option>
      <option value="rejected" <?= $statusFilter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
    </select>
  </form>

  <div class="card-box">
    <table class="animal-table">
      <thead>
        <tr>
          <th>Animal</th>
          <th>Applicant</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['animal_name']) ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= date("d M Y", strtotime($row['request_date'])) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
              <?php if ($row['status'] === 'pending'): ?>
                <a href="update-request.php?id=<?= $row['adoption_id'] ?>&status=approved" class="btn small-btn">Approve</a>
                <a href="update-request.php?id=<?= $row['adoption_id'] ?>&status=rejected" class="btn danger-btn small-btn">Reject</a>
              <?php else: ?>
                <span style="color:gray;">No actions</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<style>
.filter-form {
  margin: 1rem 0;
  display: flex;
  gap: 1rem;
  align-items: center;
}

.filter-form select {
  padding: 0.5rem;
  font-size: 1rem;
  border-radius: 6px;
}

.animal-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.animal-table th, .animal-table td {
  padding: 10px 16px;
  border: 1px solid #ddd;
  text-align: center;
}

.animal-table th {
  background-color: #ffe0b2;
  color: #444;
}

.animal-table tr:nth-child(even) {
  background-color: #fffaf2;
}

body.dark-mode .animal-table th {
  background-color: #333;
  color: #eee;
}

body.dark-mode .animal-table td {
  background-color: #222;
  color: #ddd;
}
</style>

<?php include('../includes/footer.php'); ?>
