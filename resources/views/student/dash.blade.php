<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>Student Dashboard | Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        /* [EXISTING CSS REMAINS THE SAME] */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; min-height: 100vh; background: #f5f5f5; }
        .sidebar { width: 300px; background: linear-gradient(to bottom, #FFD36E, #FF9800); color: #1e1e1e; display: flex; flex-direction: column; align-items: center; padding: 30px 20px; position: fixed; height: 100vh; overflow-y: auto; z-index: 100; transition: transform 0.3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-header { font-family: "Molle", cursive; font-size: 1.8rem; margin-bottom: 40px; color: #1e1e1e; text-align: center; }
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px; }
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
        .dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .avatar { display: flex; flex-direction: column; align-items: center; }
        .avatar-img { width: 75px; height: 75px; border-radius: 50%; object-fit: cover; }
        .avatar-initials { width: 50px; height: 50px; border-radius: 50%; background: #FF8D01; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; color: #fffff0; }
        .card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e0e0e0; }
        .card-header { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; font-size: 20px; font-weight: 600; }
        .card-header img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
        .card-header i { font-size: 28px; color: #ff9800; }
        .info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .info-item label { font-size: 14px; color: #666; display: block; margin-bottom: 5px; }
        .info-item p { font-size: 16px; font-weight: 500; color: #1e1e1e; }
        .info-full { margin-bottom: 15px; }
        .info-full label { font-size: 14px; color: #666; display: block; margin-bottom: 5px; }
        .info-full p { font-size: 16px; font-weight: 500; color: #1e1e1e; }
        .room-empty { text-align: center; padding: 30px 20px; }
        .room-empty i { font-size: 80px; color: #999; margin-bottom: 20px; }
        .room-empty p { font-size: 16px; color: #666; margin-bottom: 25px; }
        .book-btn { background-color: #ff9800; border: none; color: white; padding: 12px 35px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 15px; }
        .book-btn:hover { background-color: #f57c00; transform: scale(1.05); }
        .payments-section { width: 100%; padding: 0 40px; }
        .payments-card { margin-top: 20px; width: 100%; border-radius: 12px; overflow: hidden; background: #fff; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }
        .payments-card .card-header { background: linear-gradient(to right, #FFD36E, #FF9800); color: #1e1e1e; font-weight: 600; font-size: 1.1rem; padding: 18px 25px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f0f0f0; }
        .payments-card .card-header i { font-size: 26px; color: #fff; background: #ff9800; padding: 8px; border-radius: 8px; }
        .payments-card table { width: 100%; border-collapse: collapse; font-size: 15px; }
        .payments-card th, .payments-card td { padding: 14px 20px; vertical-align: middle; border-bottom: 1px solid #f2f2f2; }
        .payments-card th { font-weight: 600; color: #444; text-transform: uppercase; font-size: 0.85rem; background: #fff8e1; border-bottom: 2px solid #ffe0b2; }
        .payments-card td { color: #333; }
        .payments-card tr:hover { background-color: #fffbea; transition: background-color 0.2s ease; }
        .payments-card .badge { font-size: 0.85rem; padding: 6px 10px; border-radius: 6px; }
        .payments-card .badge.bg-success { background-color: #4caf50 !important; }
        .payments-card .badge.bg-warning { background-color: #ffb300 !important; color: #fff !important; }
        .payments-card .badge.bg-secondary { background-color: #9e9e9e !important; }
        .payments-empty { padding: 50px 0; text-align: center; color: #666; background-color: #fffef9; border-top: 1px solid #f1f1f1; border-radius: 0 0 12px 12px; }
        .payments-empty i { font-size: 60px; color: #ffb300; margin-bottom: 12px; }

        /* Announcement & Chat CSS */
        .announcement-list { list-style: none; }
        .announcement-item { border-left: 4px solid #ff9800; background: #fff8e1; padding: 15px; margin-bottom: 15px; border-radius: 4px; }
        .announcement-item h4 { font-size: 16px; margin-bottom: 5px; color: #d35400; }
        .announcement-item p { font-size: 14px; color: #555; margin-bottom: 5px; }
        .announcement-date { font-size: 12px; color: #888; font-style: italic; display: block; text-align: right; }

        .chat-widget-btn { position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #ff9800; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2); cursor: pointer; z-index: 1000; transition: all 0.3s ease; }
        .chat-widget-btn:hover { transform: scale(1.1); background: #f57c00; }
        .chat-widget-btn i { font-size: 28px; }
        .chat-box { position: fixed; bottom: 100px; right: 30px; width: 350px; height: 450px; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); z-index: 1001; display: none; flex-direction: column; overflow: hidden; border: 1px solid #eee; }
        .chat-box.active { display: flex; }
        .chat-header { background: linear-gradient(to right, #FFD36E, #FF9800); padding: 15px; color: #1e1e1e; font-weight: 600; display: flex; align-items: center; justify-content: space-between; }
        .chat-close { cursor: pointer; font-size: 18px; }
        .chat-body { flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; display: flex; flex-direction: column; }
        .message { margin-bottom: 10px; max-width: 80%; padding: 10px; border-radius: 10px; font-size: 14px; line-height: 1.4; }
        .message.admin { background: #e0e0e0; color: #333; align-self: flex-start; border-bottom-left-radius: 0; }
        .message.user { background: #ff9800; color: white; align-self: flex-end; border-bottom-right-radius: 0; }
        .chat-footer { padding: 10px; border-top: 1px solid #eee; display: flex; gap: 10px; background: white; }
        .chat-input { flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 20px; outline: none; }
        .chat-send { background: #ff9800; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;}
        .chat-send:hover { background: #e68900; }

        @media (max-width: 768px) {
            .sidebar { width: 300px; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; }
            .top-bar { padding: 15px 20px; }
            .main-content { padding: 20px; }
            .dashboard-grid { grid-template-columns: 1fr; gap: 20px; }
            .chat-box { width: 90%; right: 5%; bottom: 100px; }
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
                
                <div class="card" style="grid-column: 1 / -1;">
                    <div class="card-header">
                        <i class="bi bi-megaphone-fill"></i>
                        <span>Announcements</span>
                    </div>
                    <div class="card-body">
                        <ul class="announcement-list">
                            @if(isset($announcements) && $announcements->count() > 0)
                                @foreach($announcements as $announcement)
                                    <li class="announcement-item">
                                        <h4>{{ $announcement->title }}</h4>
                                        <p>{{ $announcement->message }}</p>
                                        <span class="announcement-date">{{ $announcement->created_at->format('M d, Y') }}</span>
                                    </li>
                                @endforeach
                            @else 
                                <li style="text-align:center; color:#777;">No announcements yet.</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-person-badge-fill"></i>
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
                        @if($bookings && $bookings->room)
                            <i class="bi {{ in_array($bookings->status, ['Approved', 'Occupied', 'Paid']) ? 'bi-door-open' : 'bi-door-closed' }}"></i>
                            <span>
                                My Room
                                @if(in_array($bookings->status, ['Approved', 'Occupied', 'Paid']))
                                    : {{ $bookings->room->room_number }}
                                @else
                                    ({{ ucfirst($bookings->status) }})
                                @endif
                            </span>
                        @else
                            <i class="bi bi-door-closed"></i>
                            <span>My Room</span>
                        @endif
                    </div>
                    @if($bookings)
                        @if(in_array($bookings->status, ['Approved', 'Occupied','Paid']))
                            <div class="room-details">
                                <p><strong>Room Number:</strong> {{ $bookings->room->room_number }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($bookings->status) }}</p>
                            </div>
                        @else
                            <div class="room-empty">
                                <i class="bi bi-door-closed"></i>
                                <p>Your room request is <strong>{{ ucfirst($bookings->status) }}</strong>. Please wait for approval.</p>
                                <a href="{{ route('student.booking') }}">
                                    <button class="book-btn" type="button">BOOK NOW</button>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="room-empty">
                            <i class="bi bi-door-closed"></i>
                            <p>You don't have a room yet.</p>
                            <a href="{{ route('student.booking') }}">
                                <button class="book-btn" type="button">BOOK NOW</button>
                            </a>
                        </div>
                    @endif
                </div>
            </div> 

            <div class="payments-full-width">
                <div class="payments-card border-0 shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between" style="background: linear-gradient(90deg, #ff9800, #ffb84d); color: white; border: none;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-credit-card me-2 fs-5"></i>
                            <span class="fw-semibold">All Payments</span>
                        </div>
                    </div>
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
                                                <td class="text-start fw-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                                                <td class="text-center">
                                                    @if($payment->status === 'paid')
                                                        <span class="badge bg-success px-3 py-2">{{ ucfirst($payment->status) }}</span>
                                                    @elseif($payment->status === 'pending')
                                                        <span class="badge bg-warning text-dark px-3 py-2">{{ ucfirst($payment->status) }}</span>
                                                    @else
                                                        <span class="badge bg-secondary px-3 py-2">{{ ucfirst($payment->status ?? 'Unknown') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end text-muted">{{ $payment->created_at->format('M d, Y') }}</td>
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
        </div>
    </div>

    <div class="chat-widget-btn" onclick="toggleChat()">
        <i class="bi bi-chat-dots-fill"></i>
    </div>

    <div class="chat-box" id="chatBox">
        <div class="chat-header">
            <span>Admin Support</span>
            <i class="bi bi-x-lg chat-close" onclick="toggleChat()"></i>
        </div>
        <div class="chat-body" id="chatBody">
            <div class="message admin">Hello {{ Auth::user()->name }}, how can I help you?</div>
        </div>
        <div class="chat-footer">
            <input type="text" class="chat-input" id="chatMessageInput" placeholder="Type a message...">
            <button class="chat-send" onclick="sendMessage()"><i class="bi bi-send-fill"></i></button>
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

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.menu-toggle');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Toggle Chat Box
        function toggleChat() {
            const chatBox = document.getElementById('chatBox');
            chatBox.classList.toggle('active');
            if(chatBox.classList.contains('active')) {
                fetchMessages(); // Load messages immediately on open
            }
        }

        // --- AJAX CHAT LOGIC ---
        const chatBody = document.getElementById('chatBody');
        const adminId = 2; // ⚠️ CHECK DATABASE: Ensure your Admin's ID is actually 1
        const userId = {{ Auth::id() }}; // Current Student ID
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // 1. Send Message
        function sendMessage() {
            const input = document.getElementById('chatMessageInput');
            const message = input.value;
            if(!message.trim()) return;

            // Optimistic UI Update (Show immediately)
            appendMessage(message, 'user');
            input.value = '';

            // Use Blade route() for correct URL generation
            fetch("{{ route('chat.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    receiver_id: adminId,
                    message: message
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Message sent successfully');
            })
            .catch(error => {
                console.error('Error sending message:', error);
                // Optional: alert('Failed to send message. Please check console.');
            });
        }

        // Allow 'Enter' key to send
        const chatInput = document.getElementById('chatMessageInput');
        if (chatInput) {
            chatInput.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    sendMessage();
                }
            });
        }

        // 2. Fetch Messages (Poll every 3 seconds)
        function fetchMessages() {
            const chatBox = document.getElementById('chatBox');
            if(!chatBox.classList.contains('active')) return;

            // Use Blade url() to handle subfolders (e.g. localhost/project/public/...)
            const url = "{{ url('/chat/messages') }}/" + adminId;

            fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch messages');
                }
                return response.json();
            })
            .then(data => {
                // Clear current messages to prevent duplicates
                chatBody.innerHTML = '<div class="message admin">Hello {{ Auth::user()->name }}, how can I help you?</div>'; 
                
                data.forEach(msg => {
                    // Check if the message sender is the current logged-in user
                    const type = msg.sender_id == userId ? 'user' : 'admin';
                    appendMessage(msg.message, type);
                });
            })
            .catch(error => console.error('Polling error:', error));
        }

        function appendMessage(text, type) {
            const div = document.createElement('div');
            div.classList.add('message', type);
            div.innerText = text;
            chatBody.appendChild(div);
            // Auto scroll to bottom
            chatBody.scrollTop = chatBody.scrollHeight; 
        }

        // Start polling
        setInterval(fetchMessages, 3000);

    </script>
</body>
</html>