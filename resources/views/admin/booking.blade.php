@php
    $pending = $pending ?? collect();
    $all = $all ?? collect();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Patani Trinidad</title>
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

        .booking-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f5f5f5;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid #ddd;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-approve {
            background: #4CAF50;
            color: white;
        }

        .btn-approve:hover {
            background: #45a049;
            transform: scale(1.05);
        }

        .btn-reject {
            background: #FF4444;
            color: white;
        }

        .btn-reject:hover {
            background: #CC0000;
            transform: scale(1.05);
        }

        .btn-checkout {
            background: #2196F3;
            color: white;
        }

        .btn-checkout:hover {
            background: #0b7dda;
            transform: scale(1.05);
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .status-approve {
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

            .booking-section {
                padding: 20px;
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }

            .section-title {
                font-size: 20px;
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

            .booking-section {
                padding: 15px;
            }

            .section-title {
                font-size: 18px;
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
            <h2>Cora P. Trinidad</h2>
            <p>0912-345-6789</p>
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
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.room') ? 'active' : '' }}">
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
            <h1>Manage Bookings</h1>

            <!-- Pending Bookings Section -->
            <div class="booking-section">
                <h2 class="section-title">Pending Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>BOOKING ID</th>
                            <th>STUDENT</th>
                            <th>ROOM</th>
                            <th>DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                                                @foreach ($pending as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                            <td>{{ $booking->created_at->format('F d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('admin.booking.approve', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.booking.reject', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-reject">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

           <!-- Filter Section for Admin Booking -->
<div class="filter-container" style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:15px; align-items:center;">
    <!-- Status Filter -->
    <div>
        <label for="adminBookingStatusFilter">Filter by Status:</label>
        <select id="adminBookingStatusFilter" data-target="adminBookingsTable">
            <option value="All">All</option>
            <option value="approved">Approved</option>
            <option value="cancelled">Cancelled</option>
            <option value="checkout">Checkout</option>
        </select>
    </div>

    <!-- Search Filter -->
    <div>
        <label for="adminBookingSearchFilter">Search:</label>
        <input type="text" id="adminBookingSearchFilter" placeholder="Search by student, room, ID..." data-target="adminBookingsTable" style="padding:6px 10px; border-radius:5px; border:1px solid #ccc;">
    </div>
</div>

<!-- Admin Bookings Table -->
<div class="booking-section">
    <h2 class="section-title">All Bookings</h2>
    <table id="adminBookingsTable">
        <thead>
            <tr>
                <th>BOOKING ID</th>
                <th>STUDENT</th>
                <th>ROOM</th>
                <th>DATE</th>
                <th>STATUS</th>
                <th>CHECKOUT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                <td>{{ $booking->created_at->format('F d, Y') }}</td>
<td class="status-cell">
    <span class="status-badge 
        {{ $booking->status == 'approved' ? 'status-approve' : 
          ($booking->status == 'rejected' ? 'status-rejected' : 
          ($booking->status == 'cancelled' ? 'status-cancelled' : 'status-checkout')) }}">
        {{ ucfirst($booking->status) }}
    </span>
</td>

                <td>
                    @if ($booking->status == 'approved')
                    <form action="{{ route('admin.booking.checkout', $booking->id) }}" method="POST" class="checkout-form" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-checkout">Checkout</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- JavaScript Filter for Admin Bookings -->
<script>
const bookingStatusFilter = document.getElementById('adminBookingStatusFilter');
const bookingSearchFilter = document.getElementById('adminBookingSearchFilter');
const bookingRows = document.querySelectorAll('#adminBookingsTable tbody tr');

function filterBookings() {
    const statusValue = bookingStatusFilter.value.toLowerCase();
    const searchValue = bookingSearchFilter.value.toLowerCase();

    bookingRows.forEach(row => {
        const statusText = row.querySelector('.status-cell')?.innerText.trim().toLowerCase() || '';
        const rowText = row.innerText.toLowerCase();

        // Fix: match exact statuses like "rejected", "approved", "checkout"
        const statusMatch = statusValue === "all" || statusText === statusValue;
        const searchMatch = rowText.includes(searchValue);

        row.style.display = (statusMatch && searchMatch) ? '' : 'none';
    });
}

// Event Listeners
bookingStatusFilter.addEventListener('change', filterBookings);
bookingSearchFilter.addEventListener('input', filterBookings);

// Checkout Confirmation
document.querySelectorAll('.checkout-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const confirmed = confirm('Are you sure you want to checkout this student?');
        if(!confirmed) e.preventDefault();
    });
});
</script>

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