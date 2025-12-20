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
        
        .content { flex: 1; margin-left: 300px; padding: 0; transition: margin-left 0.3s ease; min-width: 0; }
        .content.expanded { margin-left: 0; }
        
        .top-bar { display: flex; align-items: center; gap: 20px; background: #fffbe6; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .menu-toggle { background: none; border: none; font-size: 28px; cursor: pointer; padding: 5px; color: #1e1e1e; display: flex; align-items: center; }
        .logo { font-family: "Molle", cursive; font-size: 28px; color: #002d18; flex: 1; }
        
        .logout-btn { background: #FF4444; color: white; border: none; padding: 10px 25px; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .logout-btn:hover { background: #CC0000; transform: scale(1.05); }
        
        .main-content { padding: 40px; overflow-x: auto; }
        h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }
        
        /* Payment Section (Reusing .booking-section style) */
        .payment-section { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); margin-bottom: 40px; overflow-x: auto; }
        .section-title { font-size: 24px; font-weight: 700; margin-bottom: 25px; }
        
        table { width: 100%; border-collapse: collapse; min-width: unset; table-layout: auto; }
        th { background: #f5f5f5; padding: 15px; text-align: left; font-weight: 700; font-size: 14px; border: 1px solid #ddd; text-transform: uppercase; white-space: nowrap; }
        td { padding: 15px; border: 1px solid #ddd; font-size: 15px; white-space: normal; vertical-align: middle; }
        tbody tr:hover { background: #f9f9f9; }
        
        /* Buttons */
        .action-buttons { display: flex; gap: 10px; }
        .btn { padding: 8px 20px; border: none; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.3s; }
        .btn-approve { background: #4CAF50; color: white; }
        .btn-approve:hover { background: #45a049; transform: scale(1.05); }
        .btn-reject { background: #FF4444; color: white; }
        .btn-reject:hover { background: #CC0000; transform: scale(1.05); }
        
        .btn-view-proof { background: #007bff; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; border: none; display: flex; align-items: center; gap: 5px; text-decoration: none; width: fit-content; white-space: nowrap;}
        .btn-view-proof:hover { background: #0056b3; }

        /* Status Badges */
        .status-badge { padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; display: inline-block; white-space: nowrap; }
        .status-approved { background: #4CAF50; color: white; }
        .status-rejected { background: #FF4444; color: white; }
        .status-pending { background: #ff9800; color: white; }

        /* Filter Styles */
        .filter-container { margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        .filter-group label { font-size: 13px; font-weight: 500; color: #555; }
        .filter-control { padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; font-family: inherit; width: 200px; }
        .filter-control:focus { outline: none; border-color: #ff9800; }

        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 15% auto; padding: 25px; border: 1px solid #888; width: 400px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); position: relative; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: 15px; top: 10px; }
        .close:hover { color: black; }
        .modal-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; color: #333; }
        .modal-textarea { width: 100%; height: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 6px; resize: vertical; margin-bottom: 15px; font-family: inherit; }
        .modal-btn { width: 100%; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer; border: none; color: white; background: #FF4444; }
        .modal-btn:hover { background: #CC0000; }

        /* Image Modal (Zoom) */
        .image-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); display: none; justify-content: center; align-items: center; z-index: 2000; cursor: zoom-out; }
        .image-modal img { max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.5); object-fit: contain; }

        @media (max-width: 768px) {
            .sidebar { width: 300px; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; min-width: 0; }
            .top-bar { padding: 15px 20px; }
            .logo { font-size: 22px; }
            .main-content { padding: 20px; overflow-x: auto; }
            h1 { font-size: 28px; margin-bottom: 25px; }
            .payment-section { padding: 20px; overflow-x: auto; }
            table { min-width: unset; table-layout: auto; }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar) : asset('images/Screenshot 2025-10-28 033031.png') }}" alt="Admin Photo">
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->contact }}</p>
        </div>
        <nav class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.booking') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> <span>Booking</span>
            </a>
            <a href="{{ route('admin.payment') }}" class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> <span>Payments</span>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> <span>Rooms</span>
            </a>
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
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
                    <span>Logout</span> <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>

        <div class="main-content">
            <h1>Manage Payments</h1>

            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            @endif

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
                            <th>METHOD</th>
                            <th>PROOF</th>
                            <th>ROOM NO.</th>
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
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>
                                @if($payment->proof_image)
                                    <button class="btn-view-proof" onclick="openImageModal('{{ asset('storage/'.$payment->proof_image) }}')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                @else
                                    <span style="color: #999; font-size: 12px; font-style: italic;">No Image</span>
                                @endif
                            </td>
                            <td>{{ $payment->room->room_number ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('admin.payment.approve', $payment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">Approve</button>
                                    </form>
                                    <button type="button" class="btn btn-reject" onclick="openRejectModal({{ $payment->id }})">Reject</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">No pending payments.</td>
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
                            <th>METHOD</th>
                            <th>PROOF</th>
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
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>
                                @if($payment->proof_image)
                                    <button class="btn-view-proof" onclick="openImageModal('{{ asset('storage/'.$payment->proof_image) }}')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                @else
                                    <span style="color: #ccc;">-</span>
                                @endif
                            </td>
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
                            <td colspan="8" style="text-align:center;">No payments history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRejectModal()">&times;</span>
            <div class="modal-title">Reject Payment</div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <label style="display:block; margin-bottom:5px; font-weight:500;">Reason for rejection:</label>
                <textarea name="reason" class="modal-textarea" placeholder="Enter reason..." required></textarea>
                <button type="submit" class="modal-btn">Submit Rejection</button>
            </form>
        </div>
    </div>

    {{-- Image Zoom Modal --}}
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <img id="zoomedImage" src="" alt="Proof of Payment">
    </div>

    <script>
        // Sidebar Toggle Logic
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
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });

        // Reject Modal Logic
        function openRejectModal(paymentId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            modal.style.display = 'block';
            form.action = `/admin/payment/${paymentId}/reject`; 
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) closeRejectModal();
        });

        // Image Modal Logic
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('zoomedImage');
            img.src = src;
            modal.style.display = 'flex';
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        function confirmLogout() {
            if(confirm('Are you sure you want to logout?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // FILTER LOGIC
        const statusFilter = document.getElementById('statusFilter');
        const searchFilter = document.getElementById('searchFilter');
        const tableRows = document.querySelectorAll('#paymentsTable tbody tr');

        function filterPayments() {
            const statusValue = statusFilter.value; 
            const searchValue = searchFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const statusCell = row.querySelector('.status-cell');
                const statusText = statusCell ? statusCell.innerText.trim() : '';
                const rowText = row.innerText.toLowerCase();

                const statusMatch = (statusValue === "All") || (statusText === statusValue);
                const searchMatch = rowText.includes(searchValue);

                if(statusMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        statusFilter.addEventListener('change', filterPayments);
        searchFilter.addEventListener('keyup', filterPayments);
    </script>
</body>
</html>