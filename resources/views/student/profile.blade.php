<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | Patani Trinidad</title>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
               * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f5f5f5;
        }

         .sidebar {
            width: 300px;
            background: linear-gradient(to bottom, #FFD36E, #FF9800);
            color: #1e1e1e;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            font-family: "Molle", cursive;
            font-size: 1.8rem;
            margin-bottom: 40px;
            color: #1e1e1e;
            text-align: center;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
        }

        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            margin-bottom: 15px;
        }

        .profile h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e1e1e;
            margin-bottom: 5px;
        }

        .profile p {
            font-size: 0.95rem;
            color: #333;
        }

        .menu {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #1e1e1e;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .menu a.active {
            background: #ff8800;
            color: white;
        }

        .menu i {
            margin-right: 15px;
            font-size: 1.3rem;
        }
        .content {
            flex: 1;
            margin-left: 365px;
            padding: 0;
            transition: margin-left 0.3s ease;
        }

        .content.expanded {
            margin-left: 0;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fffbe6;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            padding: 5px;
            color: #1e1e1e;
            display: flex;
            align-items: center;
        }

        .logo {
            font-family: "Molle", cursive;
            font-size: 28px;
            color: #002d18;
        }

        .logout-btn {
            background-color: #ff3b00;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            font-size: 15px;
        }

        .logout-btn:hover {
            background-color: #e63500;
        }

        .main-content {
            padding: 40px;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .section {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 50px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e6e6e6;
            width: 90%;
            max-width: 900px;
            transition: box-shadow 0.3s ease;
        }

        .section:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        /* === Header (image + title) === */
        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 35px;
        }

        .section-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff9800;
            background: #fff;
        }

        .section-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: #222;
        }

        /* === Info grid for static details === */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 40px;
            margin-bottom: 20px;
        }

        .info-item label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 6px;
        }

        .info-item p {
            font-size: 16px;
            font-weight: 600;
            color: #1e1e1e;
        }

        /* === Form grid for inputs === */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 40px;
            align-items: start;
        }

        /* === Form groups and inputs === */
        .form-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        /* ✅ All input/select fields same width */
        .form-group input,
        .form-group select {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            font-family: "Poppins", sans-serif;
            background: #f9f9f9;
            transition: all 0.25s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff9800;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.15);
        }

        .form-group input:read-only {
            background: #f0f0f0;
            color: #777;
            cursor: not-allowed;
        }

        /* === Button wrapper === */
        .update-btn-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 35px;
        }

        /* === Update button === */
        .update-btn {
            background-color: #ff9800;
            border: none;
            color: #fff;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
            box-shadow: 0 3px 6px rgba(255, 152, 0, 0.3);
        }

        .update-btn:hover {
            background-color: #f57c00;
            box-shadow: 0 4px 10px rgba(245, 124, 0, 0.35);
        }
        @media (max-width: 1024px) {
            .info-grid,
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 300px;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .top-bar {
                padding: 15px 20px;
            }

            .logo {
                font-size: 22px;
            }

            .logout-btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            .main-content {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 25px;
            }

            .section {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .top-bar {
                padding: 12px 15px;
            }

            .logo {
                font-size: 18px;
            }

            .logout-btn {
                padding: 6px 12px;
                font-size: 13px;
            }

            .main-content {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            .section {
                padding: 15px;
            }

            .section-header {
                font-size: 18px;
            }

            .update-btn-wrapper {
                justify-content: stretch;
            }

            .update-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
            <div class="profile">
                <img src="/images/image 39.jpg" alt="User Photo">

                <h2>{{ $user->name }}</h2>
                <p>{{ $user->contact }}</p>
            </div>
        <div class="menu">
    <a href="{{ route('dash') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i> Dashboard
    </a>
    <a href="{{ route('student.booking') }}" class="{{ request()->routeIs('student.booking') ? 'active' : '' }}">
        <i class="bi bi-calendar-check"></i> My Booking
    </a>
    <a href="{{ route('student.payment') }}" class="{{ request()->routeIs('student.payment') ? 'active' : '' }}">
        <i class="bi bi-credit-card"></i> My Payments
    </a>
    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
        <i class="bi bi-person"></i> Profile
    </a>
        </div>
    </div>

    <div class="content" id="content">
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="logo">Patani Trinidad</div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirmLogout();">
                    Logout <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>

            <script>
            function confirmLogout() {
                return confirm("Are you sure you want to log out?");
            }
            </script>
        </div>

        <div class="main-content">
            <h1>Student Profile</h1>

            <div class="section">
                <div class="section-header">
                    <img src="/images/image 39.jpg" alt="Profile">
                    <span>My Information</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Student Id:</label>
                        <p>20001919</p>
                    </div>
                    <div class="info-item">
                        <label>Name:</label>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="info-item">
                        <label>Gender:</label>
                        <p>{{ Auth::user()->gender ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <p>{{ Auth::user()->email ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Program:</label>
                        <p>{{ Auth::user()->program ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Address:</label>
                        <p>{{ $user->address }}</p>
                    </div>
                    <div class="info-item">
                        <label>Contact:</label>
                        <p>{{ Auth::user()->contact ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="section">
    <div class="section-header">
        <img src="/images/image 39.jpg" alt="Profile">
        <span>Update Information</span>
    </div>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" 
                       value="{{ Auth::user()->name ?? '' }}">
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender">
                    <option value="Male" {{ Auth::user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ Auth::user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" 
                       value="{{ Auth::user()->email ?? '' }}">
            </div>

            <div class="form-group">
                <label>Program:</label>
                <select name="program">
        <option value="">Select Program</option>

        {{-- 🖥️ College of Information Technology Education --}}
        <optgroup label="College of Information Technology Education">
            <option value="BSIT" {{ Auth::user()->program === 'BSIT' ? 'selected' : '' }}>BS in Information Technology (BSIT)</option>
            <option value="BSCS" {{ Auth::user()->program === 'BSCS' ? 'selected' : '' }}>BS in Computer Science (BSCS)</option>
            <option value="BSIS" {{ Auth::user()->program === 'BSIS' ? 'selected' : '' }}>BS in Information Systems (BSIS)</option>
        </optgroup>

        {{-- 🧮 College of Business and Accountancy --}}
        <optgroup label="College of Business Management and Accountancy">
            <option value="BSBA" {{ Auth::user()->program === 'BSBA' ? 'selected' : '' }}>BS in Business Administration (BSBA)</option>
            <option value="BSA" {{ Auth::user()->program === 'BSA' ? 'selected' : '' }}>BS in Accountancy (BSA)</option>
            <option value="BSMA" {{ Auth::user()->program === 'BSMA' ? 'selected' : '' }}>BS in Management Accounting (BSMA)</option>
        </optgroup>

        {{-- 🧪 College of Arts and Sciences --}}
        <optgroup label="College of Arts and Sciences">
            <option value="BAComm" {{ Auth::user()->program === 'BAComm' ? 'selected' : '' }}>BA in Communication</option>
            <option value="BAPsych" {{ Auth::user()->program === 'BAPsych' ? 'selected' : '' }}>BA in Psychology</option>
            <option value="BSBio" {{ Auth::user()->program === 'BSBio' ? 'selected' : '' }}>BS in Biology</option>
        </optgroup>

        {{-- 🏗️ College of Engineering --}}
        <optgroup label="College of Engineerin and Architecture">
            <option value="BSCpE" {{ Auth::user()->program === 'BSCpE' ? 'selected' : '' }}>BS in Computer Engineering (BSCpE)</option>
            <option value="BSEE" {{ Auth::user()->program === 'BSEE' ? 'selected' : '' }}>BS in Electrical Engineering (BSEE)</option>
            <option value="BSCE" {{ Auth::user()->program === 'BSCE' ? 'selected' : '' }}>BS in Civil Engineering (BSCE)</option>
            <option value="BSECE" {{ Auth::user()->program === 'BSECE' ? 'selected' : '' }}>BS in Electronics Engineering (BSECE)</option>
            <option value="BSME" {{ Auth::user()->program === 'BSME' ? 'selected' : '' }}>BS in Mechanical Engineering (BSME)</option>
            <option value="BSArch" {{ Auth::user()->program === 'BSArch' ? 'selected' : '' }}>BS in Architecture (BSArch)</option>
        </optgroup>

        {{-- 🍎 College of Teacher Education --}}
        <optgroup label="College of Teacher Education">
            <option value="BSEd" {{ Auth::user()->program === 'BSEd' ? 'selected' : '' }}>Bachelor of Secondary Education (BSEd)</option>
            <option value="BEEd" {{ Auth::user()->program === 'BEEd' ? 'selected' : '' }}>Bachelor of Elementary Education (BEEd)</option>
            <option value="BPEd" {{ Auth::user()->program === 'BPEd' ? 'selected' : '' }}>Bachelor of Physical Education (BPEd)</option>
            <option value="BTLEd" {{ Auth::user()->program === 'BTLEd' ? 'selected' : '' }}>Bachelor of Technology and Livelihood Education (BTLEd)</option>
        </optgroup>

        {{-- 🩺 College of Nursing --}}
        <optgroup label="College of Nursing">
            <option value="BSN" {{ Auth::user()->program === 'BSN' ? 'selected' : '' }}>BS in Nursing (BSN)</option>
        </optgroup>

        {{-- 💊 College of Pharmacy --}}
        <optgroup label="College of Pharmacy">
            <option value="BSP" {{ Auth::user()->program === 'BSP' ? 'selected' : '' }}>BS in Pharmacy (BSP)</option>
            <option value="BSPharmTech" {{ Auth::user()->program === 'BSPharmTech' ? 'selected' : '' }}>BS in Pharmaceutical Technology (BSPharmTech)</option>
        </optgroup>

        {{-- 🧠 College of Psychology --}}
        <optgroup label="College of Psychology">
            <option value="BSPsych" {{ Auth::user()->program === 'BSPsych' ? 'selected' : '' }}>BS in Psychology (BSPsych)</option>
            <option value="BAPsych" {{ Auth::user()->program === 'BAPsych' ? 'selected' : '' }}>BA in Psychology (BAPsych)</option>
        </optgroup>

        {{-- 🏛️ College of Criminal Justice Education --}}
        <optgroup label="College of Criminal Justice Education">
            <option value="BSCrim" {{ Auth::user()->program === 'BSCrim' ? 'selected' : '' }}>BS in Criminology (BSCrim)</option>
        </optgroup>
    </select>
            </div>
        
            <div class="form-group">
                <label>Contact:</label>
                <input type="text" name="contact" 
                      <input type="text" name="contact" value="{{ $user->contact ?? '' }}">
            </div>

                        <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" 
                       <input type="text" name="address" value="{{ $user->address ?? '' }}">
            </div>
        </div>

        <div class="update-btn-wrapper">
            <button type="submit" class="update-btn">Update</button>
        </div>
    </form>
</div>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            sidebar.classList.toggle('open');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>