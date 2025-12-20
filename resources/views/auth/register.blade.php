<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        /* --- CSS STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; align-items: stretch; justify-content: center; min-height: 100vh; background-color: #fff; overflow-y: auto; }
        
        .left {
            flex: 1;
            background: linear-gradient(rgba(255, 165, 0, 0.7), rgba(255, 165, 0, 0.7)),
                url("/images/received_1367814431592858.jpeg") center/cover no-repeat;
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
            padding: 40px 20px;
            min-height: 100vh;
        }
        #backHomeBtn {
            background: transparent;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            color: #0A142F;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
            border: 1px solid transparent;
        }
        #backHomeBtn:hover { color: #FFF200; border-color: #FFF200; }

        .form-container { width: 100%; max-width: 500px; /* Slightly wider for split names */ background: #fff; display: flex; flex-direction: column; justify-content: center; }
        h2 { color: #1e1e1e; font-weight: 700; font-size: 1.4rem; text-align: center; margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; margin-bottom: 5px; color: #555; font-weight: 500; }
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #d6e6ff;
            border-radius: 8px;
            margin-bottom: 5px; 
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus, select:focus { border-color: #ffa000; }
        
        /* Error Message Style */
        .error {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 2px;
            margin-bottom: 12px;
            display: block;
            text-align: left;
        }
        .input-error { border-color: #dc3545; background-color: #fff8f8; }

        .row { display: flex; gap: 12px; }
        .row > div { flex: 1; }

        button[type="submit"] {
            width: 100%;
            background-color: #ff8800;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
        }
        button[type="submit"]:hover { background-color: #e67600; }

        p { margin-top: 15px; font-size: 0.85rem; color: #666; text-align: center; }
        a { color: #007bff; text-decoration: none; font-size: 0.85rem; font-weight: 500; }
        a:hover { text-decoration: underline; }

        .password-input-container { position: relative; display: flex; align-items: center; margin-bottom: 5px; }
        .password-input-container input { flex-grow: 1; padding-right: 40px; margin-bottom: 0; }
        .password-toggle-icon {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #aaa;
            font-size: 1rem;
            z-index: 2;
        }
        .password-toggle-icon:hover { color: #ff8800; }

        @media (max-width: 900px) {
            body { flex-direction: column; }
            .left, .right { flex: none; width: 100%; min-height: auto; }
            .left { min-height: 30vh; padding: 20px; }
            .right { padding: 40px 20px; }
            .form-container { max-width: 100%; }
            .row { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>
    <div class="left">
        <div class="logo">Patani Trinidad</div>
        <h1>Welcome!</h1>
        <button id="backHomeBtn">Back to Homepage</button>
    </div>

    <div class="right">
        <div class="form-container">
            <h2>Create an account</h2>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
              
                {{-- ✅ UPDATED: Split Name Fields --}}
                <label>Full Name</label>
                <div class="row">
                    {{-- Last Name --}}
                    <div>
                        <input type="text" name="last_name" 
                               placeholder="Last Name" 
                               value="{{ old('last_name') }}" 
                               class="@error('last_name') input-error @enderror" 
                               required>
                        @error('last_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- First Name --}}
                    <div>
                        <input type="text" name="first_name" 
                               placeholder="First Name" 
                               value="{{ old('first_name') }}" 
                               class="@error('first_name') input-error @enderror" 
                               required>
                        @error('first_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Middle Initial (Smaller Column) --}}
                    <div style="flex: 0.4;">
                        <input type="text" name="middle_initial" 
                               placeholder="M.I." 
                               value="{{ old('middle_initial') }}" 
                               maxlength="3"
                               class="@error('middle_initial') input-error @enderror">
                        @error('middle_initial')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <label>Email</label>
                <input type="email" name="email" 
                       placeholder="your_email@example.com" 
                       value="{{ old('email') }}" 
                       class="@error('email') input-error @enderror" 
                       required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror

                {{-- Password --}}
                <label for="password">Password</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" 
                           placeholder="Minimum 6 characters" 
                           class="@error('password') input-error @enderror" 
                           required>
                    <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                </div>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror

                {{-- Confirm Password --}}
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-input-container">
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           placeholder="Re-enter your password" 
                           required>
                    <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirmation"></i>
                </div>
                
                {{-- Row for Gender & Contact --}}
                <div class="row">
                    <div>
                        <label>Gender</label>
                        <select name="gender" class="@error('gender') input-error @enderror" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Contact No.</label>
                        <input type="text" name="contact" 
                               placeholder="09** *** ****" 
                               value="{{ old('contact') }}" 
                               class="@error('contact') input-error @enderror" 
                               required>
                        @error('contact')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Address --}}
                <label>Address</label>
                {{-- Note: To implement a full Dynamic Dropdown address (Region/City/Brgy), 
                     you need a separate large JavaScript file. Keeping as text for now to ensure submission works. --}}
                <input type="text" name="address" 
                       placeholder="House No., Street, Brgy, City" 
                       value="{{ old('address') }}" 
                       class="@error('address') input-error @enderror" 
                       required>
                @error('address')
                    <span class="error">{{ $message }}</span>
                @enderror

                <button type="submit">Create account</button>
            </form>

            <p>Already Have An Account? <a href="{{ route('login') }}">Log In</a></p>
        </div>
    </div>

    <script>
        // Back to Homepage Button
        document.getElementById('backHomeBtn').addEventListener('click', function() {
            window.location.href = "{{ url('/') }}"; 
        });

        // Password Visibility Toggle Logic
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input && icon) {
                icon.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        }

        // Initialize Toggles
        toggleVisibility('password', 'togglePassword');
        toggleVisibility('password_confirmation', 'togglePasswordConfirmation');
    </script>
</body>
</html>