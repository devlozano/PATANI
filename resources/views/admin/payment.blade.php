<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
<style>
/* Reset & Global */
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
    overflow-x: hidden;
}

/* Sidebar */
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
.profile h2 { font-size: 1.1rem; font-weight: 600; color: #1e1e1e; margin-bottom: 5px; }
.profile p { font-size: 0.95rem; color: #333; }
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
.menu a:hover { background: rgba(255, 255, 255, 0.3); }
.menu a.active { background: #ff8800; color: white; }
.menu i { margin-right: 15px; font-size: 1.3rem; }

/* Content */
.content {
    flex: 1;
    margin-left: 300px;
    transition: margin-left 0.3s ease;
}
.content.expanded { margin-left: 0; }

/* Top Bar */
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
    color: #1e1e1e;
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
.logout-btn:hover { background: #CC0000; transform: scale(1.05); }

/* Main Content */
.main-content { padding: 40px; }
h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }

/* Payment Section */
.payment-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 40px;
    overflow-x: auto;
}
.section-title { font-size: 24px; font-weight: 700; margin-bottom: 25px; }
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
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
td { padding: 15px; border: 1px solid #ddd; font-size: 15px; }
tbody tr:hover { background: #f9f9f9; }

/* Buttons & Status */
.action-buttons { display: flex; gap: 10px; }
.btn {
    padding: 8px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s;
    border: none;
}
.btn-approve { background: #4CAF50; color: white; }
.btn-approve:hover { background: #45a049; transform: scale(1.05); }
.btn-reject { background: #FF4444; color: white; }
.btn-reject:hover { background: #CC0000; transform: scale(1.05); }

.status-badge {
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
}
.status-approved { background: #4CAF50; color: white; }
.status-rejected { background: #FF4444; color: white; }
.status-pending { background: #fff3cd; color: #856404; }

/* Filter Styles */
.filter-container { margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; }
.filter-group { display: flex; flex-direction: column; gap: 5px; }
.filter-group label { font-size: 14px; font-weight: 500; color: #555; }
.filter-control { padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; font-family: inherit; width: 220px; }
.filter-control:focus { outline: none; border-color: #ff9800; }

/* Modal */
.reject-modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}
.reject-modal .modal-content {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    position: relative;
}
.reject-modal .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 25px;
    cursor: pointer;
}
.reject-modal textarea {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-top: 10px;
    margin-bottom: 15px;
}
.submit-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
}
.submit-btn:hover { background-color: #c0392b; }

/* Responsive */
@media (max-width: 1024px) {
    .content { margin-left: 0; }
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .main-content { padding: 30px; }
    h1 { font-size: 32px; }
    .payment-section { padding: 25px; }
    table { min-width: 700px; }
    .section-title { font-size: 22px; }
}
@media (max-width: 768px) {
    .top-bar { padding: 15px 20px; }
    .logo { font-size: 22px; }
    .main-content { padding: 20px; }
    h1 { font-size: 28px; margin-bottom: 25px; }
    .payment-section { padding: 20px; overflow-x: auto; }
    table { min-width: 600px; }
    .section-title { font-size: 20px; }
    .filter-container { flex-direction: column; align-items: stretch; }
    .filter-control { width: 100%; }
}
@media (max-width: 480px) {
    .top-bar { padding: 12px 15px; gap: 10px; }
    .logo { font-size: 20px; }
    .main-content { padding: 15px; }
    h1 { font-size: 24px; }
    .payment-section { padding: 15px; }
    .section-title { font-size: 18px; }
    table { min-width: 500px; font-size: 13px; }
}
</style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <img src="/images/Screenshot 2025-10-28 033031.png" alt="Admin Photo">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->contact }}</p>
        </div>
        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i><span>Booking</span>
            </a>
            <a href="{{ route('admin.payment') }}" class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i><span>Payments</span>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i><span>Rooms</span>
            </a>
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i><span>Reports</span>
            </a>
        </nav>
    </aside>

    <div class="content" id="content">
        <div class="top-bar">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="logo">Patani Trinidad</div>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout()">
                    <span>Logout</span><i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>

        <div class="main-content">
            <h1>Manage Payments</h1>

            {{-- ✅ SUCCESS MESSAGE BLOCK --}}
            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            @endif

            {{-- ❌ ERROR MESSAGE BLOCK --}}
            @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
                <strong>{{ session('error') }}</strong>
            </div>
            @endif

            <div class="payment-section">
                <h2 class="section-title">Pending Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>PAYMENT ID</th>
                            <th>BOARDERS</th>
                            <th>AMOUNT</th>
                            <th>ROOM NUMBER</th>
                            <th>DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingPayments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->room->room_number ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('admin.payment.approve', $payment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">Approve</button>
                                    </form>

                                    <button type="button" class="btn btn-reject" onclick="openRejectModal({{ $payment->id }})">
                                        Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">No pending payments.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="payment-section">
                <h2 class="section-title">All Payments History</h2>
                
                <div class="filter-container">
                    <div class="filter-group">
                        <label for="statusFilter">Status Filter:</label>
                        <select id="statusFilter" class="filter-control">
                            <option value="All">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="searchFilter">Search Payments:</label>
                        <input type="text" id="searchFilter" class="filter-control" placeholder="Name, Payment ID, Notes...">
                    </div>
                </div>

                <table id="paymentsTable">
                    <thead>
                        <tr>
                            <th>PAYMENT ID</th>
                            <th>BOARDERS</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>NOTES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</td>
                            <td class="status-cell">
                                @if($payment->status === 'Pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif($payment->status === 'Approved')
                                    <span class="status-badge status-approved">Approved</span>
                                @elseif($payment->status === 'Rejected')
                                    <span class="status-badge status-rejected">Rejected</span>
                                @else
                                    <span class="status-badge">{{ $payment->status }}</span>
                                @endif
                            </td>
                            <td>{{ $payment->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">No payments history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="reject-modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeRejectModal()">&times;</span>
            <h3>Reject Payment</h3>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <label for="reason">Reason for rejection:</label>
                <textarea name="reason" id="reason" rows="4" placeholder="Enter reason..." required></textarea>
                <button type="submit" class="submit-btn">Submit Rejection</button>
            </form>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuToggle = document.getElementById('menuToggle');

        menuToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) sidebar.classList.toggle('open');
            else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            }
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Reject Modal Logic
        function openRejectModal(paymentId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            
            modal.style.display = 'flex';
            // Ensure you have this route defined: Route::post('/admin/payment/{id}/reject', ...)
            form.action = `/admin/payment/${paymentId}/reject`; 
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) {
                closeRejectModal();
            }
        });

        function confirmLogout() {
            if(confirm('Are you sure you want to logout?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // ✅ FILTER LOGIC
        const statusFilter = document.getElementById('statusFilter');
        const searchFilter = document.getElementById('searchFilter');
        const tableRows = document.querySelectorAll('#paymentsTable tbody tr');

        function filterPayments() {
            const statusValue = statusFilter.value; // e.g., "Approved" or "All"
            const searchValue = searchFilter.value.toLowerCase();

            tableRows.forEach(row => {
                // Get Status text from the status-cell
                const statusCell = row.querySelector('.status-cell');
                const statusText = statusCell ? statusCell.innerText.trim() : '';
                
                // Get all row text for searching
                const rowText = row.innerText.toLowerCase();

                // Check Matches
                const statusMatch = (statusValue === "All") || (statusText === statusValue);
                const searchMatch = rowText.includes(searchValue);

                // Show/Hide
                if(statusMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Event Listeners
        statusFilter.addEventListener('change', filterPayments);
        searchFilter.addEventListener('keyup', filterPayments); // keyup for instant typing search
    </script>
</body>
</html>