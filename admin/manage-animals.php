<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');
?>

<style>
  .animal-table .actions i {
    font-size: 1.2rem;
    margin: 0 8px;
    cursor: pointer;
    transition: transform 0.2s;
  }

  .icon-edit { color: #ffa15f; }
  .icon-delete { color: #e74c3c; }
  .animal-table .actions i:hover { transform: scale(1.3); }

  .font-size-controls {
    margin: 10px 0;
  }

  .font-size-controls button {
    margin-right: 5px;
    padding: 5px 10px;
    border: none;
    background-color: #eee;
    cursor: pointer;
    border-radius: 5px;
  }

  .font-size-controls button:hover {
    background-color: #ccc;
  }
</style>

<main class="container" data-aos="fade-in">
  <h1>🐾 Manage Animals</h1>
  <a href="animal-add.php" class="btn">➕ Add New Animal</a>

  <!-- Filter/Search Form -->
  <form method="GET" class="filter-form" data-aos="fade-up">
    <input type="text" name="search" placeholder="Search by name, species, breed..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
    <select name="species">
      <option value="">All Species</option>
      <?php
      $speciesList = $conn->query("SELECT DISTINCT species FROM animals");
      while ($s = $speciesList->fetch_assoc()):
        $selected = ($_GET['species'] ?? '') == $s['species'] ? 'selected' : '';
        echo "<option value=\"{$s['species']}\" $selected>" . htmlspecialchars($s['species']) . "</option>";
      endwhile;
      ?>
    </select>
    <button type="submit" class="btn small-btn">Filter</button>
  </form>

  <!-- Font Size Controls -->
  <div class="font-size-controls" data-aos="fade-up">
    <strong>Font Size:</strong>
    <button onclick="adjustFontSize('small')">A-</button>
    <button onclick="adjustFontSize('medium')">A</button>
    <button onclick="adjustFontSize('large')">A+</button>
  </div>

  <div class="card-box">
    <table id="animalTable" class="animal-table display">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Species</th>
          <th>Breed</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $where = [];
        $params = [];
        $types = '';

        if (!empty($_GET['search'])) {
          $search = '%' . $_GET['search'] . '%';
          $where[] = "(name LIKE ? OR species LIKE ? OR breed LIKE ?)";
          $params[] = $search; $params[] = $search; $params[] = $search;
          $types .= 'sss';
        }

        if (!empty($_GET['species'])) {
          $where[] = "species = ?";
          $params[] = $_GET['species'];
          $types .= 's';
        }

        $query = "SELECT * FROM animals";
        if ($where) {
          $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY date_added DESC";

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
          $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
        ?>
        <tr data-aos="fade-up">
          <td><img src="../assets/images/<?php echo htmlspecialchars($row['image']); ?>" class="thumb"></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['species']); ?></td>
          <td><?php echo htmlspecialchars($row['breed']); ?></td>
          <td><?php echo $row['age']; ?> yrs</td>
          <td><?php echo ucfirst($row['gender']); ?></td>
          <td><?php echo ucfirst($row['status']); ?></td>
          <td class="actions">
            <a href="animal-edit.php?id=<?= $row['animal_id'] ?>" title="Edit"><i class="fa-solid fa-pen-to-square icon-edit"></i></a>
            <a href="javascript:void(0);" onclick="confirmDelete(<?= $row['animal_id'] ?>)" class="delete-btn" title="Delete"><i class="fa-solid fa-trash-can icon-delete"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- External Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom Script -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#animalTable').DataTable({
      "pageLength": 10,
      "lengthMenu": [10, 20, 50],
      "columnDefs": [
        { orderable: false, targets: 0 }, // Image
        { orderable: false, targets: 7 }  // Actions
      ]
    });
  });

  function adjustFontSize(size) {
    let table = document.getElementById('animalTable');
    if (size === 'small') {
      table.style.fontSize = '0.8rem';
    } else if (size === 'medium') {
      table.style.fontSize = '1rem';
    } else if (size === 'large') {
      table.style.fontSize = '1.2rem';
    }
  }

  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This will permanently delete the animal record.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `animal-delete.php?id=${id}`;
      }
    });
  }
</script>

<?php include('../includes/footer.php'); ?>
