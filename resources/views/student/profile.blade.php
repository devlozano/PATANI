<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | Patani Trinidad</title>
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
        .avatar { display: flex; flex-direction: column; align-items: center; }
        .avatar-img { width: 75px; height: 75px; border-radius: 50%; object-fit: cover; }
        .avatar-initials { width: 50px; height: 50px; border-radius: 50%; background: #FF8D01; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600; color: #fffff0; }
        .upload-avatar-btn, .remove-avatar-btn { background: #f0b429; color: #fff; border: none; padding: 6px 10px; margin-top: 5px; border-radius: 6px; cursor: pointer; }
        .remove-avatar-btn { background: #d9534f; }
        .profile h2 { font-size: 1.1rem; font-weight: 600; color: #1e1e1e; margin-bottom: 5px; }
        .profile p { font-size: 0.95rem; color: #333; }
        .menu { width: 100%; display: flex; flex-direction: column; gap: 10px; }
        .menu a { display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; text-decoration: none; color: #1e1e1e; font-weight: 500; transition: all 0.3s ease; font-size: 1rem; }
        .menu a:hover { background: rgba(255, 255, 255, 0.3); }
        .menu a.active { background: #ff8800; color: white; }
        .menu i { margin-right: 15px; font-size: 1.3rem; }
        .content { flex: 1; margin-left: 365px; padding: 0; transition: margin-left 0.3s ease; }
        .content.expanded { margin-left: 0; }
        .top-bar { display: flex; align-items: center; justify-content: space-between; background: #fffbe6; padding: 20px 40px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .top-bar-left { display: flex; align-items: center; gap: 20px; }
        .menu-toggle { background: none; border: none; font-size: 28px; cursor: pointer; padding: 5px; color: #1e1e1e; display: flex; align-items: center; }
        .logo { font-family: "Molle", cursive; font-size: 28px; color: #002d18; }
        .logout-btn { background-color: #ff3b00; color: white; border: none; border-radius: 8px; padding: 10px 20px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; font-size: 15px; }
        .logout-btn:hover { background-color: #e63500; }
        .main-content { padding: 40px; }
        h1 { font-size: 36px; font-weight: 700; margin-bottom: 40px; }
        .section { background: #ffffff; border-radius: 16px; padding: 40px 50px; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); border: 1px solid #e6e6e6; width: 90%; max-width: 900px; transition: box-shadow 0.3s ease; }
        .section:hover { box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12); }
        .section-header { display: flex; align-items: center; gap: 15px; margin-bottom: 35px; }
        .section-header img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #ff9800; background: #fff; }
        .section-header h2 { font-size: 22px; font-weight: 700; color: #222; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px 40px; margin-bottom: 20px; }
        .info-item label { font-size: 14px; color: #666; display: block; margin-bottom: 6px; }
        .info-item p { font-size: 16px; font-weight: 600; color: #1e1e1e; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px 40px; align-items: start; }
        .form-group { display: flex; flex-direction: column; width: 100%; }
        .form-group label { font-size: 14px; color: #333; margin-bottom: 8px; font-weight: 500; }
        .form-group input, .form-group select { width: 100%; box-sizing: border-box; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; font-family: "Poppins", sans-serif; background: #f9f9f9; transition: all 0.25s ease; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #ff9800; background: #fff; box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.15); }
        .update-btn-wrapper { display: flex; justify-content: flex-end; margin-top: 35px; }
        .update-btn { background-color: #ff9800; border: none; color: #fff; padding: 12px 40px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 15px; box-shadow: 0 3px 6px rgba(255, 152, 0, 0.3); }
        .update-btn:hover { background-color: #f57c00; box-shadow: 0 4px 10px rgba(245, 124, 0, 0.35); }
        
        .input-error { border-color: #dc3545 !important; background-color: #fff8f8 !important; }
        .error-text { color: #dc3545; font-size: 12px; margin-top: 5px; }

        /* Loader */
        .loading-text { font-size: 12px; color: #888; font-style: italic; display:none; margin-top: 5px; }

        @media (max-width: 1024px) { .info-grid, .form-grid { grid-template-columns: 1fr; gap: 20px; } }
        @media (max-width: 768px) { .sidebar { width: 300px; transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .content { margin-left: 0; } .top-bar { padding: 15px 20px; } .main-content { padding: 20px; } .dashboard-grid { grid-template-columns: 1fr; gap: 20px; } }
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
            <div class="top-bar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="logo">Patani Trinidad</div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirmLogout();">
                    Logout <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
            <script> function confirmLogout() { return confirm("Are you sure you want to log out?"); } </script>
        </div>

        <div class="main-content">
            <h1>Student Profile</h1>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 1.2rem;"></i>
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.2rem;"></i>
                        <strong>Whoops! Something went wrong.</strong>
                    </div>
                    <ul style="margin-left: 25px; margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="section">
                <div class="section-header">
                    <div class="avatar">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-img">
                            <form action="{{ route('profile.removeAvatar') }}" method="POST" style="margin-top:6px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-avatar-btn">Remove</button>
                            </form>
                        @else
                            <div class="avatar-initials">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' '), 1, 1)) }}
                            </div>
                        @endif
                    </div>
                    <span>My Information</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Name:</label>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    <div class="info-item">
                        <label>Gender:</label>
                        <p>{{ Auth::user()->gender ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <p>{{ Auth::user()->email ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Address:</label>
                        <p>{{ Auth::user()->address ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item">
                        <label>Contact:</label>
                        <p>{{ Auth::user()->contact ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <span style="font-size: 20px; font-weight: 600; color: #333;">Update Information</span>
                
                <div class="section-header" style="display: flex; align-items: center; justify-content: start; gap: 20px; margin-top: 20px;">
                    {{-- Avatar Section in Update form --}}
                    <div class="avatar" style="text-align: center;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-img">
                            <form action="{{ route('profile.removeAvatar') }}" method="POST" style="margin-top:6px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-avatar-btn">Remove</button>
                            </form>
                        @else
                            <div class="avatar-initials">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' '), 1, 1)) }}
                            </div>
                        @endif

                        <form action="{{ route('profile.uploadAvatar') }}" method="POST" enctype="multipart/form-data" style="margin-top:6px;">
                            @csrf
                            <input type="file" name="avatar" accept="image/*" required style="font-size: 12px;">
                            <button type="submit" class="upload-avatar-btn">Upload</button>
                        </form>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" onsubmit="updateFullAddress()">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" class="@error('first_name') input-error @enderror" required>
                            @error('first_name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Middle Initial <small style="color:#888;">(Optional)</small>:</label>
                            <input type="text" name="middle_initial" value="{{ old('middle_initial', Auth::user()->middle_initial) }}" class="@error('middle_initial') input-error @enderror">
                            @error('middle_initial') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" class="@error('last_name') input-error @enderror" required>
                            @error('last_name') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Gender:</label>
                            <select name="gender">
                                <option value="Male" {{ (old('gender', Auth::user()->gender) === 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (old('gender', Auth::user()->gender) === 'Female') ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Contact:</label>
                            <input type="text" name="contact" value="{{ old('contact', Auth::user()->contact) }}" required>
                        </div>

                        {{-- ✅ NEW ADDRESS FIELDS --}}
                        <div class="form-group">
                            <label>House No. / Street:</label>
                            <input type="text" id="house_street" class="form-control" placeholder="e.g. 123 Main St." oninput="updateFullAddress()">
                        </div>

                        <div class="form-group">
                            <label>Subdivision / Village:</label>
                            <input type="text" id="subdivision" class="form-control" placeholder="e.g. Greenfields Subd." oninput="updateFullAddress()">
                        </div>

                        <div class="form-group">
                            <label>Province:</label>
                            <select id="province" class="form-control" onchange="loadCities()"></select>
                            <span id="loader-province" class="loading-text">Loading...</span>
                        </div>

                        <div class="form-group">
                            <label>City / Municipality:</label>
                            <select id="city" class="form-control" onchange="loadBarangays()" disabled></select>
                            <span id="loader-city" class="loading-text">Loading...</span>
                        </div>

                        <div class="form-group">
                            <label>Barangay:</label>
                            <select id="barangay" class="form-control" onchange="updateFullAddress()" disabled></select>
                            <span id="loader-barangay" class="loading-text">Loading...</span>
                        </div>

                        {{-- Hidden input stores the concatenated address for the backend --}}
                        <input type="hidden" name="address" id="full_address" value="{{ old('address', Auth::user()->address) }}">
                    </div>

                    <div class="update-btn-wrapper">
                        <button type="submit" class="update-btn">Update Profile</button>
                    </div>
                </form>

                <hr style="margin: 40px 0; border: 0; border-top: 1px solid #eee;">

                <span style="font-size: 20px; font-weight: 600; color: #333; display: block; margin-bottom: 20px;">Change Password</span>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="password">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" required placeholder="Enter current password">
                            @error('current_password') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" required placeholder="Enter new password">
                            @error('password') <span class="error-text">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="update-btn-wrapper">
                        <button type="submit" class="update-btn">Update Password</button>
                    </div>
                </form>
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

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.menu-toggle');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // ✅ PHILIPPINE ADDRESS SELECTOR LOGIC (Using PSGC API)
        const apiBase = "https://psgc.gitlab.io/api";

        async function loadProvinces() {
            const provinceSelect = document.getElementById('province');
            document.getElementById('loader-province').style.display = 'block';
            
            try {
                const response = await fetch(`${apiBase}/provinces/`);
                const data = await response.json();
                data.sort((a, b) => a.name.localeCompare(b.name));

                provinceSelect.innerHTML = '<option value="" disabled selected>Select Province</option>';
                data.forEach(prov => {
                    provinceSelect.innerHTML += `<option value="${prov.code}" data-name="${prov.name}">${prov.name}</option>`;
                });
            } catch (error) {
                console.error("Error loading provinces:", error);
            } finally {
                document.getElementById('loader-province').style.display = 'none';
            }
        }

        async function loadCities() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const provinceCode = provinceSelect.value;
            const barangaySelect = document.getElementById('barangay');

            if (!provinceCode) return;

            citySelect.disabled = true;
            barangaySelect.disabled = true;
            citySelect.innerHTML = '<option>Loading...</option>';
            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
            document.getElementById('loader-city').style.display = 'block';

            try {
                const response = await fetch(`${apiBase}/provinces/${provinceCode}/cities-municipalities/`);
                const data = await response.json();
                data.sort((a, b) => a.name.localeCompare(b.name));

                citySelect.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';
                data.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.code}" data-name="${city.name}">${city.name}</option>`;
                });
                citySelect.disabled = false;
            } catch (error) {
                console.error("Error loading cities:", error);
            } finally {
                document.getElementById('loader-city').style.display = 'none';
                updateFullAddress(); 
            }
        }

        async function loadBarangays() {
            const citySelect = document.getElementById('city');
            const barangaySelect = document.getElementById('barangay');
            const cityCode = citySelect.value;

            if (!cityCode) return;

            barangaySelect.disabled = true;
            barangaySelect.innerHTML = '<option>Loading...</option>';
            document.getElementById('loader-barangay').style.display = 'block';

            try {
                const response = await fetch(`${apiBase}/cities-municipalities/${cityCode}/barangays/`);
                const data = await response.json();
                data.sort((a, b) => a.name.localeCompare(b.name));

                barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
                data.forEach(brgy => {
                    barangaySelect.innerHTML += `<option value="${brgy.name}">${brgy.name}</option>`;
                });
                barangaySelect.disabled = false;
            } catch (error) {
                console.error("Error loading barangays:", error);
            } finally {
                document.getElementById('loader-barangay').style.display = 'none';
                updateFullAddress();
            }
        }

        function updateFullAddress() {
            const houseStreet = document.getElementById('house_street').value.trim();
            const subdivision = document.getElementById('subdivision').value.trim();
            const province = document.getElementById('province').options[document.getElementById('province').selectedIndex]?.dataset.name || '';
            const city = document.getElementById('city').options[document.getElementById('city').selectedIndex]?.dataset.name || '';
            const barangay = document.getElementById('barangay').value || '';

            // Combine them sequentially
            let fullAddress = '';
            if (houseStreet) fullAddress += `${houseStreet}, `;
            if (subdivision) fullAddress += `${subdivision}, `;
            if (barangay) fullAddress += `${barangay}, `;
            if (city) fullAddress += `${city}, `;
            if (province) fullAddress += `${province}`;

            // Remove trailing comma if exists
            fullAddress = fullAddress.replace(/,\s*$/, "");

            if(fullAddress) {
                document.getElementById('full_address').value = fullAddress;
            }
        }

        // Initialize on load
        window.onload = loadProvinces;
    </script>
</body>
</html>