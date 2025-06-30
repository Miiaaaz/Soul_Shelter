<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['theme'] = $user['theme_preference'];

            // Redirect to dashboard
            header("Location: dashboard.php?msg=Login successful!&type=success");
            exit;
        } else {
            header("Location: login.php?msg=Incorrect password.&type=error");
            exit;
        }
    } else {
        header("Location: login.php?msg=Username not found.&type=error");
        exit;
    }
}
?>
