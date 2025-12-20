@php
    $pending = $pending ?? collect();
    $all = $all ?? collect();
    $userPendingCounts = $pending->groupBy('user_id')->map->count();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- ✅ SweetAlert is required for the modal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; min-height: 100vh; background: #f5f5f5; }
        
        /* Sidebar & Layout */
        .sidebar { width: 300px; background: linear-gradient(to bottom, #FFD36E, #FF9800); color: #1e1e1e; display: flex; flex-direction: column; align-items: center; padding: 30px 20px; position: fixed; height: 100vh; overflow-y: auto; z-index: 100; transition: transform 0.3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-header { font-family: "Molle", cursive; font-size: 1.8rem; margin-bottom: 40px; color: #1e1e1e; text-align: center; }
        
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px; }
        .profile img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; margin-bottom: 15px; background: #ddd; }
        .profile h2 { font-size: 1.1rem; font-weight: 600; color: #1e1e1e; margin-bottom: 5px; }
        .profile p { font-size: 0.95rem; color: #333; }
        
        .menu { width: 100%; display: flex; flex-direction: column; gap: 10px; }
        .menu a { display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; text-decoration: none; color: #1e1e1e; font-weight: 500; transition: all 0.3s ease; font-size: 1rem; }
        .menu a:hover { background: rgba(255, 255, 255, 0.3); }
        .menu a.active { background: #ff8800; color: white; }
        .menu i { margin-right: 15px; font-size: 1.3rem; }
        
        .content { flex: 1; margin-left: 300px; padding: 0; transition: margin-left 0.3s ease; }
        .content.expanded { margin-left: 0; }
        
        .top-bar { display: flex; align-items: center; gap: 20px; background: #fffbe6; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .menu-toggle { background: none; border: none; font-size: 28px; cursor: pointer; padding: 5px; color: #1e1e1e; display: flex; align-items: center; }
        .logo { font-family: "Molle", cursive; font-size: 28px; color: #002d18; flex: 1; }
        
        .logout-btn { background: #FF4444; color: white; border: none; padding: 10px 25px; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .logout-btn:hover { background: #CC0000; transform: scale(1.05); }
        
        .main-content { padding: 40px; }
        h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }
        
        .booking-section { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); margin-bottom: 40px; }
        .section-title { font-size: 24px; font-weight: 700; margin-bottom: 25px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f5f5f5; padding: 15px; text-align: left; font-weight: 700; font-size: 14px; border: 1px solid #ddd; text-transform: uppercase; }
        td { padding: 15px; border: 1px solid #ddd; font-size: 15px; }
        tbody tr:hover { background: #f9f9f9; }
        
        .action-buttons { display: flex; gap: 10px; }
        .btn { padding: 8px 20px; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.3s; }
        .btn-approve { background: #4CAF50; color: white; }
        .btn-approve:hover { background: #45a049; transform: scale(1.05); }
        .btn-reject { background: #FF4444; color: white; }
        .btn-reject:hover { background: #CC0000; transform: scale(1.05); }
        .btn-checkout { background-color: #E53935; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-weight: 500; transition: background 0.3s ease; }
        .btn-checkout:hover { background-color: #C62828; transform: scale(1.05); }
        
        .status-badge { padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; display: inline-block; }
        .status-approve { background: #4CAF50; color: white; }
        .status-rejected { background: #FF4444; color: white; }
        .status-checkout { background: #757575; color: white; }
        .status-pending { background: #ff9800; color: white; }
        .status-cancelled { background: #999; color: white; }
        .status-overdue { background: #dc3545; color: white; animation: pulse 2s infinite; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.8; } 100% { opacity: 1; } }

        .multiple-badge { display: inline-block; background-color: #ffeeba; color: #856404; font-size: 0.75rem; padding: 2px 6px; border-radius: 4px; margin-top: 4px; font-weight: 600; border: 1px solid #ffe8a1; }

        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 25px; border: 1px solid #888; width: 400px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: black; }
        .modal-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; color: #333; }
        .modal-textarea { width: 100%; height: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 6px; resize: vertical; margin-bottom: 15px; font-family: inherit; }
        .modal-btn { width: 100%; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer; }

        @media (max-width: 768px) {
            .sidebar { width: 300px; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; }
            .top-bar { padding: 15px 20px; }
            .logo { font-size: 22px; }
            .main-content { padding: 20px; }
            h1 { font-size: 28px; margin-bottom: 25px; }
            .booking-section { padding: 20px; overflow-x: auto; }
            table { min-width: 800px; }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar) : asset('images/Screenshot 2025-10-28 033031.png') }}" alt="User Photo">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->contact }}</p>
        </div>
        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
            <a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> <span>Booking</span></a>
            <a href="{{ route('admin.payment') }}" class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> <span>Payments</span></a>
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.room') ? 'active' : '' }}"><i class="fas fa-door-open"></i> <span>Rooms</span></a>
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span>Reports</span></a>
        </nav>
    </aside>

    <div class="content" id="content">
        <div class="top-bar">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div class="logo">Patani Trinidad</div>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout()"><span>Logout</span> <i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>

        <div class="main-content">
            <h1>Manage Bookings</h1>

            @if(session('success'))
                <div style="background-color:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #c3e6cb; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i> <strong>{{ session('success') }}</strong>
                </div>
            @endif

            @if(session('error'))
                <div style="background-color:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #f5c6cb; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i> <strong>{{ session('error') }}</strong>
                </div>
            @endif

            {{-- PENDING BOOKINGS --}}
            <div class="booking-section">
                <h2 class="section-title" style="font-size:22px; font-weight:600; margin-bottom:18px; color:#333; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-hourglass-half" style="color:#f0a500;"></i> Pending Bookings
                </h2>
                <table style="width:100%; border-collapse:collapse; text-align:left;">
                    <thead>
                        <tr style="background:#f9fafb; color:#555;">
                            <th style="padding:12px; border-bottom:2px solid #eee;">BOOKING ID</th>
                            <th style="padding:12px; border-bottom:2px solid #eee;">BOARDERS</th>
                            <th style="padding:12px; border-bottom:2px solid #eee;">ROOM</th>
                            <th style="padding:12px; border-bottom:2px solid #eee;">BED</th>
                            <th style="padding:12px; border-bottom:2px solid #eee;">DATE</th>
                            <th style="padding:12px; border-bottom:2px solid #eee;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pending as $booking)
                            @php 
                                $userCount = $userPendingCounts[$booking->user_id] ?? 0;
                                // Calculate expiration for pending too (optional context)
                                $bookingDate = \Carbon\Carbon::parse($booking->created_at);
                                $duration = $bookingDate->diffForHumans(null, true);
                            @endphp
                            <tr style="transition: all 0.2s ease-in-out;">
                                <td style="padding:12px; border-bottom:1px solid #eee;">#{{ $booking->id }}</td>
                                <td style="padding:12px; border-bottom:1px solid #eee;">
                                    {{ $booking->user->name }}
                                    @if($userCount > 1)
                                        <br><span class="multiple-badge"><i class="fas fa-exclamation-circle"></i> {{ $userCount }} Pending Requests</span>
                                    @endif
                                </td>
                                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $booking->room->room_number ?? 'N/A' }}</td>
                                <td style="padding:12px; border-bottom:1px solid #eee;"><span style="font-weight:600; color:#e67e22;">#{{ $booking->bed_number ?? 'N/A' }}</span></td>
                                <td style="padding:12px; border-bottom:1px solid #eee;">
                                    {{ $bookingDate->format('M d, Y') }}
                                    <div style="font-size: 11px; color: #999; margin-top: 2px;">Waited: {{ $duration }}</div>
                                </td>
                                <td style="padding:12px; border-bottom:1px solid #eee;">
                                    <div class="action-buttons" style="display:flex; gap:8px;">
                                        <form action="{{ route('admin.booking.approve', $booking->id) }}" method="POST" class="approve-form" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-approve">Approve</button>
                                        </form>
                                        
                                        <button type="button" class="btn btn-reject" 
                                            onclick="openRejectModal('{{ route('admin.booking.reject', $booking->id) }}')">
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; padding:20px; color:#777;">No pending bookings.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FILTERS --}}
            <div class="filter-container" style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:15px; align-items:center;">
                <div>
                    <label for="adminBookingStatusFilter">Filter by Status:</label>
                    <select id="adminBookingStatusFilter" style="padding:6px 10px; border-radius:5px; border:1px solid #ccc;">
                        <option value="All">All</option>
                        <option value="approved">Approved</option>
                        <option value="overdue">Overdue</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="checkedout">Checkout</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="adminBookingSearchFilter">Search:</label>
                    <input type="text" id="adminBookingSearchFilter" placeholder="Search..." style="padding:6px 10px; border-radius:5px; border:1px solid #ccc;">
                </div>
            </div>

            {{-- ALL BOOKINGS --}}
            <div class="booking-section">
                <h2 class="section-title">All Bookings</h2>
                <table id="adminBookingsTable">
                    <thead>
                        <tr>
                            <th>BOOKING ID</th>
                            <th>BOARDERS</th>
                            <th>ROOM</th>
                            <th>BED</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all as $booking)
                        @php
                            // Expiration Logic
                            $status = strtolower($booking->status);
                            $bookingDate = \Carbon\Carbon::parse($booking->created_at);
                            $expirationDate = $bookingDate->copy()->addMonth();
                            $isExpired = now()->greaterThan($expirationDate);
                        @endphp
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                {{ $booking->user->name }}
                                @if($status == 'approved')
                                    <a href="{{ route('student.booking.contract', $booking->id) }}" target="_blank" title="View Contract" style="color: #007bff; margin-left: 5px;"><i class="fas fa-file-contract"></i></a>
                                @endif
                            </td>
                            <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                            <td><span style="font-weight:600; color:#e67e22;">#{{ $booking->bed_number ?? 'N/A' }}</span></td>
                            
                            {{-- ✅ UPDATED: Show Expiration --}}
<td style="padding:10px;">
    {{-- Display Booking Date --}}
    {{ $bookingDate->format('F d, Y') }}
    
    @if($status === 'approved')
        <div style="font-size: 11px; margin-top: 4px; font-weight: 500;">
            @if($isExpired)
                <span style="color: #dc3545;">Expired on {{ $expirationDate->format('F d, Y') }}</span>
            @else
                {{-- ✅ THIS IS YOUR REQUESTED FORMAT --}}
                <span style="color: #666;">Valid until: {{ $expirationDate->format('F d, Y') }}</span>
            @endif
        </div>
    @else
        <div style="font-size: 11px; color: #999; margin-top: 4px;">
            {{ $bookingDate->diffForHumans() }}
        </div>
    @endif
</td>

                            <td class="status-cell">
                                @if($booking->is_overdue)
                                    <span class="status-badge status-overdue">OVERDUE <i class="fas fa-exclamation-circle"></i></span>
                                    <div style="font-size:10px; color:#dc3545; margin-top:2px; font-weight:600;">Due: {{ \Carbon\Carbon::parse($booking->payments->last()->created_at ?? $booking->created_at)->addMonth()->format('M d') }}</div>
                                @else
                                    <span class="status-badge {{ strtolower($booking->status) == 'approved' ? 'status-approve' : (strtolower($booking->status) == 'cancelled' ? 'status-cancelled' : (strtolower($booking->status) == 'rejected' ? 'status-rejected' : (strtolower($booking->status) == 'checkout' ? 'status-checkout' : 'status-pending'))) }}">
                                    {{ ucfirst($booking->status) }}
                                    </span>
                                @endif
                                
                                @if(strtolower($booking->status) == 'rejected' && $booking->rejection_reason)
                                    <div style="font-size:11px; color:#777; margin-top:2px; font-style:italic;">"{{ Str::limit($booking->rejection_reason, 20) }}"</div>
                                @endif
                            </td>
                            <td>
                                @if (in_array(strtolower($booking->status), ['approved', 'paid']))
                                    <form action="{{ route('admin.booking.checkout', $booking->id) }}" method="POST" class="checkout-form" style="display:inline;">@csrf<button type="submit" class="btn btn-checkout"><i class="fas fa-sign-out-alt"></i> Checkout</button></form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRejectModal()">&times;</span>
            <div class="modal-title"><i class="fas fa-exclamation-triangle" style="color: #FF4444;"></i> Reject Booking</div>
            <p style="margin-bottom: 15px; font-size: 0.9rem; color: #555;">Please provide a reason for rejecting this booking.</p>
            
            <form id="rejectForm" method="POST" action="">
                @csrf
                <textarea name="rejection_reason" class="modal-textarea" required placeholder="e.g., Room is under maintenance, Gender mismatch..."></textarea>
                <button type="submit" class="btn btn-reject modal-btn">Confirm Rejection</button>
            </form>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuToggle = document.getElementById('menuToggle');
        menuToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('open'); } 
            else { sidebar.classList.toggle('collapsed'); content.classList.toggle('expanded'); }
        });
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) { sidebar.classList.remove('open'); }
            }
        });
        window.addEventListener('resize', () => { if (window.innerWidth > 768) { sidebar.classList.remove('open'); } });
        function confirmLogout() { if (confirm("Are you sure you want to log out?")) { document.getElementById('logoutForm').submit(); } }

        const bookingStatusFilter = document.getElementById('adminBookingStatusFilter');
        const bookingSearchFilter = document.getElementById('adminBookingSearchFilter');
        const bookingRows = document.querySelectorAll('#adminBookingsTable tbody tr');

        function filterBookings() {
            const statusValue = bookingStatusFilter.value.toLowerCase();
            const searchValue = bookingSearchFilter.value.toLowerCase();
            bookingRows.forEach(row => {
                const statusText = row.querySelector('.status-cell')?.innerText.trim().toLowerCase() || '';
                const rowText = row.innerText.toLowerCase();
                const statusMatch = statusValue === "all" || statusText.includes(statusValue);
                const searchMatch = rowText.includes(searchValue);
                row.style.display = (statusMatch && searchMatch) ? '' : 'none';
            });
        }
        bookingStatusFilter.addEventListener('change', filterBookings);
        bookingSearchFilter.addEventListener('input', filterBookings);

        // MODAL LOGIC
        function openRejectModal(actionUrl) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = actionUrl; 
            modal.style.display = "block";
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // CHECKOUT ALERT
            const checkoutForms = document.querySelectorAll('.checkout-form');
            checkoutForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); 
                    Swal.fire({ title: 'Checkout Tenant?', text: "Free up bed space?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#E53935', cancelButtonColor: '#3085d6', confirmButtonText: 'Yes, Checkout' }).then((result) => { if (result.isConfirmed) { form.submit(); } });
                });
            });

            // ✅ APPROVE ALERT
            const approveForms = document.querySelectorAll('.approve-form');
            approveForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); 
                    Swal.fire({ 
                        title: 'Approve Booking?', 
                        text: "This will confirm the reservation.", 
                        icon: 'question', 
                        showCancelButton: true, 
                        confirmButtonColor: '#4CAF50', 
                        cancelButtonColor: '#666', 
                        confirmButtonText: 'Yes, Approve' 
                    }).then((result) => { 
                        if (result.isConfirmed) { form.submit(); } 
                    });
                });
            });
        });
    </script>
</body>
</html>