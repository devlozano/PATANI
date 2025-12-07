<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>Patani Trinidad - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        /* [EXISTING CSS REMAINS THE SAME] */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; min-height: 100vh; background: #f5f5f5; }
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
        .dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .stat-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 25px; display: flex; align-items: center; gap: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); }
        .stat-card:nth-child(1) { border-left: 5px solid #4A90E2; }
        .stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #4A90E2, #357ABD); color: white; }
        .stat-card:nth-child(2) { border-left: 5px solid #7B68EE; }
        .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #7B68EE, #6A5ACD); color: white; }
        .stat-card:nth-child(3) { border-left: 5px solid #FF9800; }
        .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #FF9800, #F57C00); color: white; }
        .stat-card:nth-child(4) { border-left: 5px solid #E74C3C; }
        .stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, #E74C3C, #C0392B); color: white; }
        .stat-icon { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 35px; flex-shrink: 0; }
        .stat-info h3 { font-size: 14px; font-weight: 600; color: #666; margin-bottom: 8px; letter-spacing: 0.5px; }
        .stat-info p { font-size: 28px; font-weight: 700; color: #1e1e1e; margin: 0; }
        .card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e0e0e0; }
        .card-header { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; font-size: 20px; font-weight: 600; }
        .card-header i { font-size: 28px; color: #ff9800; }
        .section-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); margin-bottom: 30px; }
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; font-size: 20px; font-weight: 600; }
        .section-header i { font-size: 28px; color: #ff9800; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border: 1px solid #ddd; }
        th { background: #f5f5f5; font-weight: 600; font-size: 14px; color: #333; }
        td { font-size: 15px; }
        .status-badge { padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; display: inline-block; }
        .status-approved { background: #4CAF50; color: white; }
        .status-rejected { background: #FF4444; color: white; }
        .status-checkout { background: #757575; color: white; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: #444; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-family: inherit; }
        .btn-submit { background: #ff9800; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .btn-submit:hover { background: #f57c00; }

        /* Full Page Chat CSS */
        .chat-widget-btn { position: fixed; bottom: 30px; right: 30px; width: 65px; height: 65px; background: #ff9800; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.3); cursor: pointer; z-index: 1000; transition: all 0.3s; font-size: 30px; }
        .chat-widget-btn:hover { transform: scale(1.1); background: #f57c00; }
        .full-screen-chat { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #fff; z-index: 2000; display: none; flex-direction: row; }
        .full-screen-chat.active { display: flex; animation: fadeIn 0.3s ease; }
        .chat-sidebar-list { width: 350px; border-right: 1px solid #e0e0e0; display: flex; flex-direction: column; background: white; flex-shrink: 0; }
        .chat-sidebar-header { padding: 20px; border-bottom: 1px solid #e0e0e0; background: #fffbe6; display: flex; align-items: center; justify-content: space-between; }
        .chat-sidebar-header h2 { font-size: 20px; font-weight: 600; color: #1e1e1e; margin: 0; }
        .chat-search { padding: 15px; border-bottom: 1px solid #eee; }
        .chat-search input { width: 100%; padding: 10px 15px; border-radius: 20px; border: 1px solid #ddd; background: #f9f9f9; outline: none; }
        .user-list { flex: 1; overflow-y: auto; }
        .user-item { padding: 15px 20px; border-bottom: 1px solid #f5f5f5; cursor: pointer; display: flex; align-items: center; gap: 15px; transition: background 0.2s; }
        .user-item:hover { background: #fff8e1; }
        .user-item.active { background: #ffe0b2; }
        .user-item-img { width: 45px; height: 45px; border-radius: 50%; background: #ccc; object-fit: cover; flex-shrink: 0; }
        .user-info { flex: 1; overflow: hidden; }
        .user-info h5 { font-size: 15px; margin: 0 0 4px 0; color: #333; }
        .user-info p { font-size: 13px; color: #777; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .chat-main-area { flex: 1; display: flex; flex-direction: column; background: #f4f6f8; position: relative; }
        .chat-main-header { padding: 15px 25px; background: white; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .chat-header-user { display: flex; align-items: center; gap: 15px; }
        .chat-header-user h3 { font-size: 18px; margin: 0; font-weight: 600; }
        .close-chat-btn { background: none; border: none; font-size: 24px; color: #666; cursor: pointer; padding: 5px 10px; border-radius: 5px; transition: 0.3s; }
        .close-chat-btn:hover { background: #eee; color: #d32f2f; }
        .chat-messages { flex: 1; padding: 30px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; }
        .message-bubble { max-width: 60%; padding: 12px 18px; border-radius: 12px; font-size: 15px; line-height: 1.5; position: relative; }
        .message-bubble.incoming { background: white; align-self: flex-start; border-bottom-left-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .message-bubble.outgoing { background: #ff9800; color: white; align-self: flex-end; border-bottom-right-radius: 2px; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .message-time { font-size: 11px; margin-top: 5px; opacity: 0.7; text-align: right; display: block; }
        .chat-input-area { padding: 20px; background: white; border-top: 1px solid #e0e0e0; display: flex; gap: 15px; align-items: center; }
        .chat-input-area input { flex: 1; padding: 12px 20px; border: 1px solid #ddd; border-radius: 30px; font-size: 15px; outline: none; background: #f9f9f9; }
        .send-btn { width: 50px; height: 50px; border-radius: 50%; background: #ff9800; color: white; border: none; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
        .send-btn:hover { background: #f57c00; transform: scale(1.05); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        @media (max-width: 768px) {
            .sidebar { width: 300px; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .stat-cards { grid-template-columns: 1fr; }
            .chat-sidebar-list { width: 100%; display: flex; } 
            .chat-main-area { display: none; width: 100%; position: absolute; top: 0; left: 0; height: 100%; z-index: 5; }
            .chat-main-area.mobile-active { display: flex; }
            .chat-sidebar-list.mobile-hidden { display: none; }
            .back-to-list { display: block !important; margin-right: 10px; font-size: 20px; cursor: pointer; }
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
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
            </a>
        </nav>
    </aside>

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
            <h1>Admin Dashboard</h1>

            <div class="stat-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-info">
                        <h3>TOTAL STUDENTS</h3>
                        <p>{{ \App\Models\User::where('role','!=','admin')->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-door-open"></i></div>
                    <div class="stat-info">
                        <h3>TOTAL ROOMS</h3>
                        <p>{{ \App\Models\Room::count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <h3>PENDING BOOKINGS</h3>
                        <p>{{ \App\Models\Booking::where('status', 'Pending')->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <h3>PENDING PAYMENTS</h3>
                        <p>{{ \App\Models\Payment::where('status', 'Pending')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="card" style="grid-column: 1 / -1;">
                    <div class="card-header">
                        <i class="fas fa-bullhorn"></i>
                        <span>Post Announcement</span>
                    </div>
                    <form action="{{ route('admin.post.announcement') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Announcement Title" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Enter details..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Post Update</button>
                    </form>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Recent Bookings</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>STUDENT</th>
                            <th>ROOM</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Booking::with('user','room')->latest()->take(5)->get() as $booking)
                        <tr>
                            <td>{{ $booking->user->name ?? 'Unknown' }}</td>
                            <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($booking->status) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="chat-widget-btn" onclick="openFullChat()">
        <i class="fas fa-comments"></i>
    </div>

    <div class="full-screen-chat" id="fullScreenChat">
        
        <div class="chat-sidebar-list" id="chatSidebarList">
            <div class="chat-sidebar-header">
                <h2>Inbox</h2>
                <i class="fas fa-times close-chat-btn" onclick="closeFullChat()" style="font-size: 20px;"></i> 
            </div>
            <div class="chat-search">
                <input type="text" placeholder="Search tenant..." id="userSearch" onkeyup="filterUsers()">
            </div>
            <div class="user-list" id="userList">
                @foreach(\App\Models\User::where('role', '!=', 'admin')->get() as $student)
                    <div class="user-item" onclick="loadChat({{ $student->id }}, '{{ $student->name }}')">
                        @if($student->avatar)
                            <img src="{{ asset('storage/avatars/' . $student->avatar) }}" class="user-item-img" alt="">
                        @else
                            <div class="user-item-img" style="background: #ccc; display:flex; align-items:center; justify-content:center; color:white; font-size:12px;">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="user-info">
                            <h5>{{ $student->name }}</h5>
                            <p>Click to start chat</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="chat-main-area" id="chatMainArea">
            <div class="chat-main-header">
                <div class="chat-header-user">
                    <i class="fas fa-arrow-left back-to-list" style="display:none;" onclick="showMobileList()"></i>
                    <div class="user-item-img" style="background: #FF8D01; width:40px; height:40px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; margin-right:10px;">
                        <span id="chatAvatarInitials">--</span>
                    </div>
                    <div>
                        <h3 id="chatUserName">Select a User</h3>
                        <span id="chatUserStatus">...</span>
                    </div>
                </div>
                <button class="close-chat-btn" onclick="closeFullChat()" title="Close Chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="chat-messages" id="chatMessages">
                <div style="text-align:center; padding-top:50px; color:#777;">
                    <i class="fas fa-comments" style="font-size:50px; margin-bottom:10px; display:block;"></i>
                    Select a student to view conversation
                </div>
            </div>

            <div class="chat-input-area">
                <input type="text" id="adminChatInput" placeholder="Type a message...">
                <button class="send-btn" onclick="sendAdminMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const menuToggle = document.getElementById('menuToggle');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Sidebar Toggle
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

        // --- FULL SCREEN CHAT LOGIC ---
        const fullScreenChat = document.getElementById('fullScreenChat');
        const chatSidebarList = document.getElementById('chatSidebarList');
        const chatMainArea = document.getElementById('chatMainArea');
        let currentChatUserId = null;
        let pollingInterval = null;

        function openFullChat() {
            fullScreenChat.classList.add('active');
            document.body.style.overflow = 'hidden'; 
        }

        function closeFullChat() {
            fullScreenChat.classList.remove('active');
            document.body.style.overflow = 'auto'; 
            if(pollingInterval) clearInterval(pollingInterval); // Stop polling when closed
        }

        // 1. Load User Chat
        function loadChat(userId, userName) {
            currentChatUserId = userId;
            
            // Update Header
            document.getElementById('chatUserName').innerText = userName;
            document.getElementById('chatUserStatus').innerText = 'Viewing History';
            document.getElementById('chatAvatarInitials').innerText = userName.charAt(0).toUpperCase();

            // Highlight List Item
            const items = document.querySelectorAll('.user-item');
            items.forEach(item => item.classList.remove('active'));
            event.currentTarget.classList.add('active');

            // Mobile view toggle
            if (window.innerWidth <= 768) {
                chatSidebarList.classList.add('mobile-hidden');
                chatMainArea.classList.add('mobile-active');
            }

            fetchMessages(); // Fetch immediately
            
            // Restart Polling
            if(pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(fetchMessages, 3000);
        }

        function showMobileList() {
            chatSidebarList.classList.remove('mobile-hidden');
            chatMainArea.classList.remove('mobile-active');
            if(pollingInterval) clearInterval(pollingInterval);
        }

        // 2. Fetch Messages
        function fetchMessages() {
            if(!currentChatUserId) return;

            fetch(`/chat/messages/${currentChatUserId}`)
            .then(response => response.json())
            .then(data => {
                const chatContainer = document.getElementById('chatMessages');
                chatContainer.innerHTML = ''; 

                if(data.length === 0) {
                     chatContainer.innerHTML = '<div style="text-align:center; padding-top:20px; color:#999;">No messages yet. Start conversation.</div>';
                }

                data.forEach(msg => {
                    const type = msg.sender_id == {{ Auth::id() }} ? 'outgoing' : 'incoming';
                    const div = document.createElement('div');
                    div.className = `message-bubble ${type}`;
                    div.innerHTML = `${msg.message}`;
                    chatContainer.appendChild(div);
                });
                chatContainer.scrollTop = chatContainer.scrollHeight;
            });
        }

        // 3. Send Message
        function sendAdminMessage() {
            const input = document.getElementById('adminChatInput');
            const message = input.value;
            if(!message.trim() || !currentChatUserId) return;

            // Optimistic Update
            const chatContainer = document.getElementById('chatMessages');
            const div = document.createElement('div');
            div.className = `message-bubble outgoing`;
            div.innerHTML = `${message}`;
            chatContainer.appendChild(div);
            chatContainer.scrollTop = chatContainer.scrollHeight;
            input.value = '';

            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    receiver_id: currentChatUserId,
                    message: message
                })
            })
            .then(() => console.log('Sent'));
        }

        // Enter key support
        document.getElementById('adminChatInput').addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendAdminMessage();
            }
        });

        // Search Filter
        function filterUsers() {
            const input = document.getElementById('userSearch');
            const filter = input.value.toUpperCase();
            const list = document.getElementById('userList');
            const items = list.getElementsByClassName('user-item');

            for (let i = 0; i < items.length; i++) {
                const h5 = items[i].getElementsByTagName("h5")[0];
                const txtValue = h5.textContent || h5.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
</body>
</html>