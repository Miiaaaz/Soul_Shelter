<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<?php

// Process donation form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['donation_submitted'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $donationType = mysqli_real_escape_string($conn, $_POST['donationType']);
    $paymentMethod = mysqli_real_escape_string($conn, $_POST['payment']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $taxReceipt = isset($_POST['taxReceipt']) ? 1 : 0;
    
    $sql = "INSERT INTO donations (full_name, email, anonymous, amount, donation_type, payment_method, message, tax_receipt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiissii", $fullName, $email, $anonymous, $amount, $donationType, $paymentMethod, $message, $taxReceipt);
    
    if ($stmt->execute()) {
        $donation_success = true;
        $donation_id = $conn->insert_id;
    } else {
        $donation_error = "Error processing donation: " . $conn->error;
    }
    $stmt->close();
}

// Process volunteer form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['volunteer_submitted'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $availability = implode(", ", $_POST['days']);
    $preferredTimes = implode(", ", $_POST['times']);
    $interests = implode(", ", $_POST['interests']);
    $whyVolunteer = mysqli_real_escape_string($conn, $_POST['why_volunteer']);
    $emergencyName = mysqli_real_escape_string($conn, $_POST['emergency_name']);
    $emergencyRelation = mysqli_real_escape_string($conn, $_POST['emergency_relation']);
    $emergencyPhone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
    
    $sql = "INSERT INTO volunteers (name, email, phone, age, address, availability, preferred_times, interests, why_volunteer, emergency_name, emergency_relation, emergency_phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssssss", $name, $email, $phone, $age, $address, $availability, $preferredTimes, $interests, $whyVolunteer, $emergencyName, $emergencyRelation, $emergencyPhone);
    
    if ($stmt->execute()) {
        $volunteer_success = true;
        $volunteer_id = $conn->insert_id;
    } else {
        $volunteer_error = "Error processing volunteer application: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Donations & Volunteering | Soul Shelter</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4CAF50;
      --secondary: #FF6B6B;
      --accent: #FFD166;
      --light: #F7FFF7;
      --dark: #292F36;
      --text: #333333;
    }
    
    body {
      font-family: 'Lato', sans-serif;
      line-height: 1.6;
      color: var(--text);
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    section {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      padding: 30px;
      margin-bottom: 40px;
    }
    
    h1, h2 {
      font-family: 'Fredoka', sans-serif;
      color: var(--primary);
    }
    
    h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      text-align: center;
    }
    
    h2 {
      font-size: 1.8rem;
      margin: 30px 0 20px;
      border-bottom: 2px solid var(--accent);
      padding-bottom: 10px;
    }
    
    .intro, .sub-intro {
      font-size: 1.1rem;
      text-align: center;
      max-width: 800px;
      margin: 0 auto 30px;
    }
    
    .sub-intro {
      font-weight: 700;
      color: var(--dark);
    }
    
    form {
      max-width: 700px;
      margin: 0 auto;
      padding: 20px;
      background: var(--light);
      border-radius: 8px;
    }
    
    label {
      display: block;
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: 2px solid #ddd;
      border-radius: 6px;
      font-size: 16px;
      transition: all 0.3s;
    }
    
    input:focus, select:focus, textarea:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }
    
    textarea {
      min-height: 100px;
      resize: vertical;
    }
    
    fieldset {
      border: 2px solid #eee;
      border-radius: 6px;
      padding: 15px;
      margin-bottom: 20px;
    }
legend {
      font-weight: 600;
      color: var(--primary);
      padding: 0 10px;
    }
    
    input[type="checkbox"] {
      margin-right: 10px;
    }
    
    button {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 15px 30px;
      font-size: 18px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s;
      display: block;
      width: 100%;
      margin-top: 20px;
    }
    
    button:hover {
      background-color: #3e8e41;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    
    .volunteer-btn {
      background-color: var(--secondary);
      max-width: 300px;
      margin: 30px auto;
    }
    
    .volunteer-btn:hover {
      background-color: #e05555;
    }
    
    .thankyou-note {
      text-align: center;
      font-size: 1.2rem;
      color: var(--primary);
      margin-top: 30px;
      font-weight: 600;
    }
    
    .volunteer-roles, .requirements {
      list-style-type: none;
      padding: 0;
    }
    
    .volunteer-roles li, .requirements li {
      padding: 10px 15px;
      margin-bottom: 10px;
      background: var(--light);
      border-left: 4px solid var(--accent);
    }
    
    hr {
      border: 0;
      height: 2px;
      background: linear-gradient(to right, transparent, var(--primary), transparent);
      margin: 50px 0;
    }
    
    .success-message {
      background-color: #d4edda;
      color: #155724;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      text-align: center;
    }
    
    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      text-align: center;
    }
    
    @media (max-width: 768px) {
      h1 {
        font-size: 2rem;
      }
      
      section {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

 <div class="container">
    <section class="donation-section">
      <h1>Your Kindness Can Save a Life.</h1>
      <p class="intro">
        At Soul Shelter, every donation goes directly toward caring for stray and abandoned animals in need. From vaccinations and food to warm beds and second chances—your support keeps tails wagging and hearts full.
      </p>
      <p class="sub-intro">
        Whether it's a one-time gift or a monthly contribution, your generosity helps us rescue, rehabilitate, and rehome animals who deserve a loving future.
      </p>
      
      <?php if (isset($donation_success)): ?>
        <div class="success-message">
          Thank you for your donation! Your reference number is #<?php echo $donation_id; ?>. We've sent a confirmation to your email.
        </div>
      <?php elseif (isset($donation_error)): ?>
        <div class="error-message"><?php echo $donation_error; ?></div>
      <?php endif; ?>
      
      <form id="donation-form" method="POST" action="">
        <h2>Make a Donation — Help Us Save More Lives</h2>
        <label>Full Name: <input type="text" name="fullName" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label><input type="checkbox" name="anonymous"> Donate Anonymously</label>
        
        <label>Donation Amount (MYR):
          <select name="amount" id="amount-select">
            <option value="10">RM10</option>
            <option value="50">RM50</option>
            <option value="100">RM100</option>
            <option value="custom">Custom</option>
          </select>
          <input type="number" name="customAmount" id="custom-amount" placeholder="Enter amount" style="display: none;">
        </label>

        <label>Donation Type:
          <select name="donationType">
            <option value="once">Give Once</option>
            <option value="monthly">Give Monthly</option>
          </select>
        </label>

        <label>Payment Method:
          <select name="payment">
            <option value="card">Credit/Debit Card</option>
            <option value="fpx">Online Banking / FPX</option>
            <option value="ewallet">E-Wallets</option>
            <option value="manual">Manual Bank Transfer</option>
          </select>
        </label>

        <label>Personal Message (Optional):
          <textarea name="message" placeholder="Leave a message of hope..."></textarea>
        </label>

        <label><input type="checkbox" name="taxReceipt"> I would like a tax receipt (Malaysian taxpayers only)</label>

        <label><input type="checkbox" name="agreement" required> I agree to the Privacy Policy and Terms</label>

        <input type="hidden" name="donation_submitted" value="1">
        <button type="submit">Donate Now</button>
      </form>

      <p class="thankyou-note">
        🙏 Thank You for Choosing to Help — Together, we are Soul Shelter.
      </p>
    </section>

    <hr /> 

    <section class="volunteer-section">
      <h1>Join Us – Volunteer at Soul Shelter</h1>
      <p>
        At Soul Shelter, every rescued paw, wagging tail, and hopeful pair of eyes depends on the kindness of people like you.
        Whether you're an animal lover or someone with time to share, we welcome you into our shelter family. Be the reason someone wags their tail today.
      </p>

      <h2>Volunteer Roles & Responsibilities</h2>
      <ul class="volunteer-roles">
        <li><strong>🧽 Animal Care Assistant:</strong> Clean cages, bathe animals, assist feeding</li>
        <li><strong>🐕 Dog Walker & Cat Companion:</strong> Socialize, walk, play</li>
        <li><strong>🎉 Event Volunteer:</strong> Help at drives and fundraisers</li>
        <li><strong>🗅️ Social Media Helper:</strong> Manage content and outreach</li>
        <li><strong>📷 Photography & Content:</strong> Take photos/videos</li>
        <li><strong>🗞️ Admin Help:</strong> Support paperwork and guest interactions</li>
      </ul>

      <h2>Volunteer Requirements</h2>
      <ul class="requirements">
        <li>Age 16+ (or with parental consent)</li>
        <li>Kindness and patience</li>
        <li>Commitment: Min. 4 hours/month</li>
        <li>Attend orientation</li>
      </ul>

      <button onclick="document.getElementById('volunteer-form').scrollIntoView({ behavior: 'smooth' });" class="volunteer-btn">
        Become a Volunteer
      </button>

      <?php if (isset($volunteer_success)): ?>
        <div class="success-message">
          Thank you for your volunteer application! We'll contact you soon. Your reference number is #<?php echo $volunteer_id; ?>.
        </div>
      <?php elseif (isset($volunteer_error)): ?>
        <div class="error-message"><?php echo $volunteer_error; ?></div>
      <?php endif; ?>

      <form id="volunteer-form" method="POST" action="">
        <h2>Soul Shelter Volunteer Application Form</h2>

        <label>Full Name: <input type="text" name="name" required></label>
        <label>Email Address: <input type="email" name="email" required></label>
        <label>Phone Number: <input type="tel" name="phone" required></label>
        <label>Age: <input type="number" name="age" required min="16"></label>
        <label>Address: <input type="text" name="address"></label>

        <fieldset>
          <legend>Availability</legend>
          <label><input type="checkbox" name="days[]" value="Mon"> Monday</label>
          <label><input type="checkbox" name="days[]" value="Tue"> Tuesday</label>
          <label><input type="checkbox" name="days[]" value="Wed"> Wednesday</label>
          <label><input type="checkbox" name="days[]" value="Thu"> Thursday</label>
          <label><input type="checkbox" name="days[]" value="Fri"> Friday</label>
          <label><input type="checkbox" name="days[]" value="Sat"> Saturday</label>
          <label><input type="checkbox" name="days[]" value="Sun"> Sunday</label>
        </fieldset>

        <fieldset>
          <legend>Preferred Time(s)</legend>
          <label><input type="checkbox" name="times[]" value="Morning"> Morning</label>
          <label><input type="checkbox" name="times[]" value="Afternoon"> Afternoon</label>
          <label><input type="checkbox" name="times[]" value="Evening"> Evening</label>
          <label><input type="checkbox" name="times[]" value="Flexible"> Flexible</label>
        </fieldset>

    <fieldset>
          <legend>Areas of Interest</legend>
          <label><input type="checkbox" name="interests[]" value="Animal Care"> Animal Care</label>
          <label><input type="checkbox" name="interests[]" value="Dog Walking"> Dog Walking / Cat Socializing</label>
          <label><input type="checkbox" name="interests[]" value="Fundraising"> Fundraising Events</label>
          <label><input type="checkbox" name="interests[]" value="Social Media"> Social Media / Content</label>
          <label><input type="checkbox" name="interests[]" value="Photography"> Photography & Video</label>
          <label><input type="checkbox" name="interests[]" value="Admin"> Administrative Support</label>
          <label><input type="checkbox" name="interests[]" value="Any"> Help wherever needed</label>
        </fieldset>

        <label>Why would you like to volunteer?
          <textarea name="why_volunteer" placeholder="Share your story..."></textarea>
        </label>

        <fieldset>
          <legend>Emergency Contact</legend>
          <label>Name: <input type="text" name="emergency_name"></label>
          <label>Relationship: <input type="text" name="emergency_relation"></label>
          <label>Phone: <input type="tel" name="emergency_phone"></label>
        </fieldset>

        <label><input type="checkbox" name="confirm_info" required> I confirm my info is accurate</label>
        <label><input type="checkbox" name="agree_guidelines" required> I agree to follow shelter guidelines</label>
        <label><input type="checkbox" name="understand_unpaid" required> I understand this is unpaid work</label>
        <label><input type="checkbox" name="attend_orientation" required> I will attend an orientation</label>

        <input type="hidden" name="volunteer_submitted" value="1">
        <button type="submit">Submit Volunteer Form</button>
      </form>
    </section>
  </div>

  <?php include('includes/footer.php'); ?>

  <script>
    // Show custom amount field when "Custom" is selected
    document.getElementById('amount-select').addEventListener('change', function() {
      const customAmountField = document.getElementById('custom-amount');
      customAmountField.style.display = this.value === 'custom' ? 'block' : 'none';
      if (this.value !== 'custom') customAmountField.value = '';
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>    