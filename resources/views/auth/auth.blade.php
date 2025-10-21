<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }
body {
  display: flex;
  height: 100vh;
  background-color: #fff;
  overflow: hidden;
}

/* LEFT PANEL */
.left {
  flex: 1;
  background: linear-gradient(rgba(255, 165, 0, 0.7), rgba(255, 165, 0, 0.7)),
    url("your-image.jpg") center/cover no-repeat;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: white;
  text-align: center;
  position: relative;
  padding: 40px;
}

.logo {
  position: absolute;
  top: 30px;
  left: 50px;
  font-family: "Pacifico", cursive;
  font-size: 1.5rem;
  color: #1e1e1e;
  background-color: rgba(255, 255, 255, 0.4);
  padding: 5px 15px;
  border-radius: 10px;
}

.left h1 {
  font-size: 2.8rem;
  font-weight: 600;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
}

/* RIGHT PANEL */
.right {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #fff;
  padding: 40px;
}

.form-container {
  width: 100%;
  max-width: 400px;
}

h2 {
  color: #1e1e1e;
  margin-bottom: 25px;
  font-weight: 700;
}

p.subtitle {
  color: #666;
  margin-bottom: 5px;
  font-size: 0.9rem;
}

label {
  display: block;
  font-size: 0.9rem;
  margin-bottom: 5px;
  color: #555;
}

input {
  width: 100%;
  padding: 10px;
  border: 2px solid #d6e6ff;
  border-radius: 8px;
  margin-bottom: 15px;
  font-size: 0.9rem;
  outline: none;
  transition: border-color 0.3s;
}

input:focus {
  border-color: #ffa000;
}

.password-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.password-row a {
  font-size: 0.85rem;
  color: #007bff;
  text-decoration: none;
}

.password-row a:hover {
  text-decoration: underline;
}

button {
  width: 100%;
  background-color: #ff8800;
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 5px;
}

button:hover {
  background-color: #e67600;
}

p {
  margin-top: 15px;
  font-size: 0.9rem;
  color: #666;
  text-align: left;
}

a.signup {
  color: #007bff;
  text-decoration: none;
  font-weight: 500;
}

a.signup:hover {
  text-decoration: underline;
}

/* RESPONSIVE */
@media (max-width: 900px) {
  body {
    flex-direction: column;
    height: auto;
  }

  .left, .right {
    flex: none;
    width: 100%;
    height: auto;
  }

  .left {
    padding: 60px 20px;
  }

  .logo {
    position: static;
    margin-bottom: 20px;
  }
}

    </style>
</head>
<body>
    <div class="left"> 
        <div class="logo">Patani Trinidad</div> 
        <h1>Welcome Back!</h1> </div> 
        <div class="right"> 
            <div class="form-container"> 
                <p class="subtitle">Welcome back</p> 
                <h2>Login to your account</h2>
                  <form>
    <label>Email</label>
    <input type="email" placeholder="banjo@pogi.com" required>

    <div class="password-row">
      <label>Password</label>
      <a href="#">Forgot ?</a>
    </div>
    <input type="password" placeholder="Enter your password" required>

    <button type="submit">Login</button>
  </form>

<p>Don’t Have An Account? <a href="/login" class="signup">Sign Up</a></p>
</div>
</body>
</html>