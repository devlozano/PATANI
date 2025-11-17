<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

.avatar {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.avatar-img {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-initials {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #FF8D01;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 600;
    color: #fffff0;
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

/* ================================
   PAYMENTS CARD SECTION
   ================================ */

.payments-section {
    width: 100%;
    padding: 0 40px; /* Aligns with .main-content padding */
}

/* Card container */
.payments-card {
    margin-top: 20px;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e0e0e0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Header */
.payments-card .card-header {
    background: linear-gradient(to right, #FFD36E, #FF9800);
    color: #1e1e1e;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 18px 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.payments-card .card-header i {
    font-size: 26px;
    color: #fff;
    background: #ff9800;
    padding: 8px;
    border-radius: 8px;
}

/* Table */
.payments-card table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

.payments-card th,
.payments-card td {
    padding: 14px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f2f2f2;
}

.payments-card th {
    font-weight: 600;
    color: #444;
    text-transform: uppercase;
    font-size: 0.85rem;
    background: #fff8e1;
    border-bottom: 2px solid #ffe0b2;
}

.payments-card td {
    color: #333;
}

.payments-card tr:hover {
    background-color: #fffbea;
    transition: background-color 0.2s ease;
}

/* Status badges */
.payments-card .badge {
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 6px;
}

.payments-card .badge.bg-success {
    background-color: #4caf50 !important;
}

.payments-card .badge.bg-warning {
    background-color: #ffb300 !important;
    color: #fff !important;
}

.payments-card .badge.bg-secondary {
    background-color: #9e9e9e !important;
}

/* Empty state */
.payments-empty {
    padding: 50px 0;
    text-align: center;
    color: #666;
    background-color: #fffef9;
    border-top: 1px solid #f1f1f1;
    border-radius: 0 0 12px 12px;
}

.payments-empty i {
    font-size: 60px;
    color: #ffb300;
    margin-bottom: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .payments-section {
        padding: 0 20px;
    }

    .payments-card th,
    .payments-card td {
        padding: 12px 16px;
    }

    .payments-card .card-header {
        font-size: 1rem;
        padding: 14px 18px;
    }

    .payments-card .card-header i {
        font-size: 22px;
        padding: 6px;
    }
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
 <div class="avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-img">
            @else
                <div class="avatar-initials">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' '), 1, 1)) }}
                </div>
            @endif
        </div>

    <!-- User info -->
    <h2>{{ Auth::user()->name }}</h2>
    <p>{{ Auth::user()->contact }}</p>
</div>


        <div class="menu">
    <a href="{{ route('dash') }}" class="{{ request()->routeIs('dash') ? 'active' : '' }}">
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
        @if($room)
            <i class="bi {{ in_array($room->status, ['approved', 'occupied']) ? 'bi-door-open' : 'bi-door-closed' }}"></i>
            <span>
                My Room 
                @if(in_array($room->status, ['approved', 'occupied']))
                    : {{ $room->room_number ?? 'N/A' }}
                @else
                    ({{ ucfirst($room->status) }})
                @endif
            </span>
        @else
            <i class="bi bi-door-closed"></i>
            <span>My Room</span>
        @endif
    </div>

    @if($room)
        {{-- Show details for approved or occupied rooms --}}
        @if(in_array($room->status, ['approved', 'occupied']))
            <div class="room-details">
                <p><strong>Room Number:</strong> {{ $room->room_number ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($room->status) }}</p>
            </div>
        @else
            {{-- If booking exists but not approved --}}
            <div class="room-empty">
                <i class="bi bi-door-closed"></i>
                <p>Your room request is <strong>{{ ucfirst($room->status) }}</strong>. Please wait for approval.</p>
                <a href="{{ route('student.booking') }}">
                    <button class="book-btn" type="button">BOOK NOW</button>
                </a>
            </div>
        @endif
    @else
        {{-- No booking at all --}}
        <div class="room-empty">
            <i class="bi bi-door-closed"></i>
            <p>You don't have a room yet.</p>
            <a href="{{ route('student.booking') }}">
                <button class="book-btn" type="button">BOOK NOW</button>
            </a>
        </div>
    @endif
</div>

</div> <!-- end of .dashboard-grid -->

<div class="payments-full-width">
    <div class="payments-card border-0 shadow-sm">
        <!-- Card Header -->
        <div class="card-header d-flex align-items-center justify-content-between"
             style="background: linear-gradient(90deg, #ff9800, #ffb84d); color: white; border: none;">
            <div class="d-flex align-items-center">
                <i class="bi bi-credit-card me-2 fs-5"></i>
                <span class="fw-semibold">All Payments</span>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-0">
            @if(isset($payments) && $payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-uppercase text-muted small">
                                <th class="text-start">Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr class="align-middle">
                                    <!-- Amount -->
                                    <td class="text-start fw-semibold">
                                        ₱{{ number_format($payment->amount, 2) }}
                                    </td>

                                    <!-- Status -->
                                    <td class="text-center">
                                        @if($payment->status === 'paid')
                                            <span class="badge bg-success px-3 py-2">{{ ucfirst($payment->status) }}</span>
                                        @elseif($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2">{{ ucfirst($payment->status) }}</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">{{ ucfirst($payment->status ?? 'Unknown') }}</span>
                                        @endif
                                    </td>

                                    <!-- Date -->
                                    <td class="text-end text-muted">
                                        {{ $payment->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="payments-empty text-center py-5">
                    <i class="bi bi-exclamation-circle fs-1 text-muted"></i>
                    <p class="mt-3 mb-0 text-secondary">No payments found.</p>
                </div>
            @endif
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