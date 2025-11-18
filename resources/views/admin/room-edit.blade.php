@extends('layout.admin')

@section('title', 'Edit Room #' . $room->id)

@section('content')
<div class="form-section">
    <h1 class="section-title">Edit Room #{{ $room->id }}</h1>

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Room Number:</label>
                <select name="room_number" required>
                    <option value="">Select</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ $room->room_number == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Room Floor:</label>
                <select name="room_floor" required>
                    <option value="">Select</option>
                    <option value="Ground Floor" {{ $room->room_floor == 'Ground Floor' ? 'selected' : '' }}>Ground Floor</option>
                    <option value="First Floor" {{ $room->room_floor == 'First Floor' ? 'selected' : '' }}>First Floor</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" required>
                    <option value="">Select</option>
                    <option value="Female" {{ $room->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Male" {{ $room->gender == 'Male' ? 'selected' : '' }}>Male</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bedspace:</label>
                <select name="bedspace" required>
                    <option value="">Select</option>
                    <option value="4" {{ $room->bedspace == 4 ? 'selected' : '' }}>4</option>
                    <option value="6" {{ $room->bedspace == 6 ? 'selected' : '' }}>6</option>
                    <option value="8" {{ $room->bedspace == 8 ? 'selected' : '' }}>8</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                </select>
            </div>

            <div class="form-group">
                <label>Rent Fee:</label>
                <select name="rent_fee" required>
                    <option value="">Select</option>
                    <option value="1500" {{ $room->rent_fee == 1500 ? 'selected' : '' }}>₱1,500.00</option>
                    <option value="1600" {{ $room->rent_fee == 1600 ? 'selected' : '' }}>₱1,600.00</option>
                </select>
            </div>
        </div>

        <div class="form-group form-full">
            <label>Description:</label>
            <textarea name="description" placeholder="Room details..." required>{{ old('description', $room->description) }}</textarea>
        </div>

        <!-- Room Image -->
        <div class="form-group form-full">
            <label>Pick Image:</label>
            <div class="file-input-wrapper">
                <button type="button" class="file-button" id="browseButton">Browse...</button>
                <span class="file-name" id="fileName">No file selected.</span>
                <input type="file" name="image" id="roomImage" accept="image/*" style="display:none;">
            </div>

            @if($room->image)
                <div class="current-image" style="margin-top:10px;">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" style="width:150px; border-radius:8px;">
                </div>
            @endif
        </div>

        <!-- Inclusions -->
        <div class="form-group form-full">
            <label>Room Inclusions (separate by comma):</label>
            <input type="text" name="inclusions" placeholder="WiFi, Electric Fan, Cabinet"
                value="{{ old('inclusions', implode(', ', $room->inclusions ?? [])) }}">
        </div>

        <!-- Gallery Upload -->
        <div class="form-group form-full">
            <label>Room Gallery (You can upload multiple images):</label>
            <input type="file" name="gallery[]" accept="image/*" multiple>

            @if($room->gallery)
                <div style="margin-top: 12px;">
                    <p>Current Gallery:</p>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        @foreach($room->gallery as $img)
                            <img src="{{ asset('storage/' . $img) }}" style="width:100px; border-radius:8px;">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="logout-btn" style="background:#4CAF50; margin-top:20px;">
            <i class="bi bi-save"></i> Update Room
        </button>
    </form>
</div>

<!-- JS for file input -->
<script>
(() => {
    const browseButton = document.getElementById('browseButton');
    const fileInput = document.getElementById('roomImage');
    const fileName = document.getElementById('fileName');

    browseButton.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        fileName.textContent = fileInput.files.length > 0 
            ? fileInput.files[0].name 
            : 'No file selected.';
    });
})();
</script>
@endsection
