<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

    <style>
/* 🌟 GLOBAL RESET */
* { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
body { display: flex; min-height: 100vh; background: #f5f5f5; }

/* 🌈 SIDEBAR */
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

/* 🌟 CONTENT AREA */
.content { flex: 1; margin-left: 300px; transition: margin-left 0.3s ease; }
.content.expanded { margin-left: 0; }

/* 🌟 TOP BAR */
.top-bar { display: flex; align-items: center; gap: 20px; background: #fffbe6; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex-wrap: wrap; }
.menu-toggle { background: none; border: none; font-size: 28px; cursor: pointer; padding: 5px; color: #1e1e1e; display: flex; align-items: center; }
.logo { font-family: "Molle", cursive; font-size: 28px; color: #002d18; flex: 1; }
.logout-btn { background: #FF4444; color: white; border: none; padding: 10px 25px; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
.logout-btn:hover { background: #CC0000; transform: scale(1.05); }

/* 🌟 MAIN CONTENT */
.main-content { padding: 40px; }
h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }

/* 🌟 REPORT SECTIONS */
.report-section { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 40px; }
.section-title { font-size: 24px; font-weight: 700; margin-bottom: 25px; }

/* 🌟 FILTER BAR STYLES */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #eee;
    margin-bottom: 25px;
    align-items: flex-end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 180px;
}

.filter-group label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
    text-transform: uppercase;
}

.filter-input {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-family: inherit;
    font-size: 14px;
    width: 100%;
}

.filter-input:focus {
    outline: none;
    border-color: #ff9800;
    box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
}

/* 🌟 ACTION BUTTONS */
.btn-print {
    background: #2196F3;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    height: 42px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}
.btn-print:hover { background: #1976D2; }

.btn-csv {
    background: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    height: 42px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}
.btn-csv:hover { background: #388E3C; }

.btn-reset {
    background: #757575;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    height: 42px;
    transition: 0.3s;
}
.btn-reset:hover { background: #616161; }

/* 🌟 STATUS BADGES */
.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
    text-transform: uppercase;
}

/* 🌟 TABLES */
table { width: 100%; border-collapse: collapse; overflow-x: auto; }
th, td { border: 1px solid #eee; padding: 15px; font-size: 15px; text-align: left; }
th { background: #fffbe6; font-weight: 700; text-transform: uppercase; color: #333; }
tbody tr:hover { background: #fafafa; }

/* 🌟 PRINT STYLES */
@media print {
    @page { size: landscape; margin: 1cm; }
    body { background: white; -webkit-print-color-adjust: exact; }
    .sidebar, .top-bar, .filter-bar, .section-title, .logout-btn { display: none !important; }
    .content { margin: 0; padding: 0; width: 100%; }
    .main-content { padding: 0; }
    .report-section { box-shadow: none; padding: 0; border: none; }
    h1 { font-size: 24px; margin-bottom: 10px; text-align: center; }
    h1::before { content: "Patani Trinidad Boarding House - Payment Report"; display: block; font-size: 20px; margin-bottom: 5px; color: #333; }
    h1 { visibility: hidden; height: 50px; }
    h1::before { visibility: visible; }
    table { width: 100%; border: 2px solid #000; font-size: 12px; }
    th { background-color: #ddd !important; border: 1px solid #000; color: black; }
    td { border: 1px solid #000; }
    .status-badge { border: 1px solid #000; color: black !important; background: none !important; font-weight: bold; }
    tr[style*="display: none"] { display: none !important; }
}

/* 🌟 RESPONSIVE */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); width: 100%; max-width: 250px; }
    .sidebar.open { transform: translateX(0); }
    .content { margin-left: 0; }
    .top-bar { padding: 15px 20px; }
    .main-content { padding: 20px; }
    h1 { font-size: 28px; }
    table { min-width: 600px; display: block; overflow-x: auto; }
    .filter-bar { flex-direction: column; align-items: stretch; }
}
</style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>
        <div class="profile">
            <img src="/images/Screenshot 2025-10-28 033031.png" alt="User Photo">
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
            <a href="{{ route('admin.report') }}" class="active">
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
            <h1>REPORTS</h1>

            <div class="report-section">
                <h2 class="section-title">Payment History Report</h2>

                <div class="filter-bar">
                    <div class="filter-group">
                        <label>Search by Name</label>
                        <input type="text" id="searchInput" class="filter-input" placeholder="e.g. Juan Dela Cruz">
                    </div>
                    
                    <div class="filter-group">
                        <label>Status</label>
                        <select id="statusFilter" class="filter-input">
                            <option value="all">All Statuses</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>From Date</label>
                        <input type="date" id="startDate" class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label>To Date</label>
                        <input type="date" id="endDate" class="filter-input">
                    </div>

                    <div class="filter-group" style="flex-direction: row; gap: 10px; flex-wrap: wrap;">
                        <button class="btn-print" onclick="window.print()">
                            <i class="fas fa-print"></i> PDF
                        </button>
                        <button class="btn-csv" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <button class="btn-reset" onclick="resetFilters()">
                            Reset
                        </button>
                    </div>
                </div>

                <table id="reportsTable">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>AMOUNT</th>
                            <th>PAYMENT DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td class="student-name">{{ $payment->user->name ?? 'Unknown' }}</td>
                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="payment-date" data-date="{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d') }}">
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}
                                </td>
                                <td>
                                    @php
                                        $statusColor = match(strtolower($payment->status)) {
                                            'approved' => '#4CAF50', // Green
                                            'pending' => '#FF9800',  // Orange
                                            'rejected' => '#F44336', // Red
                                            default => '#9E9E9E',
                                        };
                                    @endphp
                                    <span class="status-badge status-text" style="background: {{ $statusColor }};">
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
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuToggle = document.getElementById('menuToggle');

        menuToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('open'); }
            else { sidebar.classList.toggle('collapsed'); content.classList.toggle('expanded'); }
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                document.getElementById('logoutForm').submit();
            }
        }

        // ✅ FILTERING LOGIC
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const tableRows = document.querySelectorAll('#reportsTable tbody tr');

        function filterReports() {
            const searchValue = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
            const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

            if(startDate) startDate.setHours(0,0,0,0);
            if(endDate) endDate.setHours(23,59,59,999);

            tableRows.forEach(row => {
                const nameText = row.querySelector('.student-name')?.innerText.toLowerCase() || '';
                const statusText = row.querySelector('.status-text')?.innerText.toLowerCase() || '';
                const dateStr = row.querySelector('.payment-date')?.getAttribute('data-date');
                const rowDate = dateStr ? new Date(dateStr) : null;

                const nameMatch = nameText.includes(searchValue);
                const statusMatch = (statusValue === 'all') || (statusText === statusValue);
                let dateMatch = true;
                if (rowDate) {
                    if (startDate && rowDate < startDate) dateMatch = false;
                    if (endDate && rowDate > endDate) dateMatch = false;
                }

                if (nameMatch && statusMatch && dateMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function resetFilters() {
            searchInput.value = '';
            statusFilter.value = 'all';
            startDateInput.value = '';
            endDateInput.value = '';
            filterReports();
        }

        searchInput.addEventListener('keyup', filterReports);
        statusFilter.addEventListener('change', filterReports);
        startDateInput.addEventListener('change', filterReports);
        endDateInput.addEventListener('change', filterReports);

        // ✅ EXPORT TO EXCEL (FIXED FOR WIDE COLUMNS)
        function exportToExcel() {
            // 1. Clone the table to avoid modifying the original
            const originalTable = document.getElementById('reportsTable');
            const tableClone = originalTable.cloneNode(true);
            
            // 2. Remove hidden rows from the clone
            const rows = tableClone.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (row.style.display === 'none') {
                    row.remove();
                }
            });

            // 3. Convert Table to Worksheet
            const ws = XLSX.utils.table_to_sheet(tableClone);

            // 4. ✅ SET COLUMN WIDTHS (Fixes ####### issue)
            const wscols = [
                {wch: 30}, // Student Name (Width: 30 chars)
                {wch: 20}, // Amount
                {wch: 25}, // Payment Date
                {wch: 15}  // Status
            ];
            ws['!cols'] = wscols;

            // 5. Create Workbook and Append Sheet
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Payment Report");
            
            // 6. Download file
            XLSX.writeFile(wb, 'Patani_Payment_Report.xlsx');
        }

    </script>
</body>
</html>