<?php
include('includes/header.php');
?>

<main class="container about-page" data-aos="fade-up">
  <div class="about-card">
    <h1>🐾 About Us</h1>
    <p>
      Welcome to <strong>Soul Shelter</strong> – At Soul Shelter, we believe every animal deserves a second chance, a safe space where healing begins and love never ends. Our shelter is more than just a refuge; it’s a soulful sanctuary where abandoned, abused, and homeless animals find care, compassion, and a path to their forever homes.
Whether you’re here to adopt, volunteer, donate, or simply learn more, we welcome you into our growing family of animal lovers. Together, we can make a difference. One rescue, one wagging tail, and one happy soul at a time.

    </p>

    <section class="mission">
      <h2>🎯 Our Mission</h2>
      <ul>
        <li>🐕 Rescue and shelter animals in need</li>
        <li>🏠 Connect pets with forever homes</li>
        <li>📢 Educate the public about animal welfare</li>
        <li>💉 Support health and spay/neuter programs</li>
      </ul>
    </section>

    <section class="team">
      <h2>👨‍👩‍👧 Our Paw-some Team</h2>
      <div class="team-grid">
        <div class="member">
          <img src="assets/images/OODENG ORI.jpg" alt="Cikgu Azfar">
          <h3>Cikgu Azfar</h3>
          <p>Lead vet</p>
        </div>
        <div class="member">
          <img src="assets/images/HUH Gebu.jpg" alt="Mia">
          <h3>Mia</h3>
          <p>Founder & Director</p>
        </div>
        <div class="member">
          <img src="assets/images/20250630160559_Jimin.jpg" alt="Aysha">
          <h3>Aysha</h3>
          <p>Volunteer Lead</p>
        </div>
      </div>
    </section>

    <section class="cta">
      <h2>💖 Want to Help?</h2>
      <p>Be a hero for those without a voice. Join us as a volunteer, foster parent, donor or adopter.</p>
      <a href="user/view-animals.php" class="btn">Meet Our Animals</a>
    </section>
  </div>
</main>

<style>
.container.about-page {
  max-width: 1000px;
  margin: auto;
  padding: 2rem;
}

.about-card {
  background: #fff url('../assets/images/paws-bg.png') no-repeat bottom right;
  background-size: 120px;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.1);
}

.about-card h1,
.about-card h2 {
  color: #ff7043;
}

.about-card p,
.about-card li {
  font-size: 1.1rem;
  line-height: 1.6;
}

.about-card ul {
  padding-left: 1.2rem;
}

.team-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  margin-top: 1rem;
}

.member {
  flex: 1 1 220px;
  text-align: center;
}

.member img {
  width: 130px;
  height: 130px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #ff7043;
  box-shadow: 0 4px 8px rgba(0,0,0,0.08);
}

.member h3 {
  margin-top: 0.5rem;
  font-size: 1.1rem;
}

.cta {
  text-align: center;
  margin-top: 2rem;
}


/* Dark mode */
body.dark-mode .about-card {
  background-color: #2a2a2a;
  color: #eee;
}

body.dark-mode .about-card h2 {
  color: #ffa15f;
}

body.dark-mode .member p {
  color: #ccc;
}
</style>

<?php include('includes/footer.php'); ?>
