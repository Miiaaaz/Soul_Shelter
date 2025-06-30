<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: manage-animals.php?msg=Animal not found&type=error");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM animals WHERE animal_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();

if (!$animal) {
  header("Location: manage-animals.php?msg=Animal not found&type=error");
  exit;
}

// Handle update form submission
$updateSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $species = $_POST['species'];
  $breed = $_POST['breed'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $status = $_POST['status'];
  $description = $_POST['description'];
  $image = $animal['image']; // default to existing

  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $filename = date("YmdHis") . "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $filename);
    $image = $filename;
  }

  $update = $conn->prepare("UPDATE animals SET name=?, species=?, breed=?, age=?, gender=?, status=?, description=?, image=? WHERE animal_id=?");
  $update->bind_param("ssssssssi", $name, $species, $breed, $age, $gender, $status, $description, $image, $id);
  $update->execute();

  $updateSuccess = true;

  // Refresh animal data after update
  $stmt = $conn->prepare("SELECT * FROM animals WHERE animal_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $animal = $result->fetch_assoc();
}
?>

<main class="container" data-aos="fade-up">
  <h1>✏️ Edit Animal</h1>

  <?php if ($updateSuccess): ?>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        alert('Animal updated successfully!');
      });
    </script>
  <?php endif; ?>

  <div class="card-box">
    <form action="animal-edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="animal-form">
      <label>Name</label>
      <input type="text" name="name" required value="<?php echo htmlspecialchars($animal['name']); ?>">

      <label>Species</label>
      <input type="text" name="species" required value="<?php echo htmlspecialchars($animal['species']); ?>">

      <label>Breed</label>
      <input type="text" name="breed" value="<?php echo htmlspecialchars($animal['breed']); ?>">

      <label>Age</label>
      <input type="number" name="age" required value="<?php echo htmlspecialchars($animal['age']); ?>">

      <label>Gender</label>
      <select name="gender">
        <option value="jantan" <?= $animal['gender'] == 'jantan' ? 'selected' : '' ?>>Male</option>
        <option value="betina" <?= $animal['gender'] == 'betina' ? 'selected' : '' ?>>Female</option>
      </select>

      <label>Status</label>
      <select name="status">
        <option value="available" <?= $animal['status'] == 'available' ? 'selected' : '' ?>>Available</option>
        <option value="adopted" <?= $animal['status'] == 'adopted' ? 'selected' : '' ?>>Adopted</option>
      </select>

      <label>Current Image</label><br>
      <?php if (!empty($animal['image'])): ?>
        <img src="../assets/images/<?php echo $animal['image']; ?>"
             alt="Current Image"
             style="max-width: 200px; max-height: 150px; object-fit: contain; border-radius: 8px; display: block;">
      <?php else: ?>
        <p><i>No image uploaded</i></p>
      <?php endif; ?>

      <label>Replace Image (optional)</label>
      <input type="file" name="image" accept="image/*">

      <label>Description</label>
      <textarea name="description" rows="4"><?php echo htmlspecialchars($animal['description']); ?></textarea>

      <button type="submit" class="btn">Update Animal</button>
      <a href="manage-animals.php" class="btn btn-outline">Cancel</a>
    </form>
  </div>
</main>

<script>
const breedOptions = {
  Dog: ["Golden Retriever", "Labrador", "Poodle", "Mixed"],
  Cat: ["Persian", "Siamese", "Maine Coon", "Mixed"],
  Rabbit: ["Lop", "Dutch", "Rex", "Mixed"],
  Bird: ["Parakeet", "Cockatiel", "Canary", "Mixed"]
};

const speciesSelect = document.getElementById("speciesSelect");
const speciesOther = document.getElementById("speciesOther");
const breedSelect = document.getElementById("breedSelect");
const breedOther = document.getElementById("breedOther");

// Insert breeds based on selected species
function updateBreedDropdown(species, selectedBreed = "") {
  breedSelect.innerHTML = "";
  if (breedOptions[species]) {
    breedOptions[species].forEach(b => {
      const opt = document.createElement("option");
      opt.value = b;
      opt.text = b;
      if (b === selectedBreed) opt.selected = true;
      breedSelect.appendChild(opt);
    });
    breedSelect.style.display = "block";
    breedOther.style.display = "none";
  } else {
    breedSelect.style.display = "none";
    breedOther.style.display = "block";
  }
}

// On page load, handle initial state
document.addEventListener("DOMContentLoaded", function () {
  const currentSpecies = speciesSelect.value;
  const currentBreed = breedSelect.getAttribute("data-current");

  if (currentSpecies === "Other") {
    speciesOther.style.display = "block";
    breedSelect.style.display = "none";
    breedOther.style.display = "block";
  } else {
    speciesOther.style.display = "none";
    updateBreedDropdown(currentSpecies, currentBreed);
  }
});

// On change of species dropdown
speciesSelect.addEventListener("change", function () {
  if (this.value === "Other") {
    speciesOther.style.display = "block";
    breedSelect.style.display = "none";
    breedOther.style.display = "block";
  } else {
    speciesOther.style.display = "none";
    updateBreedDropdown(this.value);
  }
});
</script>

<?php include('../includes/footer.php'); ?>
