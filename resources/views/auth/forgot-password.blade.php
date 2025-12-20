<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Reset Password</title>
    {{-- Ensure your fonts are linked here --}}
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    }
    .left {
        flex: 1;
        /* Using the same background image as your login page */
        background: linear-gradient(rgba(255, 165, 0, 0.7), rgba(255, 165, 0, 0.7)),
            url("{{ asset('images/received_1367814431592858.jpeg') }}") center/cover no-repeat;
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
        font-family: "Molle", cursive;
        font-size: 1.5rem;  
        color: #1e1e1e;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.4);
        padding: 5px 15px;
        border-radius: 10px;
    }
    .left h1 {
        font-size: 2.8rem;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }
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
        font-family: "Poppins", sans-serif;
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
    .error {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: -10px;
        margin-bottom: 10px;
        text-align: left;
    }
    .alert {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 0.9rem;
        text-align: center;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    
    /* Specific styles for the Reset Page Back Link */
    .back-login { 
        display: block; 
        text-align: center; 
        margin-top: 15px; 
        color: #666; 
        text-decoration: none; 
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    .back-login:hover { 
        color: #ff8800; 
    }

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
        <h1>Recovery</h1>
    </div> 
    
    <div class="right"> 
        <div class="form-container"> 
            <h2>Forgot Password?</h2>
            <p class="subtitle" style="margin-bottom: 20px;">Enter your email and we'll send you a link to reset your password.</p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="your_email@example.com">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Send Reset Link</button>
                <a href="{{ route('login') }}" class="back-login"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </form>
        </div>
    </div>
</body>
</html>