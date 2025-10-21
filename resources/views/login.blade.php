<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Sign Up</title>
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
  overflow: hidden;
  background-color: #fff;
}

/* LEFT SIDE */
.left {
  flex: 1;
  background: linear-gradient(rgba(255, 165, 0, 0.7), rgba(255, 165, 0, 0.7)),
    url("your-image.jpg") center/cover no-repeat;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: white;
  position: relative;
  text-align: center;
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

/* RIGHT SIDE */
.right {
    flex: 1;
    display: flex; 
    align-items: center;
    justify-content: center;
    background-color: #fff;
    padding: 40px;
    font-size: 0.85rem;
}

.form-container {
    width: 100%;
    max-width: 400px;
    margin-top: -50px;
    font-size: 0.85rem;
}

h2 {
    color: #1e1e1e;
    font-weight: 700;
    font-size: 1.2rem;
    margin-top: 30px;
}

label {
    display: block;
    font-size: 0.8rem;
    margin-bottom: 5px;
    color: #555;
}

input {
    width: 100%;
    padding: 8px;
    border: 2px solid #d6e6ff;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 0.85rem;
    outline: none;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #ffa000;
}

.row {
    display: flex;
    gap: 10px;
}

.row input {
    flex: 1;
}

button {
    width: 100%;
    background-color: #ff8800;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 5px;
}

button:hover {
    background-color: #e67600;
}

p {
    margin-top: 12px;
    font-size: 0.8rem;
    color: #666;
    text-align: center;
}

a {
    color: #007bff;
    text-decoration: none;
    font-size: 0.8rem;
}

a:hover {
    text-decoration: underline;
}

/* RESPONSIVE DESIGN */
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
    <div class="left"> <div class="logo">Patani Trinidad</div> 
    <h1>Welcome!</h1> 
</div> 
<div class="right"> <div class="form-container"> 
    <h2>Create an account</h2> 
    <form> 
        <label>Full Name</label> 
        <input type="text" placeholder="Banjo Cutie" required>
            <label>Email</label>
    <input type="email" placeholder="banjo@pogi.com" required>

    <label>Password</label>
    <input type="password" placeholder="Enter your password" required>

    <label>Confirm Password</label>
    <input type="password" placeholder="Confirm Password" required>

    <div class="row">
      <div>
        <label>Gender</label>
        <input type="text" placeholder="Male" required>
      </div>
      <div>
        <label>Contact No.</label>
        <input type="text" placeholder="09** *** ****"required>
      </div>
    </div>

    <label>Address</label>
    <input type="text" placeholder="Address" required>

    <button type="submit">Create account</button>
  </form>

  <p>Already Have An Account ? <a href="/auth">Log In</a></p>
</div>
</div>
</body>
</html>