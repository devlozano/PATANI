<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: #ddd;
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
            margin-left: 300px;
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
            flex: 1;
        }

        .logout-btn {
            background: #FF4444;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #CC0000;
            transform: scale(1.05);
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

        .stat-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* Total Students - Blue */
        .stat-card:nth-child(1) {
            border-left: 5px solid #4A90E2;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #4A90E2, #357ABD);
            color: white;
        }

        /* Total Rooms - Purple */
        .stat-card:nth-child(2) {
            border-left: 5px solid #7B68EE;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #7B68EE, #6A5ACD);
            color: white;
        }

        /* Pending Bookings - Orange */
        .stat-card:nth-child(3) {
            border-left: 5px solid #FF9800;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }

        /* Pending Payments - Red */
        .stat-card:nth-child(4) {
            border-left: 5px solid #E74C3C;
        }

        .stat-card:nth-child(4) .stat-icon {
            background: linear-gradient(135deg, #E74C3C, #C0392B);
            color: white;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            flex-shrink: 0;
        }

        .stat-info h3 {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-info p {
            font-size: 28px;
            font-weight: 700;
            color: #1e1e1e;
            margin: 0;
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

        .card-header i {
            font-size: 28px;
            color: #ff9800;
        }

        .section-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 600;
        }

        .section-header i {
            font-size: 28px;
            color: #ff9800;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        td {
            font-size: 15px;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-approved {
            background: #4CAF50;
            color: white;
        }

        .status-rejected {
            background: #FF4444;
            color: white;
        }

        .status-checkout {
            background: #757575;
            color: white;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .stat-cards {
                grid-template-columns: 1fr;
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

            .stat-cards {
                gap: 15px;
            }

            .card {
                padding: 20px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
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

            .section-header {
                font-size: 18px;
            }

            .stat-cards {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>

        <div class="profile">
            <img src="/images/Screenshot 2025-10-28 033031.png" alt="User Photo">
    <h2>{{ Auth::user()->name }}</h2>
    <p>{{ Auth::user()->contact }}</p>
        </div>

        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Booking</span>
            </a>
            <a href="{{ route('admin.payment') }}" class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}"> 
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i>
                <span>Rooms</span>
            </a>
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="top-bar">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="logo">Patani Trinidad</div>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout()">
                    <span>Logout</span>
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>

        </div>

<div class="main-content">
    <h1>Admin Dashboard</h1>

    <!-- Stats Grid -->
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-info">
                <h3>TOTAL STUDENTS</h3>
                <p>{{ \App\Models\User::count() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-door-open"></i></div>
            <div class="stat-info">
                <h3>TOTAL ROOMS</h3>
                <p>{{ \App\Models\Room::count() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <h3>PENDING BOOKINGS</h3>
                <p>{{ \App\Models\Booking::where('status', 'Pending')->count() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h3>PENDING PAYMENTS</h3>
                <p>{{ \App\Models\Payment::where('status', 'Pending')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
<div class="section-card">
    <div class="section-header">
        <i class="fas fa-calendar-alt"></i>
        <span>Recent Bookings</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>STUDENT</th>
                <th>ROOM</th>
                <th>BEDSPACE</th>
                <th>DATE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Booking::with('user','room.bookings.user')->latest()->take(5)->get() as $booking)
@php
    $room = $booking->room;
    $totalBeds = $room->bedspace ?? 1;

    // Count only approved bookings
    $occupiedBeds = $room->bookings()->where('status', 'approved')->count();

    $availableBeds = max($totalBeds - $occupiedBeds, 0);
    $occupancyPercent = ($occupiedBeds / $totalBeds) * 100;

    // Optional: list of approved students
    $studentNames = $room->bookings()
                        ->where('status', 'approved')
                        ->with('user')
                        ->get()
                        ->pluck('user.name')
                        ->filter()
                        ->join(', ');
@endphp

                <tr>
                    <td>{{ $booking->user->name ?? 'Unknown' }}</td>
                    <td>{{ $room->room_number ?? 'N/A' }}</td>
                    <td>
                        <!-- Progress bar with tooltip showing student names -->
                        <div class="progress-bar-wrapper" title="{{ $studentNames ?: 'No students' }}">
                            <div class="progress-bar" 
                                 style="width: {{ $occupancyPercent }}%;
                                        background-color: 
                                        @if($occupancyPercent == 100) #dc3545
                                        @elseif($occupancyPercent >= 50) #ffc107
                                        @else #28a745
                                        @endif;">
                            </div>
                        </div>
                        <small>{{ $occupiedBeds }}/{{ $totalBeds }} occupied</small>
                    </td>
                    <td>{{ $booking->created_at->format('F d, Y') }}</td>
                    <td>
                        <span class="status-badge
                            @if($booking->status === 'approved') status-approved
                            @elseif($booking->status === 'rejected') status-rejected
                            @elseif($booking->status === 'cancelled') status-cancelled
                            @else status-pending
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .progress-bar-wrapper {
        width: 100%;
        background-color: #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        height: 16px;
        margin-bottom: 4px;
        cursor: pointer;
    }

    .progress-bar {
        height: 100%;
        border-radius: 8px;
        transition: width 0.3s ease;
    }

    small {
        font-size: 11px;
        color: #555;
    }
</style>


    <!-- Recent Payments -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-peso-sign"></i>
            <span>Recent Payments</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>PAYMENT ID</th>
                    <th>STUDENT</th>
                    <th>AMOUNT</th>
                    <th>ROOM NUMBER</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>NOTES</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Payment::with('user','room')->latest()->take(5)->get() as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $payment->created_at->format('F d, Y') }}</td>
                        <td>
                            <span class="status-badge
                                @if($payment->status === 'approved') status-approved
                                @elseif($payment->status === 'rejected') status-rejected
                                @elseif($payment->status === 'checkout') status-checkout
                                @else status-pending
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->notes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuToggle = document.getElementById('menuToggle');

        menuToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('open');
            } else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });
    </script>
    <script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            document.getElementById('logoutForm').submit();
        }
    }
    </script>
</body>
</html>