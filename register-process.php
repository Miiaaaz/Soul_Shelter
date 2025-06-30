<?php
include('includes/db.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $fullname = trim($_POST['fullname']);
    $phone    = trim($_POST['phone']);

    // Basic validation
    if ($password !== $confirm) {
        header("Location: register.php?msg=Passwords do not match&type=error");
        exit;
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?msg=Username already taken&type=error");
        exit;
    }

    // Hash the password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password, name, phone, role) VALUES (?, ?, ?, ?, 'user')");
    $stmt->bind_param("ssss", $username, $hashed, $fullname, $phone);

    if ($stmt->execute()) {
        header("Location: login.php?msg=Account created successfully! Please log in.&type=success");
        exit;
    } else {
        header("Location: register.php?msg=Registration failed. Please try again.&type=error");
        exit;
    }
}
?>
