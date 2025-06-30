<?php
// includes/db.php

$host = 'localhost';       // Guna localhost untuk XAMPP
$user = 'root';            // Default user XAMPP
$password = '';            // Tiada kata laluan untuk root dalam XAMPP
$database = 'animalshelter'; // Nama pangkalan data anda

// Sambungan ke database
$conn = new mysqli($host, $user, $password, $database);

// Semak ralat
if ($conn->connect_error) {
    die("Sambungan ke pangkalan data gagal: " . $conn->connect_error);
}

// Anda boleh letak charset jika mahu (UTF-8)
$conn->set_charset("utf8mb4");
?>
