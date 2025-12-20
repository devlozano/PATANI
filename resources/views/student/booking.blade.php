@php
    $hasActiveBooking = $hasActiveBooking ?? false;

    // ✅ Data preparation logic
    $roomsData = $rooms->map(function($room) {
        $inclusions = is_array($room->inclusions) 
            ? $room->inclusions 
            : json_decode($room->inclusions ?? '[]', true);
            
        $galleryArray = json_decode($room->gallery ?? '[]', true);
        
        $allPhotos = [];
        if($room->image) $allPhotos[] = asset('storage/' . $room->image);
        $gallery = collect($galleryArray)->filter(fn($g) => $g)->map(fn($g) => asset('storage/' . $g))->values()->all();
        $allPhotos = array_merge($allPhotos, $gallery);
        
        $approvedBookings = $room->bookings()->where('status', 'approved')->count();
        $availableBeds = max($room->bedspace - $approvedBookings, 0);
        $isFull = $availableBeds <= 0;

        return [
            'id' => $room->id,
            'title' => "Room " . $room->room_number . " - " . $room->room_floor, 
            'price' => "₱" . number_format($room->rent_fee, 2) . "/Month",
            'desc' => $room->description,
            'inclusions' => $inclusions,
            'images' => $allPhotos,
            'gender' => $room->gender,
            'bedspace' => $room->bedspace, 
            'occupied' => $approvedBookings,
            'isFull' => $isFull,
            'availableBeds' => $availableBeds
        ];
    });
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
        /* --- CORE STYLES --- */
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
        .room-card { border: 2px solid #e0e0e0; border-radius: 12px; padding: 0; overflow: hidden; display: flex; flex-direction: column; background: #fff; }
        
        .room-image { width: 100%; height: 180px; object-fit: cover; background: linear-gradient(135deg, #FFD36E 0%, #FFA726 100%); display: flex; align-items: center; justify-content: center; font-size: 80px; position: relative; overflow: hidden; cursor: zoom-in; }
        .room-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 0; transition: opacity 0.3s ease, transform 0.3s ease; }
        .room-image:hover img { transform: scale(1.05); }

        .content-area { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        .content-area h3 { font-size: 18px; margin-bottom: 5px; color: #333; }
        .content-area .price { font-size: 18px; font-weight: 700; color: #ff8800; margin-bottom: 10px; }
        .content-area .desc { font-size: 13px; color: #666; margin-bottom: 15px; line-height: 1.4; flex-grow: 1; }

        .bedspace-status { margin-bottom: 15px; }
        .bedspace-status small { font-size: 13px; display: flex; justify-content: space-between; margin-bottom: 5px; }
        .bedspace-status div.bar { background:#e9ecef; border-radius:6px; overflow:hidden; height:8px; }
        .bedspace-status div.fill { height: 100%; transition: width 0.4s ease; }

        .amenities { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px; }
        .amenity-tag { background: #fff8e1; border: 1px solid #f8c70b; border-radius: 15px; padding: 5px 12px; font-size: 11px; display: flex; align-items: center; gap: 5px; }
        
        .gallery-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); gap: 10px; margin-top: 10px; padding: 5px 0; }
        .gallery-thumb { width: 100%; height: 70px; border-radius: 6px; object-fit: cover; cursor: pointer; border: 2px solid transparent; transition: all 0.2s; }
        .gallery-thumb:hover, .gallery-thumb.active { border-color: #ff9800; transform: scale(1.05); }

        .img-zoom-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); z-index: 9999; display: none; justify-content: center; align-items: center; cursor: zoom-out; animation: fadeIn 0.2s ease-in-out; }
        .img-zoom-overlay img { max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.5); animation: zoomIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes zoomIn { from { transform: scale(0.9); } to { transform: scale(1); } }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fffbe6; font-weight: 600; color: #333; }
        
        .book-btn { width: 100%; background-color: #ff9800; border: none; color: white; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 14px; text-align: center; text-decoration: none; display: block; }
        .book-btn:hover { background-color: #f57c00; }
        .book-btn.unavailable { background-color: #e0e0e0; color: #999; cursor: not-allowed; }
        .book-btn:disabled { background-color: #e0e0e0; color: #999; cursor: not-allowed; }

        .btn-cancel {
            background-color: #ff4444; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-size: 11px; 
            cursor: pointer; 
            margin-left: 5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }
        .btn-cancel:hover { background-color: #cc0000; }

        /* Contract Button Style (Blue) */
        .btn-contract {
            background-color: #0d6efd; /* Bootstrap Primary Blue */
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-contract:hover {
            background-color: #0b5ed7;
            color: white;
        }

        .modal { display: none; position: fixed; z-index: 1500; left: 0; top: 0; width: 100%; height: 100%; background: rgba(15, 15, 15, 0.65); backdrop-filter: blur(4px); justify-content: center; align-items: center; padding: 10px; }
        .modal-content { background: #fff; border-radius: 14px; padding: 25px 30px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 8px 24px rgba(0,0,0,0.25); animation: slideUp 0.3s ease; display: flex; flex-direction: column; gap: 10px; }
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-content .close { position: absolute; top: 12px; right: 16px; font-size: 22px; color: #666; cursor: pointer; transition: 0.2s ease; }
        .modal-content .close:hover { color: #ff3b30; transform: rotate(90deg); }
        .reserve-btn { background: linear-gradient(135deg, #ff8c00, #ff6a00); color: #fff; border: none; padding: 8px 35px; font-size: 1rem; font-weight: 600; border-radius: 10px; cursor: pointer; box-shadow: 0 3px 12px rgba(255, 140, 0, 0.35); transition: all 0.3s ease; width: 100%; margin-top: 15px;}
        .reserve-btn:disabled { background: #ccc; cursor: not-allowed; box-shadow: none; }
        
        h4.gallery-title { margin-top: 15px; margin-bottom: 5px; font-size: 16px; color: #333; }
        .policy-list ul { margin-left: 20px; margin-bottom: 15px; }
        .policy-list li { font-size: 0.9rem; color: #444; margin-bottom: 6px; line-height: 1.5; }
        .policy-list h3 { font-size: 1.1rem; color: #1e1e1e; margin-top: 10px; margin-bottom: 8px; border-bottom: 2px solid #FF9800; display: inline-block; }

        .bed-selector-container { position: relative; width: 100%; margin: 15px 0; border-radius: 8px; overflow: hidden; border: 2px solid #eee; min-height: 200px; background: #f9f9f9; }
        .bed-layout-img { width: 100%; display: block; cursor: zoom-in; } 
        .bed-marker { position: absolute; width: 32px; height: 32px; border-radius: 50%; font-size: 12px; font-weight: bold; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.4); transition: transform 0.2s, background-color 0.2s; border: 2px solid white; z-index: 10; }
        .bed-marker:hover { transform: scale(1.1); }
        .bed-marker.available { background-color: #28a745; color: white; }
        .bed-marker.occupied { background-color: #dc3545; color: white; cursor: not-allowed; opacity: 0.8; }
        .bed-marker.selected { background-color: #ff9800; color: white; transform: scale(1.3); border-color: #fff; box-shadow: 0 0 15px rgba(255, 152, 0, 0.6); z-index: 15; }
        .selection-info { text-align: center; font-size: 14px; margin-top: 5px; font-weight: 500; height: 20px; color: #ff8800; }

        /* --- DEFAULT / 8-PERSON ROOM COORDINATES --- */
        .bed-1 { top: 65%; left: 12%; }
        .bed-2 { top: 35%; left: 12%; }
        .bed-3 { top: 65%; left: 36%; }
        .bed-4 { top: 35%; left: 36%; }
        .bed-5 { top: 65%; left: 62%; }
        .bed-6 { top: 35%; left: 62%; }
        .bed-7 { top: 65%; left: 86%; }
        .bed-8 { top: 35%; left: 86%; }

        /* --- 6-PERSON ROOM OVERRIDES --- */
        .layout-6p .bed-1 { top: 65%; left: 20%; }
        .layout-6p .bed-2 { top: 35%; left: 20%; }
        .layout-6p .bed-3 { top: 65%; left: 50%; }
        .layout-6p .bed-4 { top: 35%; left: 50%; }
        .layout-6p .bed-5 { top: 65%; left: 80%; }
        .layout-6p .bed-6 { top: 35%; left: 80%; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .content { margin-left: 0; padding: 15px 20px; }
            .rooms-grid { grid-template-columns: 1fr; }
            .bed-marker { width: 24px; height: 24px; font-size: 10px; }
        }
        
        /* ✅ Tooltip Styles */
        .reason-tooltip { position: relative; display: inline-block; cursor: pointer; color: #dc3545; margin-left: 5px; }
        .reason-tooltip:hover::after {
            content: attr(data-reason);
            position: absolute;
            bottom: 100%; left: 50%; transform: translateX(-50%);
            background: #333; color: #fff; padding: 5px 10px;
            border-radius: 4px; font-size: 11px; white-space: nowrap; z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-exclamation-circle-fill" style="font-size: 1.2rem;"></i>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        <div class="section">
            <div class="section-title">Available Rooms</div>

            @if($hasActiveBooking)
                <div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Warning: You already have an approved booking. You cannot book another room.</strong>
                </div>
            @endif

            <div class="rooms-grid" id="roomsContainer"></div>
        </div>

        <div id="policyModal" class="modal" style="display:none;">
            <div class="modal-content policy-list">
                <span class="close" onclick="closePolicyModal()">&times;</span>
                <h2 style="text-align:center; margin-bottom:15px;">Boarding House Policies</h2>
                
                <h3>General Conduct</h3>
                <ul>
                    <li><strong>Gender Policy:</strong> Only tenants of the same gender are allowed per room. Mixed gender occupancy is not permitted.</li>
                    <li><strong>Respect:</strong> Treat fellow residents and staff with courtesy and consideration at all times.</li>
                    <li><strong>Cleanliness:</strong> Maintain cleanliness in your room and shared spaces. Dispose of trash in designated bins.</li>
                    <li><strong>Damage Reporting:</strong> Immediately inform management of any damage or maintenance issues in your room or common areas.</li>
                    <li><strong>Guests:</strong> Visitors are allowed only in common areas. Overnight guests require prior written approval from management.</li>
                    <li><strong>Prohibited Items:</strong> Smoking, alcohol, and illegal substances are strictly forbidden anywhere on the property.</li>
                    <li><strong>Quiet Hours:</strong> Observe quiet hours from 10:00 PM to 6:00 AM. Avoid loud noises and disturbances.</li>
                    <li><strong>Safety:</strong> No gambling, illegal activities, or tampering with fire safety equipment is allowed.</li>
                    <li><strong>Security:</strong> Always lock doors and windows when leaving your room. Secure your personal belongings.</li>
                </ul>

                <h3>Payment Policies</h3>
                <ul>
                    <li><strong>Advance Payment:</strong> No advance payment is required before move-in.</li>
                    <li><strong>Due Date:</strong> Rent is due <strong>3 days before your monthly due date</strong>. Please pay on time to avoid penalties.</li>
                    <li><strong>Late Payment:</strong> A <strong>1% penalty</strong> will be added to your monthly rent for late payments.</li>
                    <li><strong>Example:</strong>
                        <ul style="margin-top:5px; margin-left:10px; list-style-type:circle;">
                            <li>Room (₱1600 + 1% penalty = ₱1616)</li>
                        </ul>
                    </li>
                    <li><strong>Refunds:</strong> Payments are non-refundable unless approved by management for special circumstances.</li>
                </ul>

                <h3>Violations & Penalties</h3>
                <ul>
                    <li>Repeated violations of house rules may result in written warnings, fines, or eviction.</li>
                    <li>Residents are financially responsible for any damage they cause to property or facilities.</li>
                </ul>
                
                <div style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                    <input type="checkbox" id="acceptPolicies">
                    <label for="acceptPolicies" style="font-weight:600;">I have read and agree to the policies.</label>
                </div>
                <button id="acceptPoliciesBtn" class="reserve-btn" disabled>
                    Proceed to Room Selection
                </button>
            </div>
        </div>

        <div id="roomModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Room Title</h2>
                <p id="modalPrice" style="color:#ff8800; font-weight:700;"></p>
                <p id="modalDesc" style="font-size:14px; color:#666;"></p>

                <h4>Inclusions:</h4>
                <div id="modalInclusions" class="amenities"></div>

                <h4 style="margin-top:10px;">Select your Bed:</h4>
                <div class="bed-selector-container" id="modalBedContainer">
                    <img src="" alt="Room Layout" class="bed-layout-img" id="modalRoomImage" onclick="openZoom(this.src)">
                    <div id="bedMarkersContainer"></div>
                </div>
                <div class="selection-info" id="selectionInfo">Click a green circle to select your bed</div>

                <h4 class="gallery-title">Gallery</h4>
                <div id="modalGallery" class="gallery-container"></div>

                <div class="modal-actions">
                    <form id="modalBookingForm" method="POST" action="{{ route('student.booking.store') }}">
                        @csrf
                        <input type="hidden" name="room_id" id="modalRoomId">
                        <input type="hidden" name="bed_number" id="modalBedNumber">
                        <button type="submit" class="reserve-btn" id="confirmBookingBtn" disabled>Confirm Booking</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title"><i class="bi bi-calendar-check"></i> My Bookings</div>
            @if($bookings->count())
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr style="background:#fffbe6;">
                    <th style="padding:10px; text-align:left;">Booking #</th>
                    <th style="padding:10px; text-align:left;">Room</th>
                    <th style="padding:10px; text-align:left;">Bed</th>
                    <th style="padding:10px; text-align:left;">Status</th>
                    <th style="padding:10px; text-align:left;">Date Booked</th>
                    <th style="padding:10px; text-align:left;">Action</th>
                </tr>
                </thead>
               <tbody>
@foreach($bookings as $booking)
    @php
        $status = strtolower($booking->status);

        // Check for payments
        $isPaymentSettled = \App\Models\Payment::where('user_id', $booking->user_id)
                            ->where('status', 'Approved')
                            ->where('created_at', '>=', $booking->created_at)
                            ->exists();

        // Badge Colors
        $badgeBg = '#f2f2f2'; $badgeColor = '#888888'; 
        if ($status === 'approved' || $status === 'paid') {
            $badgeBg = '#e6ffec'; $badgeColor = '#28a745'; 
        } elseif ($status === 'pending') {
            $badgeBg = '#fff4e0'; $badgeColor = '#ff9800'; 
        } elseif ($status === 'rejected' || $status === 'cancelled') {
            $badgeBg = '#ffe6e6'; $badgeColor = '#dc3545'; 
        }
    @endphp

    <tr style="border-bottom:1px solid #eee;">
        <td style="padding:10px;">{{ $booking->id }}</td>
        <td style="padding:10px;">{{ $booking->room->room_number ?? 'Room' }}</td>
        <td style="padding:10px;">#{{ $booking->bed_number ?? 'N/A' }}</td>
        <td style="padding:10px;">
            <span style="display:inline-block; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; background: {{ $badgeBg }}; color: {{ $badgeColor }};">
                {{ ucfirst($booking->status) }}
            </span>
            
            {{-- ✅ NEW: Show Rejection Reason Icon --}}
            @if($status === 'rejected' && $booking->rejection_reason)
                <span class="reason-tooltip" data-reason="{{ $booking->rejection_reason }}">
                    <i class="bi bi-info-circle-fill"></i>
                </span>
            @endif

             {{-- Visual Indicator for Payment --}}
             @if($isPaymentSettled && $status === 'approved')
                <div style="font-size:10px; color:#28a745; margin-top:2px; font-weight:bold;">
                    <i class="bi bi-check-all"></i> Paid
                </div>
             @endif
        </td>
        <td style="padding:10px;">
    {{ $booking->created_at->format('M d, Y') }}
    
    {{-- ✅ NEW: Duration Logic --}}
    @php
        $start = \Carbon\Carbon::parse($booking->created_at);
        $duration = $start->diffForHumans(null, true);
    @endphp
    <div style="font-size: 11px; color: #666; margin-top: 4px; font-weight: 500;">
        Duration: {{ $duration }}
    </div>
</td>
        
        <td style="padding:10px;">
            
            @if($status === 'approved' || $status === 'paid')
                <a href="{{ route('student.booking.contract', $booking->id) }}" target="_blank" class="btn-contract">
                    <i class="bi bi-file-earmark-pdf-fill"></i> View Contract
                </a>
            
            @elseif($status === 'pending')
                <form action="{{ route('student.booking.cancel', $booking->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to cancel?');">
                    @csrf
                    @method('POST') 
                    <button type="submit" class="btn-cancel">
                        <i class="bi bi-x-circle-fill"></i> Cancel
                    </button>
                </form>

            @else
                <span style="color: #ccc; font-size: 11px;">-</span>
            @endif

        </td>
    </tr>
@endforeach
</tbody>
            </table>
            @else
            <div style="text-align: center; padding: 20px; color: #888;">
                <p>No bookings found.</p>
            </div>
            @endif
        </div>
    </div>

    <div id="imageZoomModal" class="img-zoom-overlay">
        <img id="zoomedImage" src="" alt="Zoomed View">
    </div>

    <script>
        const roomsData = @json($roomsData);
        const hasActiveBooking = @json($hasActiveBooking);
        const userGender = "{{ strtolower(Auth::user()->gender) }}";

        document.addEventListener('DOMContentLoaded', () => {
            const roomsContainer = document.getElementById('roomsContainer');
            const roomModal = document.getElementById('roomModal');
            const policyModal = document.getElementById('policyModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalPrice = document.getElementById('modalPrice');
            const modalDesc = document.getElementById('modalDesc');
            const modalInclusions = document.getElementById('modalInclusions');
            const modalGallery = document.getElementById('modalGallery');
            const modalRoomId = document.getElementById('modalRoomId');
            const modalBedNumber = document.getElementById('modalBedNumber');
            const modalBedContainer = document.getElementById('modalBedContainer'); 
            const bedMarkersContainer = document.getElementById('bedMarkersContainer');
            const selectionInfo = document.getElementById('selectionInfo');
            const confirmBookingBtn = document.getElementById('confirmBookingBtn');
            const acceptPoliciesBtn = document.getElementById('acceptPoliciesBtn');
            const acceptPoliciesCheckbox = document.getElementById('acceptPolicies');
            const modalRoomImage = document.getElementById('modalRoomImage');
            
            let selectedRoom = null;

            roomsData.forEach(room => {
                const card = document.createElement('div');
                card.className = 'room-card';
                
                const roomGender = room.gender.toLowerCase();
                const isGenderCompatible = (roomGender === 'mixed' || roomGender === userGender);
                
                let btnText = 'SELECT BED';
                let btnClass = 'book-btn open-modal';
                let btnDisabled = '';

                if (!isGenderCompatible) {
                    btnText = capitalizeFirstLetter(room.gender) + 's Only';
                    btnClass += ' unavailable';
                    btnDisabled = 'disabled';
                } else if (hasActiveBooking) {
                    btnText = 'Already Booked';
                    btnClass += ' unavailable';
                    btnDisabled = 'disabled';
                } else if (room.isFull) {
                    btnText = 'Full';
                    btnClass += ' unavailable';
                    btnDisabled = 'disabled';
                }

                const progressWidth = (room.occupied / room.bedspace) * 100;
                const progressColor = room.isFull ? '#dc3545' : ((room.occupied / room.bedspace) >= 0.5 ? '#ffc107' : '#28a745');

                card.innerHTML = `
                    <div class="room-image">
                        <img src="${room.images[0] || ''}" alt="${room.title}" onclick="openZoom(this.src)">
                    </div>
                    <div class="content-area">
                        <h3>${room.title}</h3>
                        <div class="price">${room.price}</div>
                        <div class="desc">${truncateString(room.desc, 60)}</div>
                        
                        <div class="amenities">
                            ${room.inclusions.map(inc => `<div class="amenity-tag">${inc}</div>`).join('')}
                        </div>

                        <div class="bedspace-status">
                            <small>
                                🛏️ ${room.bedspace} beds — 
                                <span style="color:${room.isFull ? '#b30000' : '#007b00'}">
                                    ${room.availableBeds} available
                                </span>
                            </small>
                            <div class="bar">
                                <div class="fill" style="width: ${progressWidth}%; background: ${progressColor};"></div>
                            </div>
                        </div>

                        <button class="${btnClass}" ${btnDisabled} data-room-id="${room.id}">
                            ${btnText}
                        </button>
                    </div>
                `;
                roomsContainer.appendChild(card);
            });

            roomsContainer.addEventListener('click', (e) => {
                if (e.target.classList.contains('open-modal')) {
                    const roomId = e.target.dataset.roomId;
                    selectedRoom = roomsData.find(r => r.id == roomId);
                    openPolicyModal();
                }
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
                if(selectedRoom) openRoomModal(selectedRoom);
            });

            function openRoomModal(room) {
                modalTitle.textContent = room.title;
                modalPrice.textContent = room.price;
                modalDesc.textContent = room.desc;
                modalRoomId.value = room.id;
                modalBedNumber.value = "";
                confirmBookingBtn.disabled = true;
                confirmBookingBtn.textContent = "Select a Bed";
                selectionInfo.textContent = "Click a green circle to select your bed";
                selectionInfo.style.color = "#ff8800";
                modalInclusions.innerHTML = room.inclusions.map(i => `<div class="amenity-tag">${i}</div>`).join('');

                // Image Logic
                let layoutSrc;
                if (room.bedspace == 6) {
                    layoutSrc = "/images/room 6.png"; 
                } else if (room.gender.toLowerCase() === 'male') {
                    layoutSrc = "/images/fem.png"; 
                } else {
                    layoutSrc = "/images/room.png"; 
                }
                modalRoomImage.src = layoutSrc;
                
                // Dynamic Bed Markers & Layout Class Assignment
                bedMarkersContainer.innerHTML = '';
                const totalBeds = room.bedspace || 8; 

                // Reset classes and apply correct layout class
                modalBedContainer.className = 'bed-selector-container';
                if (totalBeds === 6) {
                    modalBedContainer.classList.add('layout-6p');
                } else {
                    modalBedContainer.classList.add('layout-8p'); // Default
                }

                for (let i = 1; i <= totalBeds; i++) {
                    const bedBtn = document.createElement('div');
                    bedBtn.classList.add('bed-marker', 'bed-' + i);
                    bedBtn.textContent = i;

                    if (i <= room.occupied) {
                        bedBtn.classList.add('occupied');
                        bedBtn.title = "Occupied";
                    } else {
                        bedBtn.classList.add('available');
                        bedBtn.title = "Available";
                        bedBtn.addEventListener('click', () => selectBed(i, bedBtn));
                    }
                    bedMarkersContainer.appendChild(bedBtn);
                }

                modalGallery.innerHTML = '';
                room.images.forEach(src => {
                    const img = document.createElement('img');
                    img.src = src;
                    img.className = 'gallery-thumb';
                    img.onclick = function() { openZoom(src); };
                    modalGallery.appendChild(img);
                });

                roomModal.style.display = 'flex';
            }

            function selectBed(bedNum, btnElement) {
                document.querySelectorAll('.bed-marker').forEach(b => b.classList.remove('selected'));
                btnElement.classList.add('selected');
                modalBedNumber.value = bedNum;
                confirmBookingBtn.disabled = false;
                confirmBookingBtn.textContent = "Book Bed " + bedNum;
                selectionInfo.textContent = "You selected Bed " + bedNum;
                selectionInfo.style.color = "#28a745";
            }

            document.querySelectorAll('.close').forEach(c => {
                c.addEventListener('click', () => {
                    roomModal.style.display = 'none';
                    policyModal.style.display = 'none';
                });
            });

            const zoomOverlay = document.getElementById('imageZoomModal');
            const zoomImg = document.getElementById('zoomedImage');
            window.openZoom = function(src) {
                zoomImg.src = src;
                zoomOverlay.style.display = 'flex';
            }
            zoomOverlay.addEventListener('click', () => {
                zoomOverlay.style.display = 'none';
            });

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
            function truncateString(str, num) {
                if (!str) return '';
                if (str.length <= num) return str;
                return str.slice(0, num) + '...';
            }

            window.toggleSidebar = function() {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('content').classList.toggle('expanded');
            };
            
            window.closePolicyModal = function() {
                 policyModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>