<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<main>
    <section class="directory-search">
    <input type="text" id="searchBar" placeholder="Search for a shelter..." onkeyup="filterShelters()" />
    <select id="locationFilter" onchange="filterShelters()">
      <option value="">Filter by location</option>
      <option value="Balik Pulau">Balik Pulau</option>
      <option value="Teluk Bahang">Teluk Bahang</option>
      <option value="George Town">George Town</option>
      <option value="Relau">Relau</option>
      <option value="Seberang Prai">Seberang Prai</option>
      <option value="Juru">Juru</option>
      <option value="Sungai Ara">Sungai Ara</option>
    </select>
  </section>

  <section class="shelter-list" id="shelterList">
    <div class="shelter-card" data-location="Balik Pulau" data-map="https://www.google.com/maps?q=Balik+Pulau&output=embed">
      <h3><a href="https://meowyshelter.com" target="_blank">Meowy Cat Shelter</a></h3>
      <p>Balik Pulau | Founded in 2014 🐱</p>
      <p>Rescues, treats, and rehomes cats.</p>
    </div>
    
    <div class="shelter-card" data-location="Teluk Bahang" data-map="https://www.google.com/maps?q=Cat+Beach+Sanctuary,+Teluk+Bahang&output=embed">
      <h3><a href="https://catbeachpenang.com" target="_blank">Cat Beach Sanctuary</a></h3>
      <p>Teluk Bahang | Seaside sanctuary 🏖️</p>
      <p>24/7 care for cats in need.</p>
    </div>

    <div class="shelter-card" data-location="George Town" data-map="https://www.google.com/maps?q=SPCA+Penang,+George+Town&output=embed">
      <h3><a href="https://spca-penang.net" target="_blank">SPCA Penang</a></h3>
      <p>George Town | Animal protection 💉</p>
      <p>Veterinary care and adoption programs.</p>
    </div>

    <div class="shelter-card" data-location="Relau" data-map="https://www.google.com/maps?q=PASS,+Penang&output=embed">
      <h3><a href="https://pass.org.my" target="_blank">PASS</a></h3>
      <p>Relau | No-kill shelter 🐾</p>
      <p>Care for dogs, cats, and tortoises.</p>
    </div>

    <div class="shelter-card" data-location="Seberang Prai" data-map="https://www.google.com/maps?q=Seberang+Prai&output=embed">
      <h3><a href="https://pawprintsstrayanimal.neocities.org" target="_blank">Mercy Prai</a></h3>
      <p>Seberang Prai | Rescues & rehomes 🐕</p>
      <p>Works with MBSP to care for 200+ dogs.</p>
    </div>

    <div class="shelter-card" data-location="Juru" data-map="https://www.google.com/maps?q=Juru,+Penang&output=embed">
      <h3><a href="#" target="_blank">SAFE Shelter (Juru)</a></h3>
      <p>Juru | Community-based 🏡</p>
      <p>Part of Penang’s animal welfare net.</p>
    </div>

    <div class="shelter-card" data-location="Sungai Ara" data-map="https://www.google.com/maps?q=Sungai+Ara,+Penang&output=embed">
      <h3><a href="#" target="_blank">SAFE Shelter (Sungai Ara)</a></h3>
      <p>Sungai Ara | Outreach focused ❤️</p>
      <p>Caring for strays and abandoned pets.</p>
    </div>

    <div class="shelter-card" data-location="George Town" data-map="https://www.google.com/maps?q=Penang+Animal+Welfare+Society&output=embed">
      <h3><a href="#" target="_blank">Penang Animal Welfare Society</a></h3>
      <p>Local org | Non-SPCA 🐶</p>
      <p>Offers adoptions and community aid.</p>
    </div>

    <div class="shelter-card" data-location="George Town" data-map="https://www.google.com/maps?q=Penang+Community+Animal+Services&output=embed">
      <h3><a href="https://wingsofgoodwill.org" target="_blank">Gov’t Community Animal Services</a></h3>
      <p>Official DVS | State rescue ops 🚨</p>
      <p>Handles cruelty reports & stray control.</p>
    </div>

    <div class="shelter-card" data-location="Penang" data-map="https://www.google.com/maps?q=Cat+Tiram+Shelter&output=embed">
      <h3><a href="#" target="_blank">Cat Tiram Shelter</a></h3>
      <p>Penang | Active in adoptions 🐈</p>
      <p>Focused on rescue and rehoming.</p>
    </div>
  </section>

  <section class="map-section">
    <iframe id="shelterMap" src="https://www.google.com/maps?q=Penang&output=embed"
      width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </section>
</main>





<?php include('includes/footer.php'); ?>