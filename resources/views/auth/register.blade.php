<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patani Trinidad | Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Molle:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <style>
        /* --- CSS STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { display: flex; align-items: stretch; justify-content: center; min-height: 100vh; background-color: #fff; overflow-y: auto; }
        
        .left {
            flex: 1;
            background: linear-gradient(rgba(255, 165, 0, 0.7), rgba(255, 165, 0, 0.7)),
                url("/images/received_1367814431592858.jpeg") center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
            padding: 40px;
        }
        .logo {
            position: absolute;
            top: 30px;
            left: 50px;
            font-family: "Molle", cursive;
            font-size: 1.5rem;  
            color: #1e1e1e;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.4);
            padding: 5px 15px;
            border-radius: 10px;
        }
        .left h1 {
            font-size: 2.8rem;
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            padding: 40px 20px;
            min-height: 100vh;
        }
        #backHomeBtn {
            background: transparent;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            color: #0A142F;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
            border: 1px solid transparent;
        }
        #backHomeBtn:hover { color: #FFF200; border-color: #FFF200; }

        .form-container { width: 100%; max-width: 500px; background: #fff; display: flex; flex-direction: column; justify-content: center; }
        h2 { color: #1e1e1e; font-weight: 700; font-size: 1.4rem; text-align: center; margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; margin-bottom: 5px; color: #555; font-weight: 500; }
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #d6e6ff;
            border-radius: 8px;
            margin-bottom: 5px; 
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus, select:focus { border-color: #ffa000; }
        
        /* Error Message Style */
        .error {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 2px;
            margin-bottom: 12px;
            display: block;
            text-align: left;
        }
        .input-error { border-color: #dc3545; background-color: #fff8f8; }

        .row { display: flex; gap: 12px; }
        .row > div { flex: 1; }

        button[type="submit"] {
            width: 100%;
            background-color: #ff8800;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
        }
        button[type="submit"]:hover { background-color: #e67600; }

        p { margin-top: 15px; font-size: 0.85rem; color: #666; text-align: center; }
        a { color: #007bff; text-decoration: none; font-size: 0.85rem; font-weight: 500; }
        a:hover { text-decoration: underline; }

        .password-input-container { position: relative; display: flex; align-items: center; margin-bottom: 5px; }
        .password-input-container input { flex-grow: 1; padding-right: 40px; margin-bottom: 0; }
        .password-toggle-icon {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #aaa;
            font-size: 1rem;
            z-index: 2;
        }
        .password-toggle-icon:hover { color: #ff8800; }

        /* Loader */
        .loading-text { font-size: 11px; color: #888; font-style: italic; display:none; margin-top: -3px; margin-bottom: 5px; }

        @media (max-width: 900px) {
            body { flex-direction: column; }
            .left, .right { flex: none; width: 100%; min-height: auto; }
            .left { min-height: 30vh; padding: 20px; }
            .right { padding: 40px 20px; }
            .form-container { max-width: 100%; }
            .row { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>
    <div class="left">
        <div class="logo">Patani Trinidad</div>
        <h1>Welcome!</h1>
        <button id="backHomeBtn">Back to Homepage</button>
    </div>

    <div class="right">
        <div class="form-container">
            <h2>Create an account</h2>

            <form action="{{ route('register.submit') }}" method="POST" onsubmit="updateFullAddress()">
                @csrf
              
                {{-- SPLIT NAME FIELDS --}}
                <label>Full Name</label>
                <div class="row">
                    {{-- Last Name --}}
                    <div>
                        <input type="text" name="last_name" 
                               placeholder="Last Name" 
                               value="{{ old('last_name') }}" 
                               class="@error('last_name') input-error @enderror" 
                               required>
                        @error('last_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- First Name --}}
                    <div>
                        <input type="text" name="first_name" 
                               placeholder="First Name" 
                               value="{{ old('first_name') }}" 
                               class="@error('first_name') input-error @enderror" 
                               required>
                        @error('first_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Middle Initial (Smaller Column) --}}
                    <div style="flex: 0.4;">
                        <input type="text" name="middle_initial" 
                               placeholder="M.I." 
                               value="{{ old('middle_initial') }}" 
                               maxlength="3"
                               class="@error('middle_initial') input-error @enderror">
                        @error('middle_initial')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <label>Email</label>
                <input type="email" name="email" 
                       placeholder="your_email@example.com" 
                       value="{{ old('email') }}" 
                       class="@error('email') input-error @enderror" 
                       required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror

                {{-- Password --}}
                <label for="password">Password</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" 
                           placeholder="Minimum 6 characters" 
                           class="@error('password') input-error @enderror" 
                           required>
                    <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                </div>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror

                {{-- Confirm Password --}}
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-input-container">
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           placeholder="Re-enter your password" 
                           required>
                    <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirmation"></i>
                </div>
                
                {{-- Row for Gender & Contact --}}
                <div class="row">
                    <div>
                        <label>Gender</label>
                        <select name="gender" class="@error('gender') input-error @enderror" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Contact No.</label>
                        <input type="text" name="contact" 
                               placeholder="09** *** ****" 
                               value="{{ old('contact') }}" 
                               class="@error('contact') input-error @enderror" 
                               required>
                        @error('contact')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- ✅ UPDATED ADDRESS SECTION --}}
                <label style="margin-top: 10px; font-weight: 600;">Complete Address</label>
                
                <div class="row">
                    <div>
                        <input type="text" id="house_street" placeholder="House No. / Street" oninput="updateFullAddress()">
                    </div>
                    <div>
                        <input type="text" id="subdivision" placeholder="Subdivision / Village" oninput="updateFullAddress()">
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label style="font-size: 0.75rem;">Province</label>
                        <select id="province" onchange="loadCities()" required></select>
                        <span id="loader-province" class="loading-text">Loading...</span>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem;">City / Municipality</label>
                        <select id="city" onchange="loadBarangays()" disabled required></select>
                        <span id="loader-city" class="loading-text">Loading...</span>
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label style="font-size: 0.75rem;">Barangay</label>
                        <select id="barangay" onchange="updateFullAddress()" disabled required></select>
                        <span id="loader-barangay" class="loading-text">Loading...</span>
                    </div>
                </div>

                {{-- Hidden input stores the concatenated address for the backend --}}
                <input type="hidden" name="address" id="full_address" value="{{ old('address') }}">
                @error('address')
                    <span class="error">{{ $message }}</span>
                @enderror

                <button type="submit">Create account</button>
            </form>

            <p>Already Have An Account? <a href="{{ route('login') }}">Log In</a></p>
        </div>
    </div>

    <script>
        // Back to Homepage Button
        document.getElementById('backHomeBtn').addEventListener('click', function() {
            window.location.href = "{{ url('/') }}"; 
        });

        // Password Visibility Toggle Logic
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input && icon) {
                icon.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        }

        // Initialize Toggles
        toggleVisibility('password', 'togglePassword');
        toggleVisibility('password_confirmation', 'togglePasswordConfirmation');

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

            document.getElementById('full_address').value = fullAddress;
        }

        // Initialize on load
        window.onload = loadProvinces;
    </script>
</body>
</html>