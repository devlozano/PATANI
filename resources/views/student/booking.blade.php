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
        /* --- ORIGINAL CSS STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; min-height: 100vh; background: #f5f5f5; }
        .sidebar { width: 300px; background: linear-gradient(to bottom, #FFD36E, #FF9800); color: #1e1e1e; display: flex; flex-direction: column; align-items: center; padding: 30px 20px; position: fixed; height: 100vh; overflow-y: auto; z-index: 100; transition: transform 0.3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-header { font-family: "Molle", cursive; font-size: 1.8rem; margin-bottom: 40px; color: #1e1e1e; text-align: center; }
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 40px; }
        .avatar { display: flex; flex-direction: column; align-items: center; }
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
        h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }
        .section { background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }
        .section-title { font-size: 22px; font-weight: 600; margin-bottom: 25px; }
        .rooms-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .room-card { border: 2px solid #e0e0e0; border-radius: 12px; padding: 0; overflow: hidden; }
        .room-image { width: 100%; height: 180px; object-fit: cover; background: linear-gradient(135deg, #FFD36E 0%, #FFA726 100%); display: flex; align-items: center; justify-content: center; font-size: 80px; }
        .room-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 0; }
        .room-details { padding: 20px; }
        .room-name { font-size: 16px; font-weight: 600; margin-bottom: 5px; }
        .room-price { font-size: 18px; font-weight: 700; color: #ff8800; margin-bottom: 10px; }
        .room-desc { font-size: 13px; color: #666; margin-bottom: 15px; line-height: 1.4; }
        .bedspace-status small { font-size: 13px; display: flex; justify-content: space-between; }
        .bedspace-status div { background:#e9ecef; border-radius:6px; overflow:hidden; height:8px; margin-top:4px; }
        .amenities { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px; }
        .amenity-tag { background: #fff8e1; border: 1px solid #f8c70b; border-radius: 15px; padding: 5px 12px; font-size: 11px; display: flex; align-items: center; gap: 5px; }
        .status-cancelled { background: #FF8800; color: white; }
        .status-rejected { background: #f44336; color: white; }
        .status-pending { background: #ff9800; color: white; }
        .status-approved { background: #4caf50; color: white; }
        
        .book-btn { width: 100%; background-color: #ff9800; border: none; color: white; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 14px; }
        .book-btn:hover { background-color: #f57c00; }
        .book-btn.unavailable { background-color: #e0e0e0; color: #999; cursor: not-allowed; }
        
        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1500; left: 0; top: 0; width: 100%; height: 100%; background: rgba(15, 15, 15, 0.65); backdrop-filter: blur(4px); justify-content: center; align-items: center; padding: 10px; }
        
        /* Updated modal-content max-width to accommodate image better */
        .modal-content { background: #fff; border-radius: 14px; padding: 25px 30px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 8px 24px rgba(0,0,0,0.25); animation: slideUp 0.3s ease; display: flex; flex-direction: column; gap: 10px; }
        
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-content .close { position: absolute; top: 12px; right: 16px; font-size: 22px; color: #666; cursor: pointer; transition: 0.2s ease; }
        .modal-content .close:hover { color: #ff3b30; transform: rotate(90deg); }
        .reserve-btn { background: linear-gradient(135deg, #ff8c00, #ff6a00); color: #fff; border: none; padding: 8px 35px; font-size: 1rem; font-weight: 600; border-radius: 10px; cursor: pointer; box-shadow: 0 3px 12px rgba(255, 140, 0, 0.35); transition: all 0.3s ease; }
        .reserve-btn:disabled { background: #ccc; cursor: not-allowed; box-shadow: none; }
        
        /* Policy Lists */
        .policy-list ul { margin-left: 20px; margin-bottom: 15px; }
        .policy-list li { font-size: 0.9rem; color: #444; margin-bottom: 6px; line-height: 1.5; }
        .policy-list h3 { font-size: 1.1rem; color: #1e1e1e; margin-top: 10px; margin-bottom: 8px; border-bottom: 2px solid #FF9800; display: inline-block; }

        /* ===== INTERACTIVE BED LAYOUT STYLES ===== */
        .bed-selector-container {
            position: relative;
            width: 100%;
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #eee;
            min-height: 200px; /* Added min-height so it doesn't collapse while loading */
            background: #f9f9f9; /* Placeholder color */
        }

        .bed-layout-img {
            width: 100%;
            display: block;
        }

        .bed-marker {
            position: absolute;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.4);
            transition: transform 0.2s, background-color 0.2s;
            border: 2px solid white;
            z-index: 10;
        }

        .bed-marker:hover { transform: scale(1.1); }

        /* Status Colors */
        .bed-marker.available { background-color: #28a745; color: white; }
        .bed-marker.occupied { background-color: #dc3545; color: white; cursor: not-allowed; opacity: 0.8; }
        .bed-marker.selected { background-color: #ff9800; color: white; transform: scale(1.3); border-color: #fff; box-shadow: 0 0 15px rgba(255, 152, 0, 0.6); z-index: 15; }

/* ===== UPDATED COORDINATES FOR 8 BEDS (4 BUNK BEDS) ===== */
        /* LEFT WALL FRONT BUNK */
        .bed-1 { top: 70%; left: 14%; }  /* Bottom */
        .bed-2 { top: 38%; left: 14%; }  /* Top */
        /* LEFT WALL BACK BUNK */
        .bed-3 { top: 61%; left: 34%; } /* Bottom */
        .bed-4 { top: 38%; left: 34%; } /* Top */
        /* RIGHT WALL BACK BUNK */
        .bed-5 { top: 62%; left: 64%; } /* Bottom */
        .bed-6 { top: 38%; left: 64%; } /* Top */
        /* RIGHT WALL FRONT BUNK */
        .bed-7 { top: 64%; left: 86%; } /* Bottom */
        .bed-8 { top: 38%; left: 86%; } /* Top */


        .selection-info {
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
            font-weight: 500;
            height: 20px;
            color: #ff8800;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; padding: 15px 20px; }
            .rooms-grid { grid-template-columns: 1fr; }
            .bed-marker { width: 24px; height: 24px; font-size: 10px; }
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

            @if($hasActiveBooking)
                <div style="background-color:#ffe6e6; color:#b30000; padding:10px; border-radius:6px; margin-bottom:12px;">
                    ⚠️ You already have an approved booking.
                </div>
            @endif

            <div class="rooms-grid">
                @foreach($rooms as $room)
                    @php
                        $approvedBookings = $room->bookings()->where('status', 'approved')->count();
                        $availableBeds = max($room->bedspace - $approvedBookings, 0);
                        $isFull = $availableBeds <= 0;
                        $canBook = !$hasActiveBooking && !$isFull && $room->status === 'available';
                        $inclusions = is_array($room->inclusions) ? $room->inclusions : json_decode($room->inclusions ?? '[]', true);
                        $galleryArray = json_decode($room->gallery ?? '[]', true);
                        $gallery = collect($galleryArray)->filter(fn($g) => $g)->map(fn($g) => asset('storage/' . $g))->values()->all();
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
                            <div class="room-name">
                                Room {{ $room->room_number }} - {{ $room->room_floor }} ({{ $room->gender }})
                            </div>
                            <div class="room-price">₱{{ number_format($room->rent_fee, 2) }}/Month</div>
                            <div class="room-desc">{{ Str::limit($room->description, 60) }}</div>

                            @if(!empty($inclusions))
                                <div class="amenities">
                                    @foreach(array_slice($inclusions, 0, 3) as $inc)
                                        <div class="amenity-tag"> {{ $inc }}</div>
                                    @endforeach
                                    @if(count($inclusions) > 3) <span style="font-size:11px; color:#666;">+more</span> @endif
                                </div>
                            @endif

                            <div class="bedspace-status">
                                <small>
                                    🛏️ {{ $room->bedspace }} beds — 
                                    <span style="color:{{ $isFull ? '#b30000' : '#007b00' }}">
                                        {{ $availableBeds }} available
                                    </span>
                                </small>
                                <div>
                                    <div style="width: {{ ($approvedBookings / $room->bedspace) * 100 }}%;
                                        background: {{ $isFull ? '#dc3545' : (($approvedBookings / $room->bedspace) >= 0.5 ? '#ffc107' : '#28a745') }};
                                        height: 100%; transition: width 0.4s ease;">
                                    </div>
                                </div>
                            </div>

                            {{-- Book Button --}}
                            <button type="button"
                                class="book-btn {{ $canBook ? 'open-modal' : 'unavailable' }}"
                                {{ $canBook ? '' : 'disabled' }}
                                data-room-id="{{ $room->id }}"
                                data-room-title="Room {{ $room->room_number }}"
                                data-room-price="₱{{ number_format($room->rent_fee, 2) }}/Month"
                                data-room-desc="{{ $room->description }}"
                                data-room-inclusions='@json($inclusions)'
                                data-occupied-count="{{ $approvedBookings }}"
                                data-total-beds="{{ $room->bedspace }}"
                                {{-- ✅ ADDED GENDER DATA HERE --}}
                                data-room-gender="{{ $room->gender }}">
                                {{ $canBook ? 'SELECT BED' : ($isFull ? 'Full' : 'Unavailable') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- POLICY MODAL --}}
        <div id="policyModal" class="modal" style="display:none;">
            <div class="modal-content policy-list">
                <span class="close" onclick="closePolicyModal()">&times;</span>
                <h2 style="text-align:center; margin-bottom:15px;">Boarding House Policies</h2>

                <h3>General Conduct</h3>
                <ul>
                    <li>Respect and maintain courteous behavior toward other residents and staff.</li>
                    <li>Keep your room and common areas clean; dispose of trash properly.</li>
                    <li>Report any damages to your room or property immediately to management.</li>
                    <li>Guests are allowed only in designated areas; overnight stays require prior approval.</li>
                    <li>Smoking, alcohol, and illegal substances are strictly prohibited inside the premises.</li>
                    <li>Quiet hours are from 10:00 PM to 6:00 AM to avoid disturbances.</li>
                    <li>No gambling, illegal activities, or tampering with safety equipment.</li>
                    <li>Lock doors and windows when leaving; keep your belongings secured.</li>
                </ul>

                <h3>Payment Policies</h3>
                <ul>
                    <li>No advance payment is required before move-in.</li>
                    <li>Rent must be paid <strong>3 days before your due date</strong> every month.</li>
                    <li>If payment is late, a <strong>1% penalty</strong> will be added to the monthly rent.</li>
                    <li>Example Penalty:
                        <ul style="margin-top:5px; margin-left:10px; list-style-type:circle;">
                            <li>Room (₱1600 + 1% = ₱1616)</li>
                        </ul>
                    </li>
                    <li>Payments are non-refundable unless approved by management.</li>
                </ul>

                <h3>Violations & Penalties</h3>
                <ul>
                    <li>Repeated violations may result in warnings, fines, or eviction.</li>
                    <li>Any damage to property must be paid by the responsible resident.</li>
                </ul>

                <div style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                    <input type="checkbox" id="acceptPolicies">
                    <label for="acceptPolicies" style="font-weight:600;">I have read and agree to the boarding house policies.</label>
                </div>

                <button id="acceptPoliciesBtn" class="reserve-btn" style="margin-top:15px; width:100%;" disabled>
                    Proceed to Room Selection
                </button>
            </div>
        </div>

        {{-- ROOM SELECTION MODAL --}}
        <div id="roomModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Room Details</h2>
                <p id="modalPrice" style="color:#ff8800; font-weight:700;"></p>

                <h4 style="margin-top:10px;">Select your Bed:</h4>
                <div class="bed-selector-container">
                    {{-- ✅ UPDATED IMAGE TAG: Removed hardcoded src, added ID --}}
                    <img src="" alt="Room Layout" class="bed-layout-img" id="modalRoomImage">
                    
                    <div id="bedMarkersContainer"></div>
                </div>
                <div class="selection-info" id="selectionInfo">Click a green circle to select your bed</div>

                <div class="modal-actions">
                    <form id="modalBookingForm" method="POST" action="{{ route('student.booking.store') }}">
                        @csrf
                        <input type="hidden" name="room_id" id="modalRoomId">
                        <input type="hidden" name="bed_number" id="modalBedNumber">
                        
                        <button type="submit" class="reserve-btn" id="confirmBookingBtn" disabled>
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- My Bookings --}}
        <div class="section">
            <div class="section-title"><i class="bi bi-calendar-check"></i> My Bookings</div>
            @forelse($bookings as $booking)
                <div class="my-booking-card">
                    <div class="booking-info">
                        <h3>{{ $booking->room->name ?? 'Room' }} - Bed {{ $booking->bed_number ?? 'Any' }}</h3>
                        <div class="booking-date">Booked: {{ $booking->created_at->format('M d, Y') }}</div>
                        <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                </div>
            @empty
                <p>No bookings found.</p>
            @endforelse
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Elements
            const roomModal = document.getElementById('roomModal');
            const policyModal = document.getElementById('policyModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalPrice = document.getElementById('modalPrice');
            const modalRoomId = document.getElementById('modalRoomId');
            const modalBedNumber = document.getElementById('modalBedNumber');
            const bedMarkersContainer = document.getElementById('bedMarkersContainer');
            const selectionInfo = document.getElementById('selectionInfo');
            const confirmBookingBtn = document.getElementById('confirmBookingBtn');
            const acceptPoliciesBtn = document.getElementById('acceptPoliciesBtn');
            const acceptPoliciesCheckbox = document.getElementById('acceptPolicies');
            // ✅ NEW ELEMENT:
            const modalRoomImage = document.getElementById('modalRoomImage');
            
            let pendingRoomData = null;

            // 1. CLICK "SELECT BED" -> OPEN POLICY FIRST
            document.querySelectorAll('.open-modal').forEach(btn => {
                btn.addEventListener('click', () => {
                    pendingRoomData = {
                        id: btn.dataset.roomId,
                        title: btn.dataset.roomTitle,
                        price: btn.dataset.roomPrice,
                        occupied: parseInt(btn.dataset.occupiedCount),
                        total: parseInt(btn.dataset.totalBeds),
                        // ✅ GET GENDER DATA HERE
                        gender: btn.dataset.roomGender 
                    };
                    openPolicyModal();
                });
            });

            function openPolicyModal() {
                acceptPoliciesCheckbox.checked = false;
                acceptPoliciesBtn.disabled = true;
                policyModal.style.display = 'flex';
            }

            acceptPoliciesCheckbox.addEventListener('change', () => {
                acceptPoliciesBtn.disabled = !acceptPoliciesCheckbox.checked;
            });

            acceptPoliciesBtn.addEventListener('click', () => {
                policyModal.style.display = 'none';
                if(pendingRoomData) openRoomModal(pendingRoomData);
            });

            // 2. OPEN ROOM MODAL AND GENERATE BEDS
            function openRoomModal(data) {
                modalTitle.textContent = data.title;
                modalPrice.textContent = data.price;
                modalRoomId.value = data.id;
                modalBedNumber.value = ""; 
                confirmBookingBtn.disabled = true;
                confirmBookingBtn.textContent = "Select a Bed";
                selectionInfo.textContent = "Click a green circle to select your bed";
                selectionInfo.style.color = "#ff8800";

                // ✅ DYNAMIC IMAGE LOGIC
                // Make sure you have 'male-room.jpg' and 'female-room.jpg' in your public/images folder
                if (data.gender && data.gender.toLowerCase() === 'male') {
                    modalRoomImage.src = "/images/fem.png";
                } else {
                    // Default to female or mixed image
                    modalRoomImage.src = "/images/room.png";
                }

                // Clear markers
                bedMarkersContainer.innerHTML = '';

                // Generate Markers (8 beds)
                for (let i = 1; i <= 8; i++) {
                    const bedBtn = document.createElement('div');
                    bedBtn.classList.add('bed-marker', 'bed-' + i);
                    bedBtn.textContent = i;

                    // Simple logic: If Bed Number <= Occupied Count, it is taken.
                    if (i <= data.occupied) {
                        bedBtn.classList.add('occupied');
                        bedBtn.title = "Occupied";
                    } else {
                        bedBtn.classList.add('available');
                        bedBtn.title = "Available";
                        bedBtn.addEventListener('click', () => selectBed(i, bedBtn));
                    }

                    bedMarkersContainer.appendChild(bedBtn);
                }

                roomModal.style.display = 'flex';
            }

            // 3. HANDLE BED SELECTION
            function selectBed(bedNum, btnElement) {
                document.querySelectorAll('.bed-marker').forEach(b => b.classList.remove('selected'));
                btnElement.classList.add('selected');

                modalBedNumber.value = bedNum;
                confirmBookingBtn.disabled = false;
                confirmBookingBtn.textContent = "Book Bed " + bedNum;
                selectionInfo.textContent = "You selected Bed " + bedNum;
                selectionInfo.style.color = "#28a745";
            }

            // Close Modals
            document.querySelectorAll('.close').forEach(c => {
                c.addEventListener('click', () => {
                    roomModal.style.display = 'none';
                    policyModal.style.display = 'none';
                });
            });

            // Sidebar Toggle
            window.toggleSidebar = function() {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('content').classList.toggle('expanded');
            };
        });
    </script>
</body>
</html>