<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Patani Trinidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    
    * {
        box-sizing: border-box;
    }

    body {
        display: flex;
        height: 100vh;
        margin: 0;
        font-family: "Montserrat", sans-serif;
    }
    /* LEFT SIDE (image background) */
    .left {
        flex: 1;
        background: 
            linear-gradient(rgba(255, 136, 0, 0.7), rgba(255, 136, 0, 0.7)),
            url("{{ asset('images/received_1367814431592858.jpeg') }}") center/cover no-repeat;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
    }
    .logo {
        font-size: 1.8rem;
        font-weight: 600;
        font-style: italic;
        margin-bottom: 20px;
    }
    .left h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .left p {
        font-size: 1rem;
        color: #fff;
        max-width: 350px;
    }

    /* RIGHT SIDE (form) */
    .right {
        flex: 1;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
    }
    .form-container {
        width: 100%;
        max-width: 380px;
    }
    .form-container h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }
    .subtitle {
        color: #6c757d;
        margin-bottom: 30px;
    }
    label {
        font-weight: 500;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 6px;
    }
    input {
        width: 100%;
        padding: 12px;
        margin-bottom: 18px;
        border: 1.5px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    input:focus {
        border-color: #ff8c00;
        box-shadow: 0 0 5px rgba(255,140,0,0.3);
        outline: none;
    }
    .btn-primary {
        width: 100%;
        background-color: #ff8c00;
        border: none;
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-primary:hover {
        background-color: #e67c00;
    }
    .bottom-text {
        text-align: center;
        margin-top: 15px;
        font-size: 0.9rem;
    }
    .bottom-text a {
        color: #ff8c00;
        text-decoration: none;
        font-weight: 500;
    }
    .bottom-text a:hover {
        text-decoration: underline;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    .alert.success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert.danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    @media (max-width: 900px) {
        body {
            flex-direction: column;
        }
        .left, .right {
            flex: none;
            width: 100%;
            height: auto;
            padding: 40px 30px;
        }
    }
</style>
<body>
    <div class="left">
        <div class="logo">Patani Trinidad</div>
        <h1>Forgot Your Password?</h1>
        <p>Enter your email and we’ll send you a reset link.</p>
    </div>

    <div class="right">
    <div class="form-container">
        <p class="subtitle">Having trouble signing in?</p>
        <h2>Reset your password</h2>

        @if (session('status'))
            <div class="alert success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Email Address</label>
            <input type="email" name="email" placeholder="your_email@example.com" required>

            @error('email')
                <div class="alert danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-primary">Send Reset Link</button>

            <p class="bottom-text">
                <a href="{{ route('login') }}">Back to Login</a>
            </p>
        </form>
    </div>
</div> 
</body>
</html>
