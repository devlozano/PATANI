<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | New Password</title>
    
    {{-- Fonts and Icons --}}
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

    /* --- NEW STYLES FOR PASSWORD EYE ICON --- */
    .password-wrapper {
        position: relative;
        width: 100%;
        margin-bottom: 15px; /* Replaces the margin-bottom from the input */
    }
    .password-wrapper input {
        margin-bottom: 0; /* Remove input margin so wrapper controls it */
        padding-right: 40px; /* Make space for the icon so text doesn't overlap */
    }
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
        font-size: 1rem;
        z-index: 2;
    }
    .toggle-password:hover {
        color: #ff8800;
    }

    /* Mobile Responsiveness */
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
        <h1>Reset Password</h1>
    </div> 
    
    <div class="right"> 
        <div class="form-container"> 
            <h2>Create New Password</h2>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ $email ?? old('email') }}" 
                    required 
                    readonly 
                    style="background-color: #f0f0f0; cursor: not-allowed; color: #777;"
                >
                @error('email') <div class="error">{{ $message }}</div> @enderror

                {{-- New Password Field --}}
                <label for="password">New Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required placeholder="New Password">
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                @error('password') <div class="error">{{ $message }}</div> @enderror

                {{-- Confirm Password Field --}}
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm New Password">
                    <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                </div>

                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>

    <script>
        // Function to toggle password visibility
        function setupPasswordToggle(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            icon.addEventListener('click', function () {
                // Toggle the type attribute
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Toggle the eye / eye-slash icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Apply to both fields
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');
    </script>
</body>
</html>