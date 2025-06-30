<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

// Handle role update
if (isset($_POST['update_role'])) {
  $user_id = $_POST['user_id'];
  $new_role = $_POST['role'];
  $conn->query("UPDATE users SET role = '$new_role' WHERE user_id = $user_id");
  header("Location: manage-users.php?msg=Role updated");
  exit;
}
?>

<main class="container" data-aos="fade-up">
  <h1>👥 Manage Users</h1>

  <?php
  $sql = "SELECT * FROM users ORDER BY role DESC, username ASC";
  $result = $conn->query($sql);
  ?>

  <table class="user-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Role</th>
        <th>Change Role</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><strong><?= $row['role'] ?></strong></td>
        <td>
          <form method="POST" style="display:flex; gap:0.5rem;">
            <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
            <select name="role">
              <option value="user" <?= $row['role'] == 'user' ? 'selected' : '' ?>>User</option>
              <option value="admin" <?= $row['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" name="update_role" class="btn small-btn">Update</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<style>
.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 2rem;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.user-table th, .user-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.user-table th {
  background: #ffe0c0;
  color: #333;
}

.user-table tr:hover {
  background: #fff5eb;
}

select, .btn.small-btn {
  padding: 0.4rem 0.6rem;
  font-size: 0.9rem;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.btn.small-btn {
  background: #ff7043;
  color: white;
  border: none;
  cursor: pointer;
}

.btn.small-btn:hover {
  background: #e95c2f;
}
</style>

<?php include('../includes/footer.php'); ?>
