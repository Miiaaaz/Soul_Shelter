<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: manage-animals.php?msg=Invalid request&type=error");
  exit;
}

// Check for pending adoptions
$check = $conn->prepare("SELECT COUNT(*) as total FROM adoptions WHERE animal_id = ? AND status = 'pending'");
$check->bind_param("i", $id);
$check->execute();
$checkResult = $check->get_result()->fetch_assoc();

if ($checkResult['total'] > 0) {
  header("Location: manage-animals.php?msg=Cannot delete animal with pending adoptions&type=error");
  exit;
}

// Optional: remove image
$stmt = $conn->prepare("SELECT image FROM animals WHERE animal_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();

if ($animal && !empty($animal['image'])) {
  $imagePath = "../assets/images/" . $animal['image'];
  if (file_exists($imagePath)) {
    unlink($imagePath);
  }
}

// Delete animal
$delete = $conn->prepare("DELETE FROM animals WHERE animal_id = ?");
$delete->bind_param("i", $id);
$delete->execute();

header("Location: manage-animals.php?msg=Animal deleted successfully&type=success");
exit;
?>
