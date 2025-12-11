<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Patani Trinidad Boarding House</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
<style>
  :root {
    --primary: #f8c70b;
    --dark: #1e1e1e;
    --light: #fffff0;
    --gray: #6c6c6c;
  }

  * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
  body { background-color: var(--light); color: var(--dark); line-height:1.6; }

  /* ===== HEADER ===== */
  header {
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(6px);
    color: #fff;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 80px;
    transition: 0.3s;
  }

  header.scrolled { background: rgba(255,255,255,0.95); color: var(--dark); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
  header.scrolled nav a { color: var(--dark); }

  header .logo { font-family:'Molle',cursive; font-size:24px; color:var(--primary); }
  nav a { color:#fff; margin:0 18px; text-decoration:none; font-weight:500; transition:0.3s; }
  nav a:hover { color: var(--primary); }

  .nav-buttons button {
    background-color: transparent;
    border:1px solid var(--primary);
    color: var(--primary);
    padding:6px 14px;
    border-radius:6px;
    margin-left:10px;
    cursor:pointer;
    transition:0.3s;
  }

  .nav-buttons .signup { background-color: #FF8C00; color:#fff; border:none; }
  .nav-buttons button:hover { background-color: var(--primary); color:#fff; }

  /* ===== HERO ===== */
  .hero {
    background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('/images/yell 1.png') center/cover no-repeat;
    height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:flex-start;
    padding:0 80px;
    color:white;
    text-shadow:0 2px 8px rgba(0,0,0,0.6);
  }

  .hero h1 { text-align:left; font-family: 'Montserrat', sans-serif; font-size:58px; font-weight:800; margin-bottom:10px; line-height:1; }
  .hero p {
    font-size: 20px;
    margin-bottom: 30px;
    color: var(--primary);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 1s ease-in-out, transform 1s ease-in-out;
  }
  .hero p.show { opacity: 1; transform: translateY(0); }

  .hero button {
    background-color: #FF8C00;
    border: none;
    color: #fffff0;
    gap: 7px;
    padding: 14px 18px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    transition: background-color 0.3s ease, box-shadow 0.3s ease; 
  }

  .hero button img {
    width: 10px;
    height: 10px;
    transition: transform 0.3s ease;
  }

  .hero button:hover img { transform: rotate(45deg); }

  .hero button:hover {
    transform: scale(1);
    background-color: #FF8C00;
    box-shadow: 0 0 10px #FFF200;
  }

  /* ===== SECTIONS ===== */
  section { padding:100px 60px; text-align:center; }
  section h2 { font-size:32px; font-weight:700; margin-bottom:50px; position:relative; display:inline-block; }
  section h2::after { content:""; display:block; width:70px; height:4px; background:var(--primary); margin:12px auto 0; border-radius:2px; }

  /* ===== ROOMS ===== */
  .rooms { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:30px; justify-content:center; }
  .room-card {
    background:#fff;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    overflow:hidden;
    transition:0.3s;
  }
  .room-card:hover { transform:translateY(-6px); box-shadow:0 6px 18px rgba(0,0,0,0.15); }
  .room-card img { width:100%; height:200px; object-fit:cover; }
  .room-card .content { padding:20px; text-align:left; }

  .room-card h3 { font-size:18px; margin-bottom:8px; }
  .room-card p { font-size:14px; color:var(--gray); margin-bottom:8px; }
  .room-card .info { display:flex; justify-content:space-between; color:var(--gray); font-size:13px; margin-bottom:15px; }
  .room-card button { width:100%; padding:10px; border:none; background: #FF8C00; color:#fff; border-radius:6px; font-weight:600; cursor:pointer; transition:0.3s; }
  .room-card button.unavailable { background:#ccc; cursor:not-allowed; }
  .room-card button:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }

  /* Room amenities tags */
  .room-card .amenities {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 10px 0;
  }

  .room-card .amenity-tag {
    background: #fff8e1;
    color: var(--dark);
    border: 1px solid #f8c70b;
    border-radius: 12px;
    font-size: 12px;
    padding: 4px 10px;
    font-weight: 500;
    transition: 0.2s;
  }

  .room-card .amenity-tag:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  /* ===== MODAL BACKDROP ===== */
.modal {
  display: none;
  position: fixed;
  z-index: 1500;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 15, 15, 0.65);
  backdrop-filter: blur(4px);
  justify-content: center;
  align-items: center;
  padding: 10px;
}

/* ===== MODAL CONTENT ===== */
.modal-content {
  background: #fff;
  border-radius: 14px;
  padding: 25px 30px;
  width: 95%;
  max-width: 480px;  /* ↓ was 640px */
  max-height: 100vh;  /* limits height */
  overflow-y: auto;
  position: relative;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  animation: slideUp 0.3s ease;
  display: flex;
  flex-direction: column;
  gap: 10px;
  font-family: "Poppins", sans-serif;
}

@keyframes slideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== CLOSE BUTTON ===== */
.modal-content .close {
  position: absolute;
  top: 12px;
  right: 16px;
  font-size: 22px;
  color: #666;
  cursor: pointer;
  transition: 0.2s ease;
}

.modal-content .close:hover {
  color: #ff3b30;
  transform: rotate(90deg);
}

/* ===== HEADERS & TEXT ===== */
.modal-content h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f1f1f;
  margin-bottom: 4px;
}

.modal-content p {
  font-size: 0.95rem;
  color: #444;
  line-height: 1.5;
}

.modal-content h4 {
  font-size: 1rem;
  color: #333;
  margin-top: 15px;
  margin-bottom: 6px;
}

/* ===== INCLUSIONS LIST ===== */
#modalInclusions {
  padding-left: 20px;
  margin: 0;
  color: #555;
}

#modalInclusions li {
  font-size: 0.9rem;
  margin-bottom: 4px;
  position: relative;
}

#modalInclusions li::before {
  content: "✓";
  color: #28a745;
  margin-right: 6px;
}

/* ===== RESERVE BUTTON ===== */
.modal-actions {
  text-align: center;
  margin-top: 18px;
}

.reserve-btn {
  background: linear-gradient(135deg, #ff8c00, #ff6a00);
  color: #fff;
  border: none;
  padding: 8px 35px;
  font-size: 1rem;
  font-weight: 600;
  border-radius: 10px;
  cursor: pointer;
  box-shadow: 0 3px 12px rgba(255, 140, 0, 0.35);
  transition: all 0.3s ease;
}

.reserve-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 16px rgba(255, 106, 0, 0.45);
}

/* ===== GALLERY ===== */
.modal-gallery {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 8px;
}

.modal-gallery img {
  width: 85px;   /* smaller images */
  height: 65px;
  object-fit: cover;
  border-radius: 6px;
  cursor: pointer;
  border: 1.5px solid transparent;
  transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
}

.modal-gallery img:hover {
  transform: scale(1.06);
  border-color: #ff8c00;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
}

/* ===== ZOOM OVERLAY ===== */
.img-zoom-overlay {
  display: none;
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(10, 10, 10, 0.9);
  backdrop-filter: blur(4px);
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease;
  cursor: zoom-out;
}

.img-zoom-overlay.active {
  display: flex;
}

.img-zoom-overlay img {
  max-width: 100%;
  max-height: 95%;
  border-radius: 10px;
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.5);
  animation: zoomIn 0.25s ease;
}

@keyframes zoomIn {
  from { transform: scale(0.85); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

@keyframes fadeIn {
  from { opacity: 0; } 
  to { opacity: 1; }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 480px) {
  .modal-content {
    padding: 20px;
    max-width: 92%;
  }

  .modal-gallery img {
    width: 65px;
    height: 48px;
  }

  .reserve-btn {
    padding: 7px 25px;
    font-size: 0.95rem;
  }
}


  /* ===== CONTACT ===== */
  .contact-section {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 80px 20px;
    background: #fffbe6;
    flex-wrap: wrap;
    gap: 40px;
  }

  .contact-card {
    position: relative;
    width: 400px;
    background: #f8b735;
    border-radius: 20px;
    padding: 50px 40px;
    color: #000;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    font-family: "Poppins", sans-serif;
  }

  .contact-card h2 { font-size: 1.8rem; font-weight: 700; margin-bottom: 10px; }
  .contact-card .subtitle { color: #333; font-size: 1rem; margin-bottom: 40px; }

  .contact-item { display: flex; align-items: center; gap: 15px; margin: 18px 0; font-size: 1rem; }
  .contact-socials { margin-top: 50px; display: flex; gap: 15px; }

  .contact-socials a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 1.2rem;
    text-decoration: none;
    transition: transform 0.3s;
  }

  .contact-socials a:hover { transform: scale(1.1); }

  .circle { position: absolute; border-radius: 50%; z-index: 0; }
  .circle1 { width: 120px; height: 120px; background: #fbb03b; bottom: 0; right: 40px; }
  .circle2 { width: 200px; height: 200px; background: #ffd700; bottom: -50px; right: -50px; opacity: 0.9; }

  /* ===== FOOTER ===== */
  footer { background: #FCCC4B; color:var(--dark); text-align:center; padding:50px 30px; font-size:14px; margin-top:50px; }
  footer .footer-grid { display:flex; flex-wrap:wrap; justify-content:space-around; margin-bottom:25px; gap:20px; text-align:left; }
  footer h4 { margin-bottom:10px; color:var(--dark); }
  footer a { color:var(--dark); text-decoration:none; display:block; margin-bottom:6px; transition:0.3s; }
  footer a:hover { color: var(--light); }
  footer .logo { font-family:'Molle',cursive; color:var(--dark); font-size:20px; margin-top:20px; }

  /* ===== RESPONSIVE FIXES ===== */
  @media (max-width: 1024px) {
    header { padding: 15px 50px; }
    .hero { padding: 0 50px; }
  }

  @media (max-width: 768px) {
    header {
      flex-direction: column;
      align-items: flex-start;
      padding: 12px 25px;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      margin-top: 10px;
      gap: 10px;
    }

    .hero {
      align-items: center;
      text-align: center;
      padding: 0 30px;
    }
    .hero h1 { font-size: 42px; }
    .hero p { font-size: 18px; }

    .rooms {
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    }

    section { padding: 80px 25px; }
    .contact-section { flex-direction: column; align-items: center; text-align: center; }
    .contact-card { width: 90%; padding: 40px 25px; }
    .contact-form { width: 100%; }
  }

  @media (max-width: 480px) {
    header { padding: 10px 20px; }
    .hero h1 { font-size: 32px; }
    .hero p { font-size: 16px; }
    .hero button { padding: 12px 16px; font-size: 14px; }
    section { padding: 60px 20px; }
    .room-card img { height: 180px; }
    footer { padding: 30px 20px; }
  }
</style>
</head>
<body>

<header>
  <div class="logo">Patani Trinidad</div>
  <nav>
    <a href="#home">HOME</a>
    <a href="#rooms">ROOM</a>
    <a href="#about">ABOUT</a>
    <a href="#contact">CONTACT</a>
  </nav>
<div class="nav-buttons">
  <button id="loginBtn">Login</button>
  <button class="signup" id="signupBtn">Signup</button>
</div>
</header>

<!-- HERO -->
<section class="hero" id="home">
  <h1>PATANI TRINIDAD<br>BOARDING HOUSE</h1>
<p id="animated-text">Comfort, Convenience, and Hospitality in the Heart of Trinidad.</p>
<a href="#rooms" style="text-decoration:none;">
  <button>
    Book Now
    <img src="/images/icon.png" alt="icon" style="width:10px; height:10px; vertical-align:middle; margin-right:8px;">
  </button>
</a>
</section>

<!-- ROOMS -->
<section id="rooms">
  <h2>Explore Our Rooms</h2>
  <div class="rooms" id="roomsContainer">
    <!-- Dynamic room cards will be injected here -->
  </div>
</section>

<!-- MODAL -->
<div id="roomModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 id="modalTitle">Room Title</h2>
    <p id="modalPrice">₱1600/Month</p>
    <p id="modalDesc">Full description...</p>

    <h4>Inclusions:</h4>
    <ul id="modalInclusions"></ul>

    <h4>Gallery</h4>
    <div id="modalGallery" class="modal-gallery"></div>

    <div class="modal-actions">
      <button class="reserve-btn">Reserve Now</button>
    </div>
  </div>
</div>

<!-- ABOUT SECTION -->
<section id="about" style="padding: 60px 20px; background: #fffff0;">
  <h2 style="text-align:center; font-size:2em; margin-bottom:40px;">About Us</h2>

  <div class="about-content" 
       style="display:flex; flex-wrap:wrap; gap:40px; align-items:stretch; justify-content:center; text-align:left; max-width:1100px; margin:auto;">

    <!-- Image -->
    <div style="flex:1; min-width:300px; display:flex; align-items:center;">
      <img src="/images/received_1367814431592858.jpeg" 
           alt="About Patani Trinidad" 
           style="width:100%; height:100%; object-fit:cover; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
    </div>

    <!-- Text -->
    <div style="flex:1; min-width:300px; text-align:justify; display:flex; flex-direction:column; justify-content:center;">
      <p>
        Patani Trinidad Boarding House is a welcoming and affordable home-away-from-home designed to provide comfort, security, and convenience for students and professionals. Located in a peaceful area, our boarding house offers easy access to schools, workplaces, and essential establishments.
      </p>
      <br>
      <p>
        We pride ourselves on maintaining a clean and friendly environment where boarders can focus on their studies or work while feeling at home. With well-ventilated rooms, reliable facilities, and a supportive community, Patani Trinidad Boarding House ensures that your stay is both enjoyable and worry-free.
      </p>
      <br>
      <p>
        Whether you’re staying short-term or long-term, our mission is to give you a safe, comfortable, and budget-friendly place to live.
      </p>
    </div>

  </div>
</section>


<!-- CONTACT -->
<section id="contact" style="padding: 60px 20px; background: #fffff0;">
  <h2 style="text-align:center; font-size:2em; margin-bottom:40px;">Contact Us</h2>

  <div class="contact-wrapper" 
       style="max-width:1000px; margin:auto; background:#fffff0; border-radius:16px; box-shadow:0 6px 20px rgba(0,0,0,0.1); display:flex; flex-wrap:wrap; overflow:hidden;">

  <div class="contact-card">
    <h2>Contact Information</h2>
    <p class="subtitle">Say something to start a live chat!</p>

<div class="contact-item">
  <img src="images/bxs_phone-call.png" alt="Phone Icon" class="icon-image" />
  <span>+1012 3456 789</span>
</div>

<div class="contact-item">
  <img src="/images/ic_sharp-email.png" alt="Email Icon" class="icon-image" />
  <span>demo@gmail.com</span>
</div>

<div class="contact-item">
  <img src="/images/carbon_location-filled.png" alt="Location Icon" class="icon-image" />
  <span>Urdaneta City, Pangasinan</span>
</div>

<div class="contact-socials">
  <a href="#"><img src="/images/twitter.png" alt="Twitter" class="social-image" /></a>
  <a href="#"><img src="/images/ig.png" alt="Instagram" class="social-image" /></a>
  <a href="#"><img src="/images/dis.png" alt="Message" class="social-image" /></a>
</div>

    <!-- Decorative circles -->
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
  </div>

    <!-- RIGHT: Contact Form -->
    <div class="contact-form" style="flex:1; min-width:300px; padding:50px 40px; background:#fff;">
      <form style="display:flex; flex-direction:column; gap:15px;">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
          <input type="text" placeholder="First Name" required 
                 style="flex:1; padding:10px 15px; border:1px solid #ddd; border-radius:8px;">
          <input type="text" placeholder="Last Name" required 
                 style="flex:1; padding:10px 15px; border:1px solid #ddd; border-radius:8px;">
        </div>

        <input type="email" placeholder="Email" required 
               style="padding:10px 15px; border:1px solid #ddd; border-radius:8px;">
        <input type="tel" placeholder="Phone" 
               style="padding:10px 15px; border:1px solid #ddd; border-radius:8px;">


        <textarea rows="4" placeholder="Write your message..." 
                  style="padding:10px 15px; border:1px solid #ddd; border-radius:8px; resize:none;"></textarea>

        <button type="submit" 
                style="background:#ffb300; color:white; border:none; padding:12px 20px; border-radius:8px; font-weight:600; cursor:pointer; transition:0.3s;">
          Send Message
        </button>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="footer-grid">
<div>
  <h4>Reach Us</h4>
  <p style="display: flex; align-items: center; gap: 8px;">
    <img src="/images/call_black.png" alt="Phone" style="vertical-align: middle;">
    +63 912 456 789
  </p>
  <p style="display: flex; align-items: center; gap: 8px;">
    <img src="/images/email_black.png" alt="Email" style="vertical-align: middle;">
    demo@gmail.com
  </p>
  <p style="display: flex; align-items: center; gap: 8px;">
    <img src="/images/location_black.png" alt="Location" style="vertical-align: middle;">
    Urdaneta City, Pangasinan
  </p>
</div>
    <div>
      <h4>Explore</h4>
      <a href="#">Resources</a>
      <a href="#">Blog</a>
      <a href="#">Documents</a>
    </div>
    <div>
      <h4>Company</h4>
      <a href="#">About Us</a>
      <a href="#">Customers</a>
      <a href="#">Contact Us</a>
    </div>
  </div>
  <div class="logo">Patani Trinidad</div>
  <p>© 2025 GOBAS. All rights reserved.</p>
</footer>

<script>
const roomsData = [
  {id:1,title:"Room 1 - Ground Floor for Females",price:"₱1600/Month",desc:"Convenient and secure bedspace for ladies.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/room.png","/images/kitchen.jpg","/images/toilet.jpg"]},
  {id:2,title:"Room 2 - Ground Floor for Females",price:"₱1600/Month",desc:"Convenient and secure bedspace for ladies.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/room.png","/images/kitchen.jpg","/images/toilet.jpg"]},
  {id:3,title:"Room 3 - Ground Floor for Females",price:"₱1600/Month",desc:"Convenient and secure bedspace for ladies.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/room.png","/images/kitchen.jpg","/images/toilet.jpg"]},
  {id:4,title:"Room 4 - Second Floor for Males",price:"₱1600/Month",desc:"Affordable bedspace designed for men.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/fem.png","/images/kitchen1.jpg","/images/Philippines Bathroom.jpg"]},
  {id:5,title:"Room 5 - Second Floor for Males",price:"₱1600/Month",desc:"Affordable bedspace designed for men.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/fem.png","/images/kitchen1.jpg","/images/Philippines Bathroom.jpg"]},
  {id:6,title:"Room 6 - Second Floor for Males",price:"₱1600/Month",desc:"Affordable bedspace designed for men.",inclusions:["Study Desk","WiFi","Bathroom","Fan","Kitchen"],images:["/images/yell 1.png","/images/fem.png","/images/kitchen1.jpg","/images/Philippines Bathroom.jpg"]}
];

const roomsContainer = document.getElementById('roomsContainer');
const modal = document.getElementById('roomModal');
const modalTitle = document.getElementById('modalTitle');
const modalPrice = document.getElementById('modalPrice');
const modalDesc = document.getElementById('modalDesc');
const modalInclusions = document.getElementById('modalInclusions');
const modalGallery = document.getElementById('modalGallery');
const closeBtn = document.querySelector('.close');

// Render rooms dynamically
roomsData.forEach(room=>{
  const card = document.createElement('div');
  card.className='room-card';
  card.innerHTML=`
  <img src="${room.images[0]}" alt="${room.title}">
  <div class="content">
    <h3>${room.title}</h3>
    <p>${room.price}</p>
    <p>${room.desc}</p>
    
    <div class="info">
      <span>8 People</span>
      <span>Urdaneta City</span>
    </div>

    <div class="amenities">
      ${room.inclusions.map(i=>`<div class="amenity-tag">${i}</div>`).join('')}
    </div>

    <button class="${room.unavailable?'unavailable':'open-modal'}" ${room.unavailable?'disabled':''} data-room="${room.id}">
      ${room.unavailable?'Unavailable':'Available'}
    </button>
  </div>
`;
  roomsContainer.appendChild(card);
});

document.addEventListener("DOMContentLoaded", () => {
  const paragraph = document.getElementById("animated-text");
  const messages = [
    "We accept FEMALE BEDSPACER!",
    "Experience the best stay in Trinidad.",
    "Your comfort is our priority.",
    "Book now for an unforgettable stay!",
    "Enjoy safe and friendly hospitality.",
    "Stay with us for a home away from home.",
    "Comfort, Convenience, and Hospitality in the Heart of Trinidad."
  ];
  let currentIndex = 0;

  const changeText = (newText) => {
    paragraph.classList.remove("show");
    setTimeout(() => {
      paragraph.textContent = newText;
      paragraph.classList.add("show");
    }, 1000); // fade out duration
  };

  const cycleMessages = () => {
    // Show current message
    changeText(messages[currentIndex]);

    // Prepare next index
    currentIndex = (currentIndex + 1) % messages.length;

    // Schedule next change after delay
    setTimeout(cycleMessages, 4000); // 4 seconds display time
  };

  // Start the cycle
  // Initial fade-in
  setTimeout(() => {
    paragraph.classList.add("show");
    // Start cycling after initial display
    setTimeout(cycleMessages, 4000);
  }, 500);
});

// Modal logic
document.querySelectorAll('.open-modal').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const room = roomsData.find(r=>r.id==btn.dataset.room);
    modalTitle.textContent=room.title;
    modalPrice.textContent=room.price;
    modalDesc.textContent=room.desc;

    modalInclusions.innerHTML='';
    room.inclusions.forEach(i=>{ const li=document.createElement('li'); li.textContent=i; modalInclusions.appendChild(li); });

    modalGallery.innerHTML='';
    room.images.forEach(src=>{
      const img=document.createElement('img');
      img.src=src;
      img.alt=room.title;
      img.addEventListener('click',()=>openZoom(src));
      modalGallery.appendChild(img);
    });

    modal.style.display='flex';
  });
});

closeBtn.addEventListener('click',()=> modal.style.display='none');
window.addEventListener('click',e=>{if(e.target==modal) modal.style.display='none';});

// Image zoom
const zoomOverlay=document.createElement('div');
zoomOverlay.classList.add('img-zoom-overlay');
const zoomImg=document.createElement('img');
zoomOverlay.appendChild(zoomImg);
document.body.appendChild(zoomOverlay);
function openZoom(src){ zoomImg.src=src; zoomOverlay.style.display='flex'; }
zoomOverlay.addEventListener('click',()=>zoomOverlay.style.display='none');

// Smooth scroll
document.querySelectorAll('nav a').forEach(link=>{
  link.addEventListener('click',e=>{
    e.preventDefault();
    const target=document.querySelector(link.getAttribute('href'));
    if(target) window.scrollTo({top:target.offsetTop-70, behavior:'smooth'});
  });

  document.getElementById('loginBtn').addEventListener('click', function() {
    window.location.href = "{{ route('login') }}"; // Laravel route helper
  });

  document.getElementById('signupBtn').addEventListener('click', function() {
    // Replace with your signup route if available
    window.location.href = "{{ route('register') }}"; // or the appropriate route
  });

  document.querySelector('.reserve-btn').addEventListener('click', () => {
  window.location.href = '/login'; // or open another modal
});

});

// Header color on scroll
window.addEventListener('scroll',()=>{document.querySelector('header').classList.toggle('scrolled',window.scrollY>80);});
</script>
</body>
</html>