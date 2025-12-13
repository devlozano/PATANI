<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments | Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        /* --- CSS STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; min-height: 100vh; background: #f5f5f5; }
        .sidebar { width: 300px; background: linear-gradient(to bottom, #FFD36E, #FF9800); color: #1e1e1e; display: flex; flex-direction: column; align-items: center; padding: 30px 20px; position: fixed; height: 100vh; overflow-y: auto; z-index: 100; transition: transform 0.3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-header { font-family: "Molle", cursive; font-size: 1.8rem; margin-bottom: 40px; color: #1e1e1e; text-align: center; }
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px; }
        .avatar-img { width: 75px; height: 75px; border-radius: 50%; object-fit: cover; }
        .avatar-initials { width: 50px; height: 50px; border-radius: 50%; background: #FF8D01; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; color: #fffff0; }
        .profile h2 { font-size: 1.1rem; font-weight: 600; color: #1e1e1e; margin-bottom: 5px; }
        .profile p { font-size: 0.95rem; color: #333; }
        .menu { width: 100%; display: flex; flex-direction: column; gap: 10px; }
        .menu a { display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; text-decoration: none; color: #1e1e1e; font-weight: 500; transition: all 0.3s ease; font-size: 1rem; }
        .menu a:hover { background: rgba(255, 255, 255, 0.3); }
        .menu a.active { background: #ff8800; color: white; }
        .menu i { margin-right: 15px; font-size: 1.3rem; }
        .content { flex: 1; margin-left: 365px; padding: 0; transition: margin-left 0.3s ease; }
        .content.expanded { margin-left: 0; }
        .top-bar { display: flex; align-items: center; gap: 20px; background: #fffbe6; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .menu-toggle { background: none; border: none; font-size: 28px; cursor: pointer; padding: 5px; color: #1e1e1e; display: flex; align-items: center; }
        .logo { font-family: "Molle", cursive; font-size: 28px; color: #002d18; }
        .main-content { padding: 40px; }
        h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }
        .section { background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e0e0e0; }
        .section-title { font-size: 20px; font-weight: 600; margin-bottom: 25px; }
        .payment-card { background: #fffef0; border-radius: 12px; padding: 30px; margin-bottom: 25px; width: 100%; max-width: 100%; }
        .payment-card h3 { font-size: 20px; font-weight: 600; margin-bottom: 10px; }
        .payment-card .amount { font-size: 22px; font-weight: 700; color: #1e1e1e; margin-bottom: 25px; }
        .pay-btn { background-color: #ff9800; border: none; color: white; padding: 12px 0; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 16px; width: 100%; display: block; margin: 0 auto; }
        .pay-btn:hover { background-color: #f57c00; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; min-width: 700px; }
        table th, table td { padding: 12px 10px; text-align: left; border: 1px solid #ddd; }
        table th { background: #f5f5f5; font-weight: 600; font-size: 14px; }
        table tbody tr:hover { background: #f9f9f9; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-approved { background: #d4edda; color: #155724; }
        .payment-modal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; z-index: 999; }
        .modal-content { background: #fff; padding: 30px; border-radius: 10px; width: 400px; max-width: 90%; text-align: center; position: relative; max-height: 90vh; overflow-y: auto;}
        .modal-content .close { position: absolute; top: 10px; right: 15px; font-size: 25px; cursor: pointer; }
        .modal-content h2 { margin-bottom: 20px; }
        .modal-content select, .modal-content .submit-btn { width: 100%; padding: 10px; margin-top: 15px; }
        
        /* New Style for Account Info Box */
        .account-info-box {
            background: #f8f9fa;
            border: 1px dashed #ccc;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            text-align: left;
            display: none; /* Hidden by default */
        }
        .account-info-box h5 { margin: 0 0 5px 0; font-size: 14px; color: #333; }
        .account-info-box p { margin: 3px 0; font-size: 13px; color: #555; }
        .account-info-box strong { color: #000; }

        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .content { margin-left: 0; } }
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
            <h1>My Payments</h1>

            <div class="section">
                <div class="section-title">Make Payments</div>

                @php
                    $student = auth()->user();

                    // ✅ FIXED: Removed 'payments' from with() to stop the SQL error
                    // We only get bookings and their room.
                    $bookings = $student->bookings()
                        ->where('status', 'Approved')
                        ->with('room') 
                        ->get();
                    
                    // ✅ FETCH PAYMENTS SEPARATELY (Assuming Payment Model exists)
                    // If $payments is not passed from controller, we fetch it here to avoid errors
                    $payments = $payments ?? \App\Models\Payment::where('user_id', $student->id)
                        ->with('room')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp

                @forelse($bookings as $booking)
                    @php
                        $room = $booking->room;
                        // ✅ CHECK PAYMENT STATUS MANUALLY (Without booking_id)
                        // Checks if there is a Pending or Approved payment for this user & room
                        $hasPaid = false;
                        if($room) {
                            $hasPaid = \App\Models\Payment::where('user_id', $student->id)
                                ->where('room_id', $room->id)
                                ->whereIn('status', ['Approved', 'Pending'])
                                ->where('created_at', '>=', $booking->created_at) // ✅ FIX: Only look for payments made AFTER booking
                                ->exists();
                        }
                    @endphp

                    @if($room && !$hasPaid)
                        <div class="payment-card">
                            <h3>Room {{ $room->room_number }} - {{ $room->room_floor }}</h3>
                            <div class="amount">Monthly Rent: ₱{{ number_format($room->rent_fee, 2) }}</div>

                            <form action="{{ route('payment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                {{-- We keep booking ID in form for controller reference, even if payment table doesn't use it yet --}}
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="amount" value="{{ $room->rent_fee }}">

                                <button type="button" class="pay-btn"
                                    onclick="openPaymentModal({{ $room->id }}, '{{ $room->rent_fee }}', {{ $booking->id }})">
                                    Pay Now
                                </button>
                            </form>
                        </div>
                    @endif
                @empty
                    <p>No approved bookings available for payment.</p>
                @endforelse
            </div>

            <div id="paymentModal" class="payment-modal" style="display:none;">
                <div class="modal-content">
                    <span class="close" onclick="closePaymentModal()">&times;</span>
                    <h2>Payment Method</h2>
                    <p id="roomInfo"></p>

                    <form id="paymentForm" method="POST" action="{{ route('payment.store') }}">
                        @csrf
                        <input type="hidden" name="room_id" id="modalRoomId">
                        <input type="hidden" name="booking_id" id="modalBookingId">
                        <input type="hidden" name="amount" id="modalAmount">

                        <div class="form-group">
                            <label style="display:block; text-align:left; margin-bottom:5px;">Name:</label>
                            <input type="text" name="student_name" value="{{ Auth::user()->name }}" readonly style="width:100%; padding:10px; background:#eee; border:1px solid #ddd; border-radius:5px;">
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <label style="display:block; text-align:left; margin-bottom:5px;">Email:</label>
                            <input type="email" name="student_email" value="{{ Auth::user()->email }}" readonly style="width:100%; padding:10px; background:#eee; border:1px solid #ddd; border-radius:5px;">
                        </div>

                        <div class="form-group" style="margin-top:10px;">
                            <label style="display:block; text-align:left; margin-bottom:5px;">Select Payment Method:</label>
                            <select name="payment_method" id="paymentMethodSelect" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;">
                                <option value="" disabled selected>-- Choose --</option>
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>

                        <div id="accountInfoBox" class="account-info-box">
                            <h5 id="accountTitle">Account Details</h5>
                            <p id="accountDetails"></p>
                        </div>

                        <div class="optional-policies" style="margin-top: 20px; font-size: 0.85rem; color: #555; text-align:left;">
                            <h4 style="font-size:0.9rem; color:#d32f2f;">Important Payment Policies:</h4>
                            <ul style="padding-left: 20px; margin-top: 5px;">
                                <li><strong>No Refunds:</strong> Payments made are strictly non-refundable unless approved by admin.</li>
                                <li><strong>Proof of Payment:</strong> Please take a screenshot of your transaction for GCash/Bank Transfer. You may be asked to present it.</li>
                                <li><strong>Exact Amount:</strong> Ensure you pay the exact amount displayed.</li>
                                <li><strong>Late Penalties:</strong> Late payments will incur a 1% monthly penalty fee. Please pay at least 3 days before the due date.</li>
                                <li>Payments are pending until Admin approval.</li>
                            </ul>
                        </div>

                        <button type="submit" class="pay-btn submit-btn" style="margin-top: 20px;">Confirm Payment</button>
                    </form>
                </div>
            </div>

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
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ $payment->user->name ?? 'Unknown' }}</td>
                                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->room->room_number ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</td>
                                    <td>
                                        @if ($payment->status === 'Pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif ($payment->status === 'Approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @elseif ($payment->status === 'Rejected')
                                            <span class="status-badge status-rejected">Rejected</span>
                                        @else
                                            <span class="status-badge">{{ $payment->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->notes ?? '-' }}</td>
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
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Payment Modal Functions
        function openPaymentModal(roomId, rentFee, bookingId) {
            const modal = document.getElementById('paymentModal');
            const roomInfo = document.getElementById('roomInfo');
            const modalRoomId = document.getElementById('modalRoomId');
            const modalBookingId = document.getElementById('modalBookingId');
            const modalAmount = document.getElementById('modalAmount');
            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            const accountInfoBox = document.getElementById('accountInfoBox');

            modal.style.display = 'flex';
            roomInfo.textContent = `Room ID: ${roomId} - Amount: ₱${parseFloat(rentFee).toFixed(2)}`;
            modalRoomId.value = roomId;
            modalBookingId.value = bookingId;
            modalAmount.value = rentFee;
            
            // Reset fields
            paymentMethodSelect.selectedIndex = 0;
            accountInfoBox.style.display = 'none';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target === modal) {
                closePaymentModal();
            }
        });

        // ✅ HANDLE PAYMENT METHOD CHANGE
        document.getElementById('paymentMethodSelect').addEventListener('change', function() {
            const method = this.value;
            const infoBox = document.getElementById('accountInfoBox');
            const title = document.getElementById('accountTitle');
            const details = document.getElementById('accountDetails');

            infoBox.style.display = 'block';

            if (method === 'gcash') {
                title.textContent = 'GCash Account';
                details.innerHTML = '<strong>Name:</strong> Cora P. Trinidad <br><strong>Number:</strong> 0912-345-6789';
            } else if (method === 'bank_transfer') {
                title.textContent = 'Bank Account (BDO)';
                details.innerHTML = '<strong>Name:</strong> Patani Trinidad<br><strong>Account No:</strong> 123-456-7890<br><strong>Branch:</strong> Urdaneta City';
            } else if (method === 'credit_card') {
                title.textContent = 'Credit Card';
                details.innerHTML = 'Please proceed. You may need to present your card at the office for verification.';
            } else {
                // Cash
                title.textContent = 'Cash Payment';
                details.innerHTML = 'Please pay directly at the administration office.';
            }
        });

        // AJAX Payment Submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('.submit-btn');
            btn.disabled = true;
            btn.textContent = 'Processing...';

            fetch('{{ route("payment.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Payment submitted successfully!');
                    closePaymentModal();
                    location.reload(); 
                } else {
                    alert('Payment failed: ' + (data.message || 'Unknown error'));
                    btn.disabled = false;
                    btn.textContent = 'Confirm Payment';
                }
            })
            .catch(err => {
                console.error('AJAX error:', err);
                alert('Payment failed due to server error.');
                btn.disabled = false;
                btn.textContent = 'Confirm Payment';
            });
        });
    </script>
</body>
</html>