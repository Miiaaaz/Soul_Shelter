<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php?msg=Access denied&type=error");
  exit;
}

include('../includes/db.php');
include('../includes/header.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $species = ($_POST['species'] === 'Other') ? $_POST['species_other'] : $_POST['species'];
  $breed = ($_POST['species'] === 'Other') ? $_POST['breed_other'] : $_POST['breed'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $status = $_POST['status'];
  $description = $_POST['description'];

  $image = null;
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $filename = date("YmdHis") . "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $filename);
    $image = $filename;
  }

  $stmt = $conn->prepare("INSERT INTO animals (name, species, breed, age, gender, status, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssss", $name, $species, $breed, $age, $gender, $status, $description, $image);
  $stmt->execute();

  header("Location: manage-animals.php?msg=Animal added successfully&type=success");
  exit;
}
?>

<main class="container" data-aos="fade-up">
  <h1>➕ Add New Animal</h1>
  <div class="card-box">
    <form action="animal-add.php" method="POST" enctype="multipart/form-data" class="animal-form">
      <label>Name</label>
      <input type="text" name="name" required>

      <label>Species</label>
      <select name="species" id="speciesSelect" required>
        <option value="">-- Select Species --</option>
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
        <option value="Rabbit">Rabbit</option>
        <option value="Bird">Bird</option>
        <option value="Hamster">Hamster</option>
        <option value="GuineaPig">Guinea Pig</option>
        <option value="Ferret">Ferret</option>
        <option value="Reptile">Reptile</option>
        <option value="Fish">Fish</option>
        <option value="Tortoise">Tortoise</option>
        <option value="Parrot">Parrot</option>
        <option value="Mouse">Mouse</option>
        <option value="Rat">Rat</option>
        <option value="Hedgehog">Hedgehog</option>
        <option value="Chinchilla">Chinchilla</option>
        <option value="Other">Other</option>
      </select>

      <input type="text" name="species_other" id="speciesOther" placeholder="Enter species..." style="display:none;">

      <label>Breed</label>
      <select name="breed" id="breedSelect" required></select>
      <input type="text" name="breed_other" id="breedOther" placeholder="Enter breed..." style="display:none;">

      <label>Age</label>
      <input type="number" name="age" required>

      <label>Gender</label>
      <select name="gender">
        <option value="jantan">Male</option>
        <option value="betina">Female</option>
      </select>

      <label>Status</label>
      <select name="status">
        <option value="available">Available</option>
        <option value="adopted">Adopted</option>
      </select>

      <label>Image (optional)</label>
      <input type="file" name="image" accept="image/*">

      <label>Description</label>
      <textarea name="description" rows="4"></textarea>

      <button type="submit" class="btn">Save Animal</button>
      <a href="manage-animals.php" class="btn btn-outline">Cancel</a>
    </form>
  </div>
</main>

<style>
.container {
  padding: 2rem;
  max-width: 800px;
  margin: auto;
}

.card-box {
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.animal-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.animal-form label {
  font-weight: bold;
  color: #444;
}

.animal-form input,
.animal-form select,
.animal-form textarea {
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
}

.animal-form input:focus,
.animal-form select:focus,
.animal-form textarea:focus {
  border-color: #ffa15f;
  box-shadow: 0 0 5px rgba(255, 161, 95, 0.4);
  outline: none;
}

.animal-form button,
.animal-form a.btn-outline {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  border-radius: 6px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
}

.animal-form .btn {
  background: #ff7043;
  color: white;
  border: none;
}

.animal-form .btn:hover {
  background: #ff5722;
}

.animal-form .btn-outline {
  border: 2px solid #ff7043;
  color: #ff7043;
  background: transparent;
  margin-left: 1rem;
}

.animal-form .btn-outline:hover {
  background: #ff7043;
  color: white;
}

body.dark-mode .card-box {
  background: #2a2a2a;
  color: white;
}

body.dark-mode .animal-form input,
body.dark-mode .animal-form select,
body.dark-mode .animal-form textarea {
  background-color: #444;
  color: white;
  border: 1px solid #666;
}

body.dark-mode .animal-form label {
  color: #eee;
}
</style>

<script>
const breedOptions = {
  Dog: [
    "Golden Retriever", "Labrador Retriever", "Poodle", "Bulldog", "Beagle", 
    "Shih Tzu", "German Shepherd", "Chihuahua", "Dachshund", "Pomeranian", "Mixed"
  ],
  Cat: [
    "Persian", "Siamese", "Maine Coon", "British Shorthair", "Bengal", 
    "Ragdoll", "Scottish Fold", "Sphynx", "Abyssinian", "Mixed"
  ],
  Rabbit: [
    "Lop", "Dutch", "Rex", "Flemish Giant", "Mini Rex", "Netherland Dwarf", 
    "Lionhead", "Harlequin", "Mixed"
  ],
  Bird: [
    "Parakeet", "Cockatiel", "Canary", "Finch", "Lovebird", 
    "African Grey", "Budgerigar", "Conure", "Mixed"
  ],
  Hamster: [
    "Syrian", "Dwarf Campbell", "Winter White", "Roborovski", "Chinese", "Mixed"
  ],
  GuineaPig: [
    "American", "Abyssinian", "Peruvian", "Teddy", "Silkie", "Rex", "Mixed"
  ],
  Ferret: [
    "Standard", "Albino", "Silver", "Sable", "Mixed"
  ],
  Reptile: [
    "Bearded Dragon", "Leopard Gecko", "Crested Gecko", "Corn Snake", "Ball Python", "Turtle", "Mixed"
  ],
  Fish: [
    "Betta", "Goldfish", "Guppy", "Tetra", "Angelfish", "Molly", "Platy", "Mixed"
  ],
  Tortoise: [
    "Russian Tortoise", "Sulcata Tortoise", "Greek Tortoise", "Leopard Tortoise", "Mixed"
  ],
  Parrot: [
    "African Grey", "Macaw", "Amazon", "Cockatoo", "Quaker", "Eclectus", "Mixed"
  ],
  Mouse: [
    "Fancy Mouse", "Hairless Mouse", "Spiny Mouse", "Mixed"
  ],
  Rat: [
    "Fancy Rat", "Dumbo Rat", "Hairless Rat", "Rex Rat", "Mixed"
  ],
  Hedgehog: [
    "African Pygmy", "Algerian", "Salt and Pepper", "Mixed"
  ],
  Chinchilla: [
    "Standard", "White Mosaic", "Black Velvet", "Beige", "Mixed"
  ]
};


const speciesSelect = document.getElementById("speciesSelect");
const breedSelect = document.getElementById("breedSelect");
const speciesOther = document.getElementById("speciesOther");
const breedOther = document.getElementById("breedOther");

function updateBreedDropdown(species) {
  breedSelect.innerHTML = "";
  if (breedOptions[species]) {
    breedOptions[species].forEach(b => {
      const opt = document.createElement("option");
      opt.value = b;
      opt.text = b;
      breedSelect.appendChild(opt);
    });
    breedSelect.style.display = "block";
    breedOther.style.display = "none";
  } else {
    breedSelect.style.display = "none";
    breedOther.style.display = "block";
  }
}

speciesSelect.addEventListener("change", function () {
  const selected = this.value;
  if (selected === "Other") {
    speciesOther.style.display = "block";
    breedSelect.style.display = "none";
    breedOther.style.display = "block";
  } else {
    speciesOther.style.display = "none";
    updateBreedDropdown(selected);
  }
});
</script>

<?php include('../includes/footer.php'); ?>
