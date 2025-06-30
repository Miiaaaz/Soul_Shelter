<?php
session_start();
include('includes/db.php');
include('includes/header.php');

$role = $_SESSION['role'] ?? 'guest';
$username = $_SESSION['username'] ?? 'Guest';

if (!isset($_SESSION['username'])) {
  header("Location: login.php?msg=Please log in to access dashboard&type=error");
  exit;
}

// Fetch stats if admin
if ($role === 'admin') {
  $total_animals = $conn->query("SELECT COUNT(*) AS total FROM animals")->fetch_assoc()['total'];
  $adopted_animals = $conn->query("SELECT COUNT(*) AS total FROM animals WHERE status = 'adopted'")->fetch_assoc()['total'];
  $pending_requests = $conn->query("SELECT COUNT(*) AS total FROM adoptions WHERE status = 'pending'")->fetch_assoc()['total'];
  $approved_requests = $conn->query("SELECT COUNT(*) AS total FROM adoptions WHERE status = 'approved'")->fetch_assoc()['total'];
  $rejected_requests = $conn->query("SELECT COUNT(*) AS total FROM adoptions WHERE status = 'rejected'")->fetch_assoc()['total'];
}
?>

<main class="dashboard-page">
  <section class="dashboard-header" data-aos="fade-down">
    <h1>Welcome back, <?= htmlspecialchars($username) ?>! 🐾</h1>
    <p>This is your dashboard. Manage your journey with our animals here.</p>
  </section>

  <?php if ($role === 'admin'): ?>
    <!-- STAT CARDS -->
    <section class="dashboard-stats" data-aos="fade-up">
      <div class="stat-card"><i class="fa-solid fa-paw icon"></i><h2><?= $total_animals ?></h2><p>Total Animals</p></div>
      <div class="stat-card"><i class="fa-solid fa-heart icon"></i><h2><?= $adopted_animals ?></h2><p>Adopted</p></div>
      <div class="stat-card"><i class="fa-solid fa-clock icon"></i><h2><?= $pending_requests ?></h2><p>Pending</p></div>
      <div class="stat-card"><i class="fa-solid fa-circle-check icon"></i><h2><?= $approved_requests ?></h2><p>Approved</p></div>
      <div class="stat-card"><i class="fa-solid fa-circle-xmark icon"></i><h2><?= $rejected_requests ?></h2><p>Rejected</p></div>
    </section>

    <!-- ADMIN LINKS -->
    <section class="dashboard-content" data-aos="fade-up">
      <div class="card"><h3>🐶 Manage Animals</h3><a href="admin/manage-animals.php" class="btn">Go</a></div>
      <div class="card"><h3>👥 Manage Users</h3><a href="admin/manage-users.php" class="btn">Go</a></div>
      <div class="card"><h3>📄 Review Adoption Requests</h3><a href="admin/review-requests.php" class="btn">Go</a></div>
    </section>

  <?php else: ?>
    <!-- USER VIEW -->
    <section class="dashboard-content" data-aos="fade-up">
      <div class="card"><h3>🐾 View Available Pets</h3><a href="user/view-animals.php" class="btn">See Pets</a></div>
      <div class="card"><h3>📥 My Adoption Requests</h3><a href="user/my-requests.php" class="btn">Track</a></div>
      <div class="card"><h3>📝 Edit My Profile</h3><a href="user/profile.php" class="btn">Update</a></div>
    </section>
  <?php endif; ?>
</main>

<style>
.dashboard-page {
  padding: 2rem;
  max-width: 1100px;
  margin: auto;
}

.dashboard-header {
  text-align: center;
  margin-bottom: 2rem;
}

.dashboard-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1.2rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: #fff;
  padding: 1.5rem;
  text-align: center;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: transform 0.3s;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card .icon {
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
  color: #ff7043;
}

.stat-card h2 {
  margin: 0;
  font-size: 1.8rem;
}

.stat-card p {
  margin: 0.3rem 0 0;
  color: #666;
}

.dashboard-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
}

.card {
  background: #fff;
  padding: 1.5rem;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.btn {
  margin-top: 1rem;
  display: inline-block;
  padding: 0.5rem 1rem;
  background: #ff7043;
  color: white;
  text-decoration: none;
  border-radius: 6px;
}

.btn:hover {
  background: #ff5722;
}

body.dark-mode .stat-card,
body.dark-mode .card {
  background: #2a2a2a;
  color: #eee;
}

body.dark-mode .stat-card p,
body.dark-mode .card p {
  color: #bbb;
}
</style>

<?php include('includes/footer.php'); ?>
