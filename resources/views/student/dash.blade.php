<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
            gap: 20px;
            background: #fffbe6;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .main-content {
            padding: 40px;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 600;
        }

        .card-header img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card-header i {
            font-size: 28px;
            color: #ff9800;
        }

        .info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .info-item p {
            font-size: 16px;
            font-weight: 500;
            color: #1e1e1e;
        }

        .info-full {
            margin-bottom: 15px;
        }

        .info-full label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .info-full p {
            font-size: 16px;
            font-weight: 500;
            color: #1e1e1e;
        }

        .room-empty {
            text-align: center;
            padding: 30px 20px;
        }

        .room-empty i {
            font-size: 80px;
            color: #999;
            margin-bottom: 20px;
        }

        .room-empty p {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }

        .book-btn {
            background-color: #ff9800;
            border: none;
            color: white;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
        }

        .book-btn:hover {
            background-color: #f57c00;
            transform: scale(1.05);
        }

        .payments-card {
            grid-column: 1 / -1;
        }

        .payments-empty {
            padding: 40px;
            text-align: center;
            color: #999;
            font-size: 16px;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .payments-card {
                grid-column: 1;
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

            .main-content {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 25px;
            }

            .dashboard-grid {
                gap: 20px;
            }

            .card {
                padding: 20px;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .top-bar {
                padding: 12px 15px;
            }

            .logo {
                font-size: 20px;
            }

            .main-content {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            .card-header {
                font-size: 18px;
            }

            .room-empty i {
                font-size: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <!-- User photo (optional) -->
            <img src="/images/image 39.jpg" alt="User Photo">

            <!-- Dynamic user info -->
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->contact }}</p>
        </div>


        <div class="menu">
    <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
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
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="logo">Patani Trinidad</div>
        </div>

        <div class="main-content">
            <h1>Student Dashboard</h1>

            <div class="dashboard-grid">
               <div class="card">
        <div class="card-header">
            <i class="fas fa-id-card"></i>
            <span>My Information</span>
        </div>
         <div class="card-body">
                        <div class="info-row">
                            <div class="info-item">
                                <label>Name:</label>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                            <div class="info-item">
                                <label>CP No.:</label>
                                <p>{{ Auth::user()->contact }}</p>
                            </div>
                        </div>

                        <div class="info-full">
                            <label>Address:</label>
                            <p>{{ Auth::user()->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                </div>


                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-door-open"></i>
                        <span>My Room</span>
                    </div>
                    <div class="room-empty">
                        <i class="bi bi-door-closed"></i>
                        <p>You don't have a room approved yet.</p>
                        <button class="book-btn">BOOK NOW</button>
                    </div>
                </div>

                <div class="card payments-card">
                    <div class="card-header">
                        <i class="bi bi-credit-card"></i>
                        <span>All Payments</span>
                    </div>
                    <div class="payments-empty">
                        No payments.
                    </div>
                </div>
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