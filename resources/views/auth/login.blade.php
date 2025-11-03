<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Login</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: "Montserrat", sans-serif;
    }
    body {
        display: flex;
        height: 100vh;
        background-color: #fff;
        overflow: hidden;
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
        margin-bottom: 5px;
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
    }
    .alert {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 8px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
     .password-input-container {
        position: relative;
        display: flex; /* To align input and icon */
        align-items: center;
        margin-bottom: 15px; /* Add consistent spacing */
    }

    /* Style for the password input itself to ensure it doesn't overlap */
    .password-input-container input[type="password"] {
        width: 100%; /* Inherit width */
        padding-right: 35px; /* Space for the icon (adjust if needed) */
        box-sizing: border-box; /* Ensure padding is included in width */
        /* Other input styles from your global styles should apply */
    }

    /* Styling for the eye icon */
    .password-toggle-icon {
        position: absolute;
        top: -10%; /* Center vertically */
        right: 10px; /* Position the icon on the right */
        cursor: pointer;
        color: #FCCC4B; /* Default color for the eye icon */
        font-size: 1.1em; /* Size of the eye icon */
        z-index: 1; /* Ensure icon is above the input text */
        display: flex;
        align-items: center;
        height: 100%; /* To vertically center the icon */
    }

    .password-toggle-icon:hover {
        color: #FF8C00; /* Darker color on hover */
    }

    /* Ensure general input styles are applied correctly if not globally */
    input[type="email"] {
        width: 100%;
        padding: 10px; /* Assuming your global input padding */
        margin-bottom: 15px;
        border: 1px solid #ccc; /* Assuming your global input border */
        border-radius: 4px; /* Assuming your global input border-radius */
        box-sizing: border-box;
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
    </div> 
    
    <div class="right"> 
        <div class="form-container"> 
            <p class="subtitle">Welcome back</p> 
            <h2>Login to your account</h2>
            
            @if (session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    {{ $errors->first() }}
                </div>
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
 {{-- New wrapper for password input and eye icon --}}
    <div class="password-input-container">
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
        >
        <span class="password-toggle-icon">
            <i class="fas fa-eye" id="togglePassword"></i> {{-- Font Awesome icon --}}
        </span>
    </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Login</button>
            </form>
            {{-- Link to Font Awesome CSS (if you haven't already) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <p class="signup-text">Don't Have An Account? <a href="{{ route('register') }}" class="signup">Sign Up</a></p>
        </div>
    </div>
    <script>
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePassword');

    togglePasswordIcon.addEventListener('click', function() {
        // Toggle the type attribute of the password input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the icon class
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>