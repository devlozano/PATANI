<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings | Patani Trinidad</title>
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

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .room-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
        }

        .room-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #FFD36E 0%, #FFA726 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
        }

        .room-details {
            padding: 20px;
        }

        .room-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .room-price {
            font-size: 18px;
            font-weight: 700;
            color: #ff8800;
            margin-bottom: 10px;
        }

        .room-desc {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .room-info {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #555;
        }

        .room-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .amenities {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .status-cancelled {
    background: #FF8800; /* or any color you like */
    color: white;
}
        .status-rejected {
    background: #f44336; /* or any color you like */
    color: white;
}
        .status-pending {
    background: #ff9800; /* or any color you like */
    color: white;
}
        .status-approved {  
    background: #4caf50; /* or any color you like */
    color: white;
}

        .amenity-tag {
            background: #f0f0f0;
            border-radius: 15px;
            padding: 5px 12px;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .book-btn {
            width: 100%;
            background-color: #ff9800;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .book-btn:hover {
            background-color: #f57c00;
        }

        .book-btn.unavailable {
            background-color: #e0e0e0;
            color: #999;
            cursor: not-allowed;
        }

        .book-btn.unavailable:hover {
            background-color: #e0e0e0;
        }

        .my-booking-card {
            background: #fff;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking-info h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .booking-date {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            background: #4caf50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .rent-amount {
            font-size: 24px;
            font-weight: 700;
            color: #1e1e1e;
        }

        .pay-btn {
            background-color: #ff9800;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }

        .pay-btn:hover {
            background-color: #f57c00;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                padding: 15px 20px;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 24px;
            }

            .my-booking-card {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <img src="/images/image 39.jpg" alt="User Photo">
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
            <button class="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="logo">Patani Trinidad</div>
        </div>

        <h1>Bookings</h1>

{{-- ✅ Available Rooms --}}
<div class="section">
    <div class="section-title">Available Rooms</div>
    <div class="rooms-grid">
        @foreach($rooms as $room)
            <div class="room-card">
                <div class="room-image">🏢</div>
                <div class="room-details">
                    <div class="room-name">{{ $room->room_number }}</div>
                    <div class="room-price">₱{{ number_format($room->rent_fee, 2) }}/Month</div>
                    <div class="room-desc">{{ $room->description }}</div>

<form action="{{ route('student.booking.store') }}" method="POST"> 
    @csrf
    <input type="hidden" name="room_id" value="{{ $room->id }}"> 
    <button type="submit" class="book-btn {{ $room->status !== 'available' ? 'unavailable' : '' }}" 
        {{ $room->status !== 'available' ? 'disabled' : '' }}> 
        {{ $room->status === 'available' ? 'BOOK NOW' : 'Unavailable' }} 
    </button> 
</form>
                </div>
            </div>
        @endforeach
    </div>
</div>

        {{-- ✅ My Bookings --}}
        <div class="section">
            <div class="section-title"><i class="bi bi-calendar-check"></i> My Bookings</div>

            @forelse($bookings as $booking)
                <div class="my-booking-card">
                    <div class="booking-info">
                        <h3>{{ $booking->room->name }}</h3>
                        <div class="booking-date">Booked on {{ $booking->created_at->format('F d, Y') }}</div>
                        <span class="status-badge 
                            @if($booking->status === 'approved') status-approved
                            @elseif($booking->status === 'rejected') status-rejected
                            @elseif($booking->status === 'cancelled') status-cancelled
                            @else status-pending
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>

            <div class="rent-amount">
                Monthly Rent: ₱{{ number_format($booking->room->rent_fee ?? 0, 2) }}
            </div>
                    </div>
                    @if($booking->status === 'approved')
                        <button class="pay-btn">Pay Now</button>
                    @endif
                </div>
            @empty
                <p>No current bookings yet.</p>
            @endforelse
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