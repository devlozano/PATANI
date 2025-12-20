<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Login</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    {{-- Font Awesome --}}
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
    #backHomeBtn {
        background: transparent;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: 14px;
        color: #0A142F;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        border: 1px solid transparent; /* Added to prevent layout shift on hover */
    }

    #backHomeBtn:hover {
        color: #FFF200;
        border-color: #FFF200; /* Added visual cue */
    }
    p.subtitle {
        color: #666;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    label {
        font-family: "Poppins", sans-serif; /* Fixed font property */
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
    p.signup-text {
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

    /* Password Input Styling */
    .password-input-container {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .password-input-container input[type="password"],
    .password-input-container input[type="text"] {
        width: 100%;
        padding-right: 35px; /* Space for icon */
        margin-bottom: 0; /* Override default margin */
    }

    .password-toggle-icon {
        position: absolute;
        right: 10px;
        cursor: pointer;
        color: #aaa; /* Lighter default color */
        font-size: 1.1em;
        z-index: 2;
    }

    .password-toggle-icon:hover {
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
        <h1>Welcome Back!</h1>
        <button id="backHomeBtn">Back to Homepage</button>
    </div> 
    
    <div class="right"> 
        <div class="form-container"> 
            <p class="subtitle">Welcome back</p> 
            <h2>Login to your account</h2>
            
            {{-- Success Message (e.g. after registration) --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- General Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="your_email@example.com" 
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="password">Password</label>
                <div class="password-input-container">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                    <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                {{-- NEW FORGOT PASSWORD LINK START --}}
                <div style="text-align: right; margin-bottom: 15px; margin-top: -10px;">
                    <a href="{{ route('password.request') }}" style="color: #666; font-size: 0.85rem; text-decoration: none;">Forgot Password?</a>
                </div>
                {{-- NEW FORGOT PASSWORD LINK END --}}

                <button type="submit">Login</button>
            </form>
            
            <p class="signup-text">Don't Have An Account? <a href="{{ route('register') }}" class="signup">Sign Up</a></p>
        </div>
    </div>

    <script>
        document.getElementById('backHomeBtn').addEventListener('click', function() {
            window.location.href = "{{ url('/') }}"; 
        });

        // Password Visibility Toggle
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePassword');

        togglePasswordIcon.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>