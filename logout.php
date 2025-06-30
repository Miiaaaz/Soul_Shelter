<?php
session_start();           // Start the session
session_unset();           // Unset all session variables
session_destroy();         // Destroy the session

// Optional: clear cookies if you use them

// Redirect to home page with a friendly message
header("Location: index.php?msg=You have been logged out successfully.&type=success");
exit;
?>
