<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments | Patani Trinidad</title>
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

/* Main Content */
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

/* Sections & Cards */
.section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 25px;
}

.payment-card {
    background: #fffef0;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 25px;
    width: 100%;
    max-width: 100%;
}

.payment-card h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}

.payment-card .amount {
    font-size: 22px;
    font-weight: 700;
    color: #1e1e1e;
    margin-bottom: 25px;
}

.pay-btn {
    background-color: #ff9800;
    border: none;
    color: white;
    padding: 12px 0;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    font-size: 16px;
    width: 100%;
    max-width: 100%;
    display: block;
    margin: 0 auto;
}

.pay-btn:hover {
    background-color: #f57c00;
}

/* Tables */
.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    min-width: 700px;
}

table th, table td {
    padding: 12px 10px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background: #f5f5f5;
    font-weight: 600;
    font-size: 14px;
}

table tbody tr:hover {
    background: #f9f9f9;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-rejected { background: #f8d7da; color: #721c24; }
.status-approved { background: #d4edda; color: #155724; }

/* Modal */
.payment-modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    text-align: center;
    position: relative;
}

.modal-content .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 25px;
    cursor: pointer;
}

.modal-content h2 { margin-bottom: 20px; }
.modal-content select, .modal-content .submit-btn {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
    .pay-btn { width: 100%; }
    table th, table td { font-size: 13px; padding: 10px 8px; }
}

@media (max-width: 768px) {
    .sidebar { width: 300px; transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .content { margin-left: 0; }
    .top-bar { padding: 15px 20px; }
    .logo { font-size: 22px; }
    .main-content { padding: 20px; }
    h1 { font-size: 28px; margin-bottom: 25px; }
    .section, .payment-card { padding: 20px; }
    table th, table td { font-size: 12px; padding: 8px 6px; }
    .status-badge { font-size: 11px; padding: 4px 8px; }
}

@media (max-width: 480px) {
    .top-bar { padding: 12px 15px; }
    .logo { font-size: 20px; }
    .main-content { padding: 15px; }
    h1 { font-size: 24px; }
    .section, .payment-card { padding: 15px; }
    .payment-card h3 { font-size: 16px; }
    .payment-card .amount { font-size: 18px; }
    table th, table td { font-size: 11px; padding: 6px 4px; }
    .status-badge { font-size: 10px; padding: 3px 6px; }
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
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="logo">Patani Trinidad</div>
        </div>

        <div class="main-content">
            <h1>Payments</h1>

            <!-- ✅ Make Payments Section -->
            <div class="section">
    <div class="section-title">Make Payments</div>

    @foreach($rooms as $room)
        <div class="payment-card">
            <h3>Room {{ $room->room_number }} - {{ $room->room_floor }}</h3>
            <div class="amount">Monthly Rent: ₱{{ number_format($room->rent_fee, 2) }}</div>

            <form action="{{ route('payment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="amount" value="{{ $room->rent_fee }}">
            <button type="button" 
                    class="pay-btn" 
                    {{ $room->status !== 'available' ? 'disabled' : '' }} 
                    onclick="openPaymentModal({{ $room->id }}, '{{ $room->rent_fee }}')">
                {{ $room->status === 'available' ? 'Pay Now' : 'Unavailable' }}
            </button>
            </form>
        </div>
    @endforeach
</div>
<div id="paymentModal" class="payment-modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closePaymentModal()">&times;</span>
        <h2>Payment Method</h2>
        <p id="roomInfo"></p>

        <form id="paymentForm" method="POST" action="{{ route('payment.store') }}">
            @csrf
            <input type="hidden" name="room_id" id="modalRoomId">
            <input type="hidden" name="amount" id="modalAmount">

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="student_name" value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="student_email" value="{{ Auth::user()->email }}" readonly>
            </div>

            <div class="form-group">
                <label>Select Payment Method:</label>
                <select name="payment_method" required>
                    <option value="" disabled selected>-- Choose --</option>
                    <option value="gcash">Cash</option>
                    <option value="gcash">GCash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="credit_card">Credit Card</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Pay</button>
        </form>
    </div>
</div>

            <!-- ✅ Payment Records Table -->
            <div class="section">
                <div class="section-title">All Payments</div>
                <div class="table-wrapper">
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
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->room->room_number ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</td>
                                    <td>
                                        @if ($payment->status === 'Pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif ($payment->status === 'Approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @elseif ($payment->status === 'Rejected')
                                            <span class="status-badge status-rejected">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->notes ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;">No payment records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    <script>
function openPaymentModal(roomId, rentFee) {
    const modal = document.getElementById('paymentModal');
    const roomInfo = document.getElementById('roomInfo');
    const modalRoomId = document.getElementById('modalRoomId');
    const modalAmount = document.getElementById('modalAmount');

    modal.style.display = 'flex';
    roomInfo.textContent = `Room ID: ${roomId} - Amount: ₱${parseFloat(rentFee).toFixed(2)}`;
    modalRoomId.value = roomId;
    modalAmount.value = rentFee;
}


    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.style.display = 'none';
    }

    // Close modal if clicked outside content
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('paymentModal');
        if (event.target === modal) {
            closePaymentModal();
        }
    });
    </script>

</body>
</html>