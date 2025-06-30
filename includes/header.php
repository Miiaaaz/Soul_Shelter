<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Soul Shelter</title>
  <link rel="stylesheet" href="/animalshelter/assets/css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<style>
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2rem;
    flex-wrap: wrap;
    background: #fff;
  }

  .nav-links {
    display: flex;
    justify-content: center;
    flex: 1;
    list-style: none;
    gap: 1.2rem;
    padding: 0;
    margin: 0;
  }

  .navbar .logo {
    flex: 0 0 auto;
    margin-right: 1rem;
  }

  .navbar-right {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .nav-links li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: background 0.3s;
  }

  .nav-links li a:hover {
    background: #ff7043;
    color: white;
  }
/* Base Styles */
:root {
  --primary: #6a4c93;
  --secondary: #8a5a44;
  --accent: #f8a5c2;
  --light: #f7f1e3;
  --dark: #2c3e50;
  --success: #2ecc71;
  --info: #3498db;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
  color: var(--dark);
  background-color: #f9f9f9;
  margin: 0;
  padding: 0;
}

main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Header Section */
.directory-search {
  background: white;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.directory-search input,
.directory-search select {
  padding: 12px 15px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 16px;
  flex: 1;
  min-width: 200px;
  transition: all 0.3s ease;
}

.directory-search input:focus,
.directory-search select:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(106, 76, 147, 0.2);
}

.directory-search input {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%238a5a44' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: 15px center;
  background-size: 20px;
  padding-left: 45px;
}

/* Shelter List */
.shelter-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 25px;
  margin-bottom: 40px;
}

.shelter-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-top: 4px solid var(--accent);
}

.shelter-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.shelter-card h3 {
  margin: 0;
  padding: 20px 20px 10px;
  color: var(--primary);
}

.shelter-card h3 a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}

.shelter-card h3 a:hover {
  color: var(--secondary);
  text-decoration: underline;
}

.shelter-card p {
  margin: 0;
  padding: 0 20px 15px;
  color: var(--dark);
}

.shelter-card p:first-of-type {
  color: var(--secondary);
  font-weight: 500;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
  margin-bottom: 10px;
}

/* Map Section */
.map-section {
  margin-top: 40px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  border: 1px solid #e0e0e0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .directory-search {
    flex-direction: column;
  }
  
  .shelter-list {
    grid-template-columns: 1fr;
  }
}

/* Animation for filtered cards */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.shelter-card {
  animation: fadeIn 0.5s ease forwards;
}

/* Add some cat-themed decorative elements */
.directory-search::before {
  content: "🐾";
  font-size: 24px;
  position: absolute;
  right: 30px;
  top: 20px;
  opacity: 0.2;
}
  
</style>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="/animalshelter/index.php"><i class="fa-solid fa-paw"></i> Soul Shelter</a>
      </div>
      <button class="hamburger" id="hamburger">&#9776;</button>
      <ul class="nav-links" id="nav-menu">
        <li><a href="/animalshelter/index.php"><i class="fa-solid fa-house"></i> Home</a></li>

        <?php if (isset($_SESSION['username'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="/animalshelter/dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="/animalshelter/admin/manage-animals.php"><i class="fa-solid fa-dog"></i> Manage Animals</a></li>
            <li><a href="/animalshelter/admin/review-requests.php"><i class="fa-solid fa-file-circle-check"></i> Requests</a></li>
          <?php elseif ($_SESSION['role'] === 'user'): ?>
            <li><a href="/animalshelter/user/view-animals.php"><i class="fa-solid fa-paw"></i> View Animals</a></li>
            <li><a href="/animalshelter/user/my-requests.php"><i class="fa-solid fa-folder-open"></i> My Requests</a></li>
          <?php endif; ?>
        <?php else: ?>
          <li><a href="/animalshelter/login.php"><i class="fa-solid fa-dog"></i> Adopt</a></li>
          <li><a href="/animalshelter/about.php"><i class="fa-solid fa-circle-info"></i> About</a></li>
          <li><a href="/animalshelter/shelter_directory.php"><i class="fa-solid fa-building"></i> Shelters</a></li>
          <li><a href="/animalshelter/contact.php"><i class="fa-solid fa-envelope"></i> Contact</a></li>
          <li><a href="/animalshelter/donations_and_volunteer.php"><i class="fa-solid fa-heart"></i> Donate/Volunteer</a></li>
          <li><a href="/animalshelter/FAQ.php"><i class="fa-solid fa-question"></i> FAQ</a></li>
          <li><a href="/animalshelter/Our blog.php"><i class="fa-solid fa-newspaper"></i> Blog</a></li>

        <?php endif; ?>
      </ul>

      <div class="navbar-right">
        <?php if (isset($_SESSION['username'])): ?>
          <span class="user-info">
            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['username']); ?>
          </span>
          <button onclick="confirmLogout()" class="btn btn-outline small-btn">Logout</button>
        <?php else: ?>
          <a href="/animalshelter/login.php" class="btn btn-outline small-btn">Login</a>
        <?php endif; ?>

        <button id="theme-toggle" title="Toggle Theme">🌙</button>
      </div>
    </nav>
  </header>

  <script src="/animalshelter/assets/js/theme-toggle.js"></script>
  <script>
    document.getElementById("hamburger").onclick = function () {
      document.getElementById("nav-menu").classList.toggle("active");
    };

    function confirmLogout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = "/animalshelter/logout.php";
      }
    }

   
  </script>
