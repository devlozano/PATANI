<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
/* 🌟 GLOBAL RESET */
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

/* 🌈 SIDEBAR */
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

/* 🌟 CONTENT AREA */
.content {
    flex: 1;
    margin-left: 300px;
    transition: margin-left 0.3s ease;
}

.content.expanded {
    margin-left: 0;
}

/* 🌟 TOP BAR */
.top-bar {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #fffbe6;
    padding: 20px 40px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    flex-wrap: wrap;
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

/* 🌟 MAIN CONTENT */
.main-content {
    padding: 40px;
}

h1 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 40px;
}

/* 🌟 FORM SECTIONS */
.form-section,
.room-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.section-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
}

/* 🌟 FORM GRID */
.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 15px;
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-full {
    grid-column: 1 / -1;
}

/* 🌟 BUTTONS */
.submit-btn {
    background: #2196F3;
    color: white;
    border: none;
    padding: 14px 40px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    transition: 0.3s;
}

.submit-btn:hover {
    background: #0b7dda;
    transform: scale(1.02);
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

.btn-edit {
    background: #4CAF50;
    color: white;
}

.btn-edit:hover {
    background: #45a049;
    transform: scale(1.05);
}

.btn-delete {
    background: #FF4444;
    color: white;
}

.btn-delete:hover {
    background: #CC0000;
    transform: scale(1.05);
}

/* 🌟 TABLES */
table {
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
}

th, td {
    border: 1px solid #ddd;
    padding: 15px;
    font-size: 15px;
}

th {
    background: #f5f5f5;
    font-weight: 700;
    text-transform: uppercase;
}

tbody tr:hover {
    background: #f9f9f9;
}

/* 🌟 RESPONSIVE BREAKPOINTS */
@media (max-width: 1024px) {
    .form-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        transform: translateX(-100%);
        width: 100%;
        max-width: 250px;
    }
    .sidebar.open { transform: translateX(0); }
    .content { margin-left: 0; }
    .top-bar { padding: 15px 20px; flex-wrap: wrap; }
    .logo { font-size: 22px; }
    .main-content { padding: 20px; }
    h1 { font-size: 28px; }
    .form-section, .room-section { padding: 20px; }
    .form-grid { grid-template-columns: 1fr; }
    table { min-width: 600px; display: block; overflow-x: auto; }
}

@media (max-width: 480px) {
    .top-bar { padding: 12px 15px; }
    .logo { font-size: 20px; }
    .main-content { padding: 15px; }
    h1 { font-size: 24px; }
    .form-section, .room-section { padding: 15px; }
    .section-title { font-size: 18px; }
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
            <a href="{{ route('admin.report') }}" class="active">
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
            <h1>REPORTS</h1>

            <!-- All Payments Report -->
            <div class="report-section">
                <h2 class="section-title">All Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>STUDENT</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</td>
                                <td>
                                    
                            <span class="status-badge"
                                style="background: {{ $payment->status == 'Approved' ? '#4CAF50' : '#FF9800' }};">
                                {{ ucfirst($payment->status) }}
                            </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center; color:#777;">No payment records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
</body>
</html>