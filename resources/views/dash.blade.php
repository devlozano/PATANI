<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard</title>
    <!-- Move the import here -->
    <link href="https://fonts.googleapis.com/css2?family=Molle:ital@1&display=swap" rel="stylesheet">
    <style>
body {
margin: 0;
font-family: "Poppins", sans-serif;
background-color: #fafafa;
        }

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 30px;
  background-color: #fffff0;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.menu-icon {
  font-size: 24px;
  cursor: pointer;
}

.logo {
    font-family: "Molle", cursive;
    font-size: 24px;
    font-weight: bold;
    color: #002d18;
}

.logout-btn {
  background-color: #ff3b00;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px 18px;
  cursor: pointer;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 5px;
}

.container {
  padding: 40px 60px;
}

h1 {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 30px;
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 20px;
}

.card {
  background-color: white;
  border-radius: 10px;
  box-shadow: 3px 3px 4px rgba(0, 0, 0, 0.15);
  padding: 20px;
}

.card h3 {
  font-size: 18px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
}

.profile-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.profile-info img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

.info-details {
  margin-top: 10px;
}

.info-details p {
  margin: 5px 0;
  font-size: 15px;
}

.info-details span {
  font-weight: 600;
}

.room-card {
  text-align: center;
}

.room-card img {
  width: 60px;
  margin: 10px 0;
}

.book-btn {
  background-color: #ff9800;
  border: none;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 10px;
}

.payments-card {
  margin-top: 20px;
  grid-column: 1 / -1;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
  }
}

    </style>
</head>
<body>
    <header> 
        <div class="menu-icon">☰</div> 
        <div class="logo">Patani Trinidad</div> 
        <button class="logout-btn">Logout ⎋</button> 
    </header> 
    <div class="container"> 
        <h1>Student Dashboard</h1>
        <div class="cards">
  <div class="card">
    <h3>👤 My Information</h3>
    <div class="profile-info">
      <img src="https://via.placeholder.com/50" alt="Profile" />
      <div>
        <p><span>Name:</span> Karl Angelo Nortado</p>
        <p><span>CP no.:</span> 0912-345-6789</p>
        <p><span>Address:</span> Brgy. Bal-loy, Santa Maria, Pangasinan</p>
      </div>
    </div>
  </div>

  <div class="card room-card">
    <h3>🛏️ My Room</h3>
    <img src="https://cdn-icons-png.flaticon.com/512/1532/1532688.png" alt="Room Icon" />
    <p>You don’t have a room approved yet.</p>
    <button class="book-btn">BOOK NOW</button>
  </div>

  <div class="card payments-card">
    <h3>💳 All Payments</h3>
    <p>No payments.</p>
  </div>
</div>
</body>
</html>