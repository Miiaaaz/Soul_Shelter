<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}
include('../includes/db.php');

$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if (!$id || !in_array($status, ['approved', 'rejected'])) {
  header("Location: review-requests.php?msg=Invalid request&type=error");
  exit;
}

// Get animal ID from the request
$stmt = $conn->prepare("SELECT animal_id FROM adoptions WHERE adoption_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
  header("Location: review-requests.php?msg=Request not found&type=error");
  exit;
}

$animal_id = $result['animal_id'];

// Update the request status
$update = $conn->prepare("UPDATE adoptions SET status = ? WHERE adoption_id = ?");
$update->bind_param("si", $status, $id);
$update->execute();

// If approved, also update the animal's status
if ($status === 'approved') {
  $updateAnimal = $conn->prepare("UPDATE animals SET status = 'adopted' WHERE animal_id = ?");
  $updateAnimal->bind_param("i", $animal_id);
  $updateAnimal->execute();
}

header("Location: review-requests.php?msg=Request $status successfully&type=success");
exit;
?>
