@php
    $hasActiveBooking = $hasActiveBooking ?? false;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings | Patani Trinidad</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Molle:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

.avatar {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.avatar-img {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-initials {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #FF8D01;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 600;
    color: #fffff0;
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

        h1 {
            font-size: 36px;
            font-weight: 700;
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
.rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}


        .room-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
        }

.room-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: linear-gradient(135deg, #FFD36E 0%, #FFA726 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
}

.room-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0;
}

.room-details {
    padding: 20px;
}

.room-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.room-price {
    font-size: 18px;
    font-weight: 700;
    color: #ff8800;
    margin-bottom: 10px;
}

.room-desc {
    font-size: 13px;
    color: #666;
    margin-bottom: 15px;
    line-height: 1.4;
}

.bedspace-status small {
    font-size: 13px;
    display: flex;
    justify-content: space-between;
}

.bedspace-status div {
    background:#e9ecef; 
    border-radius:6px; 
    overflow:hidden; 
    height:8px; 
    margin-top:4px;
}


.amenities {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.amenity-tag {
    background: #f0f0f0;
    border-radius: 15px;
    padding: 5px 12px;
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 5px;
}

        .status-cancelled {
    background: #FF8800; /* or any color you like */
    color: white;
}
        .status-rejected {
    background: #f44336; /* or any color you like */
    color: white;
}
        .status-pending {
    background: #ff9800; /* or any color you like */
    color: white;
}
        .status-approved {  
    background: #4caf50; /* or any color you like */
    color: white;
}

       .book-btn {
    width: 100%;
    background-color: #ff9800;
    border: none;
    color: white;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
}
.book-btn:hover { background-color: #f57c00; }
.book-btn.unavailable {
    background-color: #e0e0e0;
    color: #999;
    cursor: not-allowed;
}
.book-btn.unavailable:hover { background-color: #e0e0e0; }

.modal {
    display: none;
    position: fixed;
    z-index: 1500;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 15, 15, 0.65);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    padding: 10px;
}

.modal-content {
    background: #fff;
    border-radius: 14px;
    padding: 25px 30px;
    width: 95%;
    max-width: 480px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    animation: slideUp 0.3s ease;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-content .close {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 22px;
    color: #666;
    cursor: pointer;
    transition: 0.2s ease;
}
.modal-content .close:hover {
    color: #ff3b30;
    transform: rotate(90deg);
}

.modal-content h2 { font-size: 1.25rem; font-weight: 600; color: #1f1f1f; margin-bottom: 4px; }
.modal-content p { font-size: 0.95rem; color: #444; line-height: 1.5; }
.modal-content h4 { font-size: 1rem; color: #333; margin-top: 15px; margin-bottom: 6px; }

#modalInclusions { padding-left: 20px; margin: 0; color: #555; }
#modalInclusions li { font-size: 0.9rem; margin-bottom: 4px; position: relative; }
#modalInclusions li::before { content: "✓"; color: #28a745; margin-right: 6px; }

.modal-actions { text-align: center; margin-top: 18px; }
.reserve-btn {
    background: linear-gradient(135deg, #ff8c00, #ff6a00);
    color: #fff;
    border: none;
    padding: 8px 35px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 3px 12px rgba(255, 140, 0, 0.35);
    transition: all 0.3s ease;
}

.reserve-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 16px rgba(255, 106, 0, 0.45);
}

.modal-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}
.modal-gallery img {
    width: 85px;
    height: 65px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 1.5px solid transparent;
    transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
}
.modal-gallery img:hover {
    transform: scale(1.06);
    border-color: #ff8c00;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

/* ===== IMAGE ZOOM ===== */
.img-zoom-overlay {
    display: none;
    position: fixed;
    z-index: 2000;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background: rgba(10,10,10,0.9);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
    cursor: zoom-out;
}
.img-zoom-overlay img {
    max-width: 100%;
    max-height: 95%;
    border-radius: 10px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.5);
    animation: zoomIn 0.25s ease;
}
@keyframes zoomIn {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 480px) {
    .modal-content { padding: 20px; max-width: 92%; }
    .modal-gallery img { width: 65px; height: 48px; }
    .reserve-btn { padding: 7px 25px; font-size: 0.95rem; }
}
        .my-booking-card {
            background: #fff;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking-info h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .booking-date {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            background: #4caf50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .rent-amount {
            font-size: 24px;
            font-weight: 700;
            color: #1e1e1e;
        }

        .pay-btn {
            background-color: #ff9800;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }

        .pay-btn:hover {
            background-color: #f57c00;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                padding: 15px 20px;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 24px;
            }

            .my-booking-card {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
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
    <!-- User info -->
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
            <button class="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="logo">Patani Trinidad</div>
        </div>

      <h1>Bookings</h1>

{{-- ✅ Available Rooms --}}
<div class="section">
    <div class="section-title">Available Rooms</div>

    {{-- Warning if they already have an approved booking --}}
    @if($hasActiveBooking)
        <div style="background-color:#ffe6e6; color:#b30000; padding:10px; border-radius:6px; margin-bottom:12px;">
            ⚠️ You already have an approved booking. You must be checked out by the admin before booking another room.
        </div>
    @endif

    <div class="rooms-grid">
        @foreach($rooms as $room)
            @php
                $approvedBookings = $room->bookings()->where('status', 'approved')->count();
                $availableBeds = max($room->bedspace - $approvedBookings, 0);
                $isFull = $availableBeds <= 0;
                $canBook = !$hasActiveBooking && !$isFull && $room->status === 'available';
            @endphp

            <div class="room-card">
                <div class="room-image">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}">
                    @else
                        🏢
                    @endif
                </div>

                <div class="room-details">
                    <div class="room-name">Room {{ $room->room_number }}</div>
                    <div class="room-price">₱{{ number_format($room->rent_fee, 2) }}/Month</div>
                    <div class="room-desc">{{ $room->description }}</div>

                    <div class="bedspace-status" style="margin-bottom:10px;">
                        <small>
                            🛏️ {{ $room->bedspace }} beds — 
                            <span style="color:{{ $isFull ? '#b30000' : '#007b00' }}">
                                {{ $availableBeds }} available
                            </span>
                        </small>
                        <div style="background:#e9ecef; border-radius:6px; overflow:hidden; height:8px; margin-top:4px;">
                            <div style="
                                width: {{ ($approvedBookings / $room->bedspace) * 100 }}%;
                                background: {{ $isFull ? '#dc3545' : (($approvedBookings / $room->bedspace) >= 0.5 ? '#ffc107' : '#28a745') }};
                                height: 100%;
                                transition: width 0.4s ease;">
                            </div>
                        </div>
                    </div>

                    {{-- Amenities --}}
                    <div class="amenities">
                        @foreach($room->inclusions ?? [] as $inc)
                            <div class="amenity-tag">{{ $inc }}</div>
                        @endforeach
                    </div>

                    {{-- Booking / Modal button --}}
                    <button class="{{ !$canBook ? 'book-btn unavailable' : 'book-btn open-modal' }}" 
                            {{ !$canBook ? 'disabled' : '' }}
                            data-room-id="{{ $room->id }}"
                            data-room-title="Room {{ $room->room_number }}"
                            data-room-price="₱{{ number_format($room->rent_fee, 2) }}/Month"
                            data-room-desc="{{ $room->description }}"
                            data-room-inclusions='@json($room->inclusions ?? [])'
                            data-room-images='@json($room->images ?? [])'>
                        {{ $canBook ? 'BOOK NOW' : ($isFull ? 'Full' : ($hasActiveBooking ? 'Not Allowed' : 'Unavailable')) }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- MODAL --}}
<div id="roomModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 id="modalTitle"></h2>
    <p id="modalPrice"></p>
    <p id="modalDesc"></p>

    <h4>Inclusions:</h4>
    <ul id="modalInclusions"></ul>

    <h4>Gallery</h4>
    <div id="modalGallery" class="modal-gallery"></div>

    <div class="modal-actions">
      <form id="modalBookingForm" method="POST" action="{{ route('student.booking.store') }}">
        @csrf
        <input type="hidden" name="room_id" id="modalRoomId">
        <button type="submit" class="reserve-btn">Reserve Now</button>
      </form>
    </div>
  </div>
</div>

{{-- JS --}}
<script>
const modal = document.getElementById('roomModal');
const modalTitle = document.getElementById('modalTitle');
const modalPrice = document.getElementById('modalPrice');
const modalDesc = document.getElementById('modalDesc');
const modalInclusions = document.getElementById('modalInclusions');
const modalGallery = document.getElementById('modalGallery');
const modalRoomId = document.getElementById('modalRoomId');
const closeBtn = document.querySelector('.close');

// Open modal
document.querySelectorAll('.open-modal').forEach(btn => {
    btn.addEventListener('click', () => {
        modalTitle.textContent = btn.dataset.roomTitle;
        modalPrice.textContent = btn.dataset.roomPrice;
        modalDesc.textContent = btn.dataset.roomDesc;
        modalRoomId.value = btn.dataset.roomId;

        const inclusions = JSON.parse(btn.dataset.roomInclusions || '[]');
        modalInclusions.innerHTML = '';
        inclusions.forEach(i => {
            const li = document.createElement('li');
            li.textContent = i;
            modalInclusions.appendChild(li);
        });

        const images = JSON.parse(btn.dataset.roomImages || '[]');
        modalGallery.innerHTML = '';
        images.forEach(src => {
            const img = document.createElement('img');
            img.src = src;
            img.alt = btn.dataset.roomTitle;
            img.addEventListener('click', () => openZoom(src));
            modalGallery.appendChild(img);
        });

        modal.style.display = 'flex';
    });
});

// Close modal
closeBtn.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if(e.target == modal) modal.style.display = 'none'; });

// Zoom overlay
const zoomOverlay = document.createElement('div');
zoomOverlay.classList.add('img-zoom-overlay');
const zoomImg = document.createElement('img');
zoomOverlay.appendChild(zoomImg);
document.body.appendChild(zoomOverlay);
function openZoom(src){ zoomImg.src=src; zoomOverlay.style.display='flex'; }
zoomOverlay.addEventListener('click',()=>zoomOverlay.style.display='none');
</script>


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
</body>
</html>