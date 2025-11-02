<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .content {
            flex: 1;
            margin-left: 300px;
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

        .main-content {
            padding: 40px;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .form-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

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

        .form-group select,
        .form-group input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            font-family: "Poppins", sans-serif;
        }

        .form-group textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            font-family: "Poppins", sans-serif;
            resize: vertical;
            min-height: 100px;
        }

        .form-full {
            grid-column: 1 / -1;
        }

        .file-input-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .file-button {
            background: #757575;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .file-name {
            font-size: 14px;
            color: #666;
        }

        .submit-btn {
            background: #2196F3;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #0b7dda;
            transform: scale(1.02);
        }

        .room-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        td {
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
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

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
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

            .form-section,
            .room-section {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 20px;
            }

            .room-section {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
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

            .form-section,
            .room-section {
                padding: 15px;
            }

            .section-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Patani Trinidad</div>

        <div class="profile">
            <img src="/images/Screenshot 2025-10-28 033031.png" alt="User Photo">
            <h2>Cora P. Trinidad</h2>
            <p>0912-345-6789</p>
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
            <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </nav>
    </aside>

<!-- Content -->
<div class="content" id="content">
    <div class="top-bar">
        <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
        <div class="logo">Patani Trinidad</div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="button" class="logout-btn" onclick="confirmLogout()"><span>Logout</span><i class="fas fa-sign-out-alt"></i></button>
        </form>
    </div>

    <div class="main-content">
        <h1>Manage Rooms</h1>

        <!-- Add/Edit Room -->
        <div class="form-section">
            <h2 class="section-title">Add New Room</h2>
<form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-grid">
        <div class="form-group">
            <label>Room Number:</label>
            <select name="room_number" required>
                <option value="">Select</option>
                @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label>Room Floor:</label>
            <select name="room_floor" required>
                <option value="">Select</option>
                <option value="Ground Floor">Ground Floor</option>
                <option value="First Floor">First Floor</option>
            </select>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <select name="gender" required>
                <option value="">Select</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
            </select>
        </div>
        <div class="form-group">
            <label>Bedspace:</label>
            <select name="bedspace" required>
                <option value="">Select</option>
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
            </select>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
            </select>
        </div>
        <div class="form-group">
            <label>Rent Fee:</label>
            <select name="rent_fee" required>
                <option value="">Select</option>
                <option value="1500">₱1,500.00</option>
                <option value="1600">₱1,600.00</option>
            </select>
        </div>
    </div>

    <div class="form-group form-full">
        <label>Description:</label>
        <textarea name="description" placeholder="Room details..." required></textarea>
    </div>

    <div class="form-group form-full">
        <label>Pick Image:</label>
        <div class="file-input-wrapper">
            <button type="button" class="file-button" id="browseButton">Browse...</button>
            <span class="file-name" id="fileName">No file selected.</span>
            <input type="file" name="image" id="roomImage" accept="image/*" style="display:none;">
        </div>

        @if(isset($room) && $room->image)
            <div class="current-image" style="margin-top:10px;">
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" style="width:150px; border-radius:8px;">
            </div>
        @endif
    </div>

    <button type="submit" class="submit-btn">Add Room</button>
</form>
        </div>

        <!-- Room List -->
        <div class="room-section">
            <h2 class="section-title">Room List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ROOM NO.</th>
                        <th>ROOM FLOOR</th>
                        <th>RENT FEE</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->room_floor }}</td>
                            <td>₱{{ number_format($room->rent_fee, 2) }}</td>
                            <td>{{ ucfirst($room->status) }}</td>
                            <td>
                                <div class="action-buttons">

                    <a href="{{ route('admin.rooms.edit', $room->id) }}" 
                    class="btn btn-edit" 
                    style="text-decoration: none;">
                    EDIT
                    </a>

<form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this room?')">
        DELETE
    </button>
</form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;">No rooms available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Sidebar toggling
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

    // File input
    const fileButton = document.querySelector('.file-button');
    const fileName = document.querySelector('.file-name');
    const fileInput = document.querySelector('input[type="file"][name="image"]');

    fileButton.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        fileName.textContent = file ? file.name : 'No file selected.';
    });

    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            document.getElementById('logoutForm').submit();
        }
    }

    document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
        const room = JSON.parse(btn.dataset.room);
        editRoom(room);
    });
});

function editRoom(room) {
    document.querySelector('[name="room_number"]').value = room.room_number || '';
    document.querySelector('[name="room_floor"]').value = room.room_floor || '';
    document.querySelector('[name="bedspace"]').value = room.bedspace || '';
    document.querySelector('[name="status"]').value = room.status || '';
    document.querySelector('[name="rent_fee"]').value = room.rent_fee || '';
    document.querySelector('[name="description"]').value = room.description || '';

    document.querySelector('.section-title').textContent = 'Edit Room';
    document.querySelector('.submit-btn').textContent = 'Update Room';

    const form = document.querySelector('.form-section form');
    form.action = `/admin/rooms/${room.id}`;

    if (!form.querySelector('input[name="_method"]')) {
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';
        form.appendChild(method);
    }
}
</script>
</body>
</html>