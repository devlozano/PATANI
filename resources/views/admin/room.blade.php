<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms - Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
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

        .section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.section-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 25px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group label {
    font-weight: 500;
    color: #444;
    font-size: 14px;
}

.form-group select,
.form-group input,
.form-group textarea {
    border: 1.8px solid #e0e0e0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    transition: 0.2s;
    font-family: 'Poppins', sans-serif;
}

.form-group select:focus,
.form-group input:focus,
.form-group textarea:focus {
    border-color: #ff9800;
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.15);
}

textarea {
    resize: vertical;
    min-height: 80px;
}

        .form-full {
            grid-column: 1 / -1;
        }

        .file-input-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.file-button {
    background: #ff9800;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.file-button:hover {
    background: #f57c00;
}

.file-name {
    color: #777;
    font-size: 14px;
}


        .book-btn {
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

        .book-btn:hover {
            background: #0b7dda;
            transform: scale(1.02);
        }

       .room-section {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
  overflow-x: auto; /* allow horizontal scroll only when needed */
  max-width: 1000px;
  margin: 20px auto;
}

/* ===== TABLE STYLES ===== */
table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed; /* fix column layout */
  font-size: 14px;
}

thead th {
  background: #f5f5f5;
  color: #333;
  padding: 10px 8px;
  text-align: left;
  border: 1px solid #ddd;
  text-transform: uppercase;
  font-weight: 600;
  font-size: 13px;
  white-space: normal;  /* allow wrapping */
  word-wrap: break-word;
  line-height: 1.3;
}

tbody td {
  padding: 10px 8px;
  border: 1px solid #eee;
  vertical-align: top;
  white-space: normal;
  word-break: break-word;
  line-height: 1.5;
  color: #444;
}

/* ===== COLUMN WIDTHS ===== */
th:nth-child(1), td:nth-child(1) { width: 10%; }   /* ROOM NO */
th:nth-child(2), td:nth-child(2) { width: 15%; }  /* ROOM FLOOR */
th:nth-child(3), td:nth-child(3) { width: 15%; }   /* BEDSPACE */
th:nth-child(4), td:nth-child(4) { width: 18%; }  /* CURRENT OCCUPANCY */
th:nth-child(5), td:nth-child(5) { width: 15%; }  /* AVAILABLE BEDS */
th:nth-child(6), td:nth-child(6) { width: 20%; }  /* STUDENTS */
th:nth-child(7), td:nth-child(7) { width: 15%; }  /* RENT FEE */
th:nth-child(8), td:nth-child(8) { width: 16%; }   /* STATUS */
th:nth-child(9), td:nth-child(9) { width: 18%; }  /* ACTIONS */

/* ===== HOVER ===== */
tbody tr:hover {
  background: #fafafa;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  justify-content: flex-start;
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  font-size: 12.5px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  white-space: nowrap;
}

.btn-edit {
  background: #4CAF50;
  color: #fff;
}

.btn-edit:hover {
  background: #45a049;
  transform: scale(1.05);
}

.btn-delete {
  background: #FF4444;
  color: #fff;
}

.btn-delete:hover {
  background: #CC0000;
  transform: scale(1.05);
}
.modal {
    display: none;
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index: 2000;
}

.modal-content {
    background:#fff;
    padding:25px;
    border-radius:12px;
    width:90%;
    max-width:600px;
    max-height:90vh;
    overflow-y:auto;
    position:relative;
}

.modal .close {
    position:absolute;
    top:10px; right:15px;
    font-size:28px;
    cursor:pointer;
}

/* ===== RESPONSIVE FIXES ===== */
@media (max-width: 992px) {
  .room-section {
    max-width: 95%;
    padding: 15px;
  }

  table {
    font-size: 13px;
  }

  th, td {
    padding: 8px 6px;
    font-size: 12.5px;
  }

  th, td {
    line-height: 1.3;
  }

  .action-buttons {
    flex-direction: column;
    align-items: flex-start;
  }

  .btn {
    width: 100%;
    text-align: center;
  }
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

        <!-- Toggle Buttons -->
<div class="toggle-buttons" style="margin-bottom: 20px;">
    <button id="showAddRoom" class="toggle-btn active">Add New Room</button>
    <button id="showRoomList" class="toggle-btn">Room List</button>
</div>

<!-- Add/Edit Room -->
<div class="section" id="addRoomSection">
    <div class="section-title">{{ isset($room) ? 'Edit Room' : 'Add New Room' }}</div>

    <form action="{{ isset($room) ? route('admin.rooms.update', $room->id) : route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($room))
            @method('PUT')
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Room Number:</label>
                <select name="room_number" required>
                    <option value="">Select</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ (isset($room) && $room->room_number == $i) ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Room Floor:</label>
                <select name="room_floor" required>
                    <option value="">Select</option>
                    <option value="Ground Floor" {{ (isset($room) && $room->room_floor == 'Ground Floor') ? 'selected' : '' }}>Ground Floor</option>
                    <option value="First Floor" {{ (isset($room) && $room->room_floor == 'First Floor') ? 'selected' : '' }}>First Floor</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" required>
                    <option value="">Select</option>
                    <option value="Female" {{ (isset($room) && $room->gender == 'Female') ? 'selected' : '' }}>Female</option>
                    <option value="Male" {{ (isset($room) && $room->gender == 'Male') ? 'selected' : '' }}>Male</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bedspace:</label>
                <select name="bedspace" required>
                    <option value="">Select</option>
                    <option value="4" {{ (isset($room) && $room->bedspace == 4) ? 'selected' : '' }}>4</option>
                    <option value="6" {{ (isset($room) && $room->bedspace == 6) ? 'selected' : '' }}>6</option>
                    <option value="8" {{ (isset($room) && $room->bedspace == 8) ? 'selected' : '' }}>8</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="available" {{ (isset($room) && $room->status == 'available') ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ (isset($room) && $room->status == 'occupied') ? 'selected' : '' }}>Occupied</option>
                </select>
            </div>

            <div class="form-group">
                <label>Rent Fee:</label>
                <select name="rent_fee" required>
                    <option value="">Select</option>
                    <option value="1600" {{ (isset($room) && $room->rent_fee == 1600) ? 'selected' : '' }}>₱1,600.00</option>
                </select>
            </div>
        </div>

        <div class="form-group form-full">
            <label>Description:</label>
            <textarea name="description" placeholder="Room details..." required>{{ old('description', $room->description ?? '') }}</textarea>
        </div>

        <!-- Main Image -->
        <div class="form-group form-full">
            <label>Room Image:</label>
            <div class="file-input-wrapper">
                <button type="button" class="file-button" id="browseButton">Browse</button>
                <span class="file-name" id="fileName">No file selected</span>
                <input type="file" name="image" id="roomImage" accept="image/*" style="display:none;">
            </div>

            @if(isset($room) && $room->image)
                <div class="current-image" style="margin-top:12px;">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" style="width:150px; border-radius:8px;">
                </div>
            @endif
        </div>

        <!-- Inclusions -->
        <div class="form-group form-full">
            <label>Room Inclusions (separate by comma):</label>
            <input type="text" name="inclusions" placeholder="WiFi, Electric Fan, Cabinet"
                value="{{ old('inclusions', isset($room) ? implode(', ', json_decode($room->inclusions ?? '[]')) : '') }}">
        </div>

        <!-- Gallery Upload -->
        <div class="form-group form-full">
            <label>Room Gallery (You can upload multiple images):</label>
            <input type="file" name="gallery[]" accept="image/*" multiple>

            @if(isset($room) && $room->gallery)
                <div style="margin-top: 12px;">
                    <p>Current Gallery:</p>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        @foreach(json_decode($room->gallery, true) as $img)
                            <img src="{{ asset('storage/' . $img) }}" style="width:100px; border-radius:8px;">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="btn-save">{{ isset($room) ? 'Update Room' : 'Add Room' }}</button>
    </form>
</div>

<!-- Room List -->
<div class="room-section" id="roomListSection" style="display:none;">
    <h2 class="section-title">Room List</h2>
    <table>
        <thead>
            <tr>
                <th>ROOM NO.</th>
                <th>ROOM FLOOR</th>
                <th>BEDSPACE</th>
                <th>OCCUPANCY</th>
                <th>AVAILABLE</th>
                <th>STUDENTS</th>
                <th>RENT FEE</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
@php
    // Count only approved bookings for this room
    $occupancy = $room->bookings()
                      ->where('status', 'approved')
                      ->count();

    $bedspace = $room->bedspace ?? 1;
    $availableBeds = max($bedspace - $occupancy, 0);
    $occupancyPercent = ($occupancy / $bedspace) * 100;

    if ($occupancyPercent == 0) {
        $rowClass = 'available-room';
    } elseif ($occupancyPercent < 100) {
        $rowClass = 'partial-room';
    } else {
        $rowClass = 'full-room';
    }
@endphp

                <tr class="{{ $rowClass }}">
                    <td>{{ $room->room_number }}
                    </td>
                    <td>{{ $room->room_floor }}</td>
                    <td>{{ $room->bedspace }}</td>
                    <td>{{ $occupancy }}</td>
                    <td>{{ $availableBeds }}</td>
                    <td>
    @php
        // Get approved bookings for this room
        $students = $room->bookings()
                         ->where('status', 'approved')
                         ->with('user')
                         ->get();
    @endphp

    @if($students->count() > 0)
        <ul style="padding-left: 15px; margin:0;">
            @foreach($students as $booking)
                <li>{{ $booking->user->name ?? 'N/A' }}</li>
            @endforeach
        </ul>
    @else
        -
    @endif
</td>

                    <td>₱{{ number_format($room->rent_fee, 2) }}</td>
                    <td>{{ ucfirst($room->status) }}</td>
<!-- In the Room List Table -->
<td>
    <div class="action-buttons">
       <button class="edit-room-btn" 
        data-room='@json($room)'>
    <i class="bi bi-pencil-square"></i> Edit
</button>
        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this room?')">DELETE</button>
        </form>
    </div>
</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;">No rooms available.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- Edit Room Modal -->
<div id="editRoomModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Room</h2>
        <form id="editRoomForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="room_id" id="modalRoomId">

            <div class="form-group">
                <label>Room Number:</label>
                <select name="room_number" id="modalRoomNumber" required>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Room Floor:</label>
                <select name="room_floor" id="modalRoomFloor" required>
                    <option value="Ground Floor">Ground Floor</option>
                    <option value="First Floor">First Floor</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" id="modalRoomGender" required>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bedspace:</label>
                <select name="bedspace" id="modalRoomBedspace" required>
                    <option value="4">4</option>
                    <option value="6">6</option>
                    <option value="8">8</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" id="modalRoomStatus" required>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                </select>
            </div>

            <div class="form-group">
                <label>Rent Fee:</label>
                <select name="rent_fee" id="modalRoomRent" required>
                    <option value="1600">₱1,600.00</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" id="modalRoomDesc" required></textarea>
            </div>

            <!-- Main Image -->
            <div class="form-group">
                <label>Pick Image:</label>
                <input type="file" name="image" id="modalRoomImage">
                <div id="currentImage" style="margin-top:10px; display:flex; gap:10px;"></div>
            </div>

            <!-- Inclusions -->
            <div class="form-group">
                <label>Inclusions (comma separated):</label>
                <input type="text" name="inclusions" id="modalRoomInclusions">
            </div>

            <!-- Gallery -->
            <div class="form-group">
                <label>Gallery (multiple images):</label>
                <input type="file" name="gallery[]" id="modalRoomGallery" multiple>
                <div id="currentGallery" style="display:flex; gap:10px; margin-top:10px;"></div>
            </div>

            <button type="submit" class="btn-save">Update Room</button>
        </form>
    </div>
</div>


<style>
    .available-room {
        background-color: #d4edda; /* light green */
    }
    .partial-room {
        background-color: #fff3cd; /* light yellow */
    }
    .full-room {
        background-color: #f8d7da; /* light red/pink */
    }
    .badge {
        background-color: #6c757d;
        color: white;
        padding: 2px 6px;
        font-size: 12px;
        border-radius: 4px;
        margin-left: 8px;
    }
    table tbody tr:hover {
        opacity: 0.85;
    }
</style>


<!-- Toggle Script -->
<script>
    const addBtn = document.getElementById('showAddRoom');
    const listBtn = document.getElementById('showRoomList');
    const addSection = document.getElementById('addRoomSection');
    const listSection = document.getElementById('roomListSection');
     const editRoomModal = document.getElementById('editRoomModal');
    const closeModalBtn = editRoomModal.querySelector('.close');
    const editForm = document.getElementById('editRoomForm');
        // File browse button functionality
    const browseBtn = document.getElementById('browseButton');
    const roomImageInput = document.getElementById('roomImage');
    const fileNameSpan = document.getElementById('fileName');

    browseBtn.addEventListener('click', () => roomImageInput.click());
    roomImageInput.addEventListener('change', () => {
        fileNameSpan.textContent = roomImageInput.files.length ? roomImageInput.files[0].name : 'No file selected';
    });

    closeModalBtn.addEventListener('click', () => editRoomModal.style.display = 'none');
    window.addEventListener('click', e => { if(e.target === editRoomModal) editRoomModal.style.display = 'none'; });

    function openEditRoomModal(room) {
        editRoomModal.style.display = 'flex';
        document.getElementById('modalRoomId').value = room.id;

        // Fill selects and inputs
        document.getElementById('modalRoomNumber').value = room.room_number || '';
        document.getElementById('modalRoomFloor').value = room.room_floor || '';
        document.getElementById('modalRoomGender').value = room.gender || '';
        document.getElementById('modalRoomBedspace').value = room.bedspace || '';
        document.getElementById('modalRoomStatus').value = room.status || '';
        document.getElementById('modalRoomRent').value = room.rent_fee || '';
        document.getElementById('modalRoomDesc').value = room.description || '';
        document.getElementById('modalRoomInclusions').value = (room.inclusions || []).join(', ');

        // Current main image
        const currentImageDiv = document.getElementById('currentImage');
        currentImageDiv.innerHTML = '';
        if(room.image) {
            const img = document.createElement('img');
            img.src = `/storage/${room.image}`;
            img.style.width = '100px';
            img.style.borderRadius = '8px';
            currentImageDiv.appendChild(img);
        }

        // Current gallery images
        const currentGalleryDiv = document.getElementById('currentGallery');
        currentGalleryDiv.innerHTML = '';
        (room.gallery || []).forEach(imgPath => {
            const img = document.createElement('img');
            img.src = `/storage/${imgPath}`;
            img.style.width = '80px';
            img.style.borderRadius = '6px';
            currentGalleryDiv.appendChild(img);
        });

        // Update form action
        editForm.action = `/admin/rooms/${room.id}`;
        if(!editForm.querySelector('input[name="_method"]')) {
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            editForm.appendChild(method);
        }
    }

    // Example usage: on edit button click
    document.querySelectorAll('.edit-room-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const room = JSON.parse(btn.dataset.room);
            openEditRoomModal(room);
        });
    });

    addBtn.addEventListener('click', () => {
        addBtn.classList.add('active');
        listBtn.classList.remove('active');
        addSection.style.display = 'block';
        listSection.style.display = 'none';
    });

    listBtn.addEventListener('click', () => {
        listBtn.classList.add('active');
        addBtn.classList.remove('active');
        addSection.style.display = 'none';
        listSection.style.display = 'block';
    });
    </script>

<!-- Optional Toggle Button Styling -->
<style>
    .toggle-btn {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid #ccc;
        background: #fffff0;
        margin-right: 5px;
        border-radius: 5px;
    }
    .toggle-btn.active {
        background: #ffd966;
        font-weight: bold;
    }
</style>


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

// EDIT ROOM FUNCTION
function editRoom(el) {
    const room = JSON.parse(el.dataset.room);

    // Show Add Room Section if hidden
    document.getElementById('addRoomSection').style.display = 'block';
    document.getElementById('roomListSection').style.display = 'none';
    document.getElementById('showAddRoom').classList.add('active');
    document.getElementById('showRoomList').classList.remove('active');

    // Set form action
    const form = document.querySelector('#addRoomSection form');
    form.action = `/admin/rooms/${room.id}`;
    if (!form.querySelector('input[name="_method"]')) {
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';
        form.appendChild(method);
    }

    // Update button text
    form.querySelector('button[type="submit"]').textContent = 'Update Room';
    document.querySelector('#addRoomSection .section-title').textContent = 'Edit Room';

    // Fill inputs
    form.querySelector('[name="room_number"]').value = room.room_number || '';
    form.querySelector('[name="room_floor"]').value = room.room_floor || '';
    form.querySelector('[name="gender"]').value = room.gender || '';
    form.querySelector('[name="bedspace"]').value = room.bedspace || '';
    form.querySelector('[name="status"]').value = room.status || '';
    form.querySelector('[name="rent_fee"]').value = room.rent_fee || '';
    form.querySelector('[name="description"]').value = room.description || '';
    form.querySelector('[name="inclusions"]').value = (room.inclusions || []).join(', ');

    // Current image preview
    const currentImgDiv = form.querySelector('.current-image');
    const imgTag = currentImgDiv.querySelector('img');
    imgTag.src = room.image ? `/storage/${room.image}` : '';
}
const modal = document.getElementById('editRoomModal');
const closeBtn = modal.querySelector('.close');
const form = document.getElementById('editRoomForm');

document.querySelectorAll('.edit-room-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const room = JSON.parse(btn.dataset.room);

        form.action = `/admin/rooms/${room.id}`; // dynamically set form action
        document.getElementById('modalRoomId').value = room.id;

        // Fill selects
        const roomNumberSelect = document.getElementById('modalRoomNumber');
        roomNumberSelect.innerHTML = '';
        for(let i=1;i<=6;i++){
            roomNumberSelect.innerHTML += `<option value="${i}" ${room.room_number == i ? 'selected':''}>${i}</option>`;
        }

        document.getElementById('modalRoomFloor').value = room.room_floor;
        document.getElementById('modalRoomGender').value = room.gender;
        document.getElementById('modalRoomBedspace').value = room.bedspace;
        document.getElementById('modalRoomStatus').value = room.status;
        document.getElementById('modalRoomRent').value = room.rent_fee;
        document.getElementById('modalRoomDesc').value = room.description;
        document.getElementById('modalRoomInclusions').value = (room.inclusions || []).join(', ');

        // Current Image
        const currentImage = document.getElementById('currentImage');
        currentImage.innerHTML = room.image ? `<img src="/storage/${room.image}" style="width:100px;border-radius:8px;">` : '';

        // Current Gallery
        const currentGallery = document.getElementById('currentGallery');
        currentGallery.innerHTML = '';
        (room.gallery || []).forEach(img => {
            currentGallery.innerHTML += `<img src="/storage/${img}" style="width:80px;border-radius:6px;">`;
        });

        modal.style.display = 'flex';
    });
});

closeBtn.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', (e) => { if(e.target === modal) modal.style.display = 'none'; });
</script>
</body>
</html>