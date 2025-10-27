<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Molle:ital@1&display=swap" rel="stylesheet">
    <style>
        /* --- your existing CSS (unchanged) --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            align-items: stretch;
            justify-content: center;
            min-height: 100vh;
            background-color: #fff;
            overflow-y: auto;
        }

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

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            color: #1e1e1e;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #d6e6ff;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #ffa000;
        }

        .error {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: -8px;
            margin-bottom: 8px;
            display: block;
        }

        .row {
            display: flex;
            gap: 12px;
        }

        .row > div {
            flex: 1;
        }

        button {
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
            margin-top: 8px;
        }

        button:hover {
            background-color: #e67600;
        }

        p {
            margin-top: 15px;
            font-size: 0.85rem;
            color: #666;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .left, .right {
                flex: none;
                width: 100%;
                min-height: 50vh;
            }

            .left {
                min-height: 30vh;
            }

            .form-container {
                max-width: 100%;
            }

            h2 {
                font-size: 1.2rem;
            }

            .row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="left">
        <div class="logo">Patani Trinidad</div>
        <h1>Welcome!</h1>
    </div>

    <div class="right">
        <div class="form-container">
            <h2>Create an account</h2>

            <!-- ✅ Fixed: added proper form setup -->
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
              
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g., Juan Dela Cruz" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label>Email</label>
                <input type="email" name="email" placeholder="your_email@example.com" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror

                <div class="row">
                    <div>
                        <label>Program</label>
                        <input type="text" name="program" placeholder="e.g., BSIT" value="{{ old('program') }}" required>
                        @error('program')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <label>Password</label>
                <input type="password" name="password" placeholder="Minimum 6 characters" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Re-enter your password" required>

                <div class="row">
                    <div>
                        <label>Gender</label>
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Contact No.</label>
                        <input type="text" name="contact" placeholder="09** *** ****" value="{{ old('contact') }}" required>
                        @error('contact')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <label>Address</label>
                <input type="text" name="address" placeholder="Complete Address" value="{{ old('address') }}" required>
                @error('address')
                    <span class="error">{{ $message }}</span>
                @enderror

                <button type="submit">Create account</button>
            </form>

            <p>Already Have An Account? <a href="{{ route('login') }}">Log In</a></p>
        </div>
    </div>
</body>
</html>
