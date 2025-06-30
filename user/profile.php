<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<main class="container" data-aos="fade-up">
  <div class="card-box">
    <h1>👤 My Profile</h1>
    <?php if (isset($_GET['msg'])): ?>
      <div class="alert <?= $_GET['type'] ?? 'success' ?>"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <form action="update-profile.php" method="POST" class="profile-form">
      <label>Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

      <label>Full Name</label>
      <input type="text" name="nama" value="<?= htmlspecialchars($user['name']) ?>" required>

      <label>Phone</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

      <label>New Password <small>(leave blank to keep current)</small></label>
      <input type="password" name="password" placeholder="••••••••••">

      <button type="submit" class="btn">💾 Save Changes</button>
    </form>
  </div>
</main>

<style>
.profile-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.profile-form input {
  padding: 0.7rem;
  font-size: 1rem;
  border-radius: 8px;
  border: 1px solid #ccc;
}

.profile-form button {
  background: #ff7043;
  color: white;
  border: none;
  padding: 0.7rem 1.4rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}

.profile-form button:hover {
  background: #e95b2a;
}

body.dark-mode .profile-form input {
  background: #333;
  color: white;
  border: 1px solid #666;
}
</style>

<?php include('../includes/footer.php'); ?>
