@extends('layout.admin')

@section('title', 'Edit Room #' . $room->id)

@section('content')
<div class="form-section">
    <h1 class="section-title">Edit Room #{{ $room->id }}</h1>

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

       <!-- Edit Room -->
<div class="form-section">
    <h2 class="section-title">Edit Room</h2>

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

{{-- JavaScript to show selected file name and preview --}}
<script>
    function resetForm() {
    const form = document.querySelector('.form-section form');
    form.reset();
    document.querySelector('.section-title').textContent = 'Add New Room';
    document.querySelector('.submit-btn').textContent = 'Add Room';
    form.action = "{{ route('admin.rooms.store') }}";

    // Remove PUT method if exists
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    fileName.textContent = 'No file selected.';
    const img = document.querySelector('.current-image img');
    if (img) img.src = '';
}

    const currentImageDiv = document.querySelector('.current-image');
if (!currentImageDiv) {
    const div = document.createElement('div');
    div.classList.add('current-image');
    div.style.marginTop = '10px';
    div.innerHTML = `<p>Current Image:</p><img src="" alt="Room Image" style="width:150px; border-radius:8px;">`;
    document.querySelector('.form-group.form-full').appendChild(div);
}
document.querySelector('.current-image img').src = room.image ? `/storage/${room.image}` : '';

(() => {
    const browseButton = document.getElementById('browseButton');
const fileInput = document.getElementById('roomImage');
const fileName = document.getElementById('fileName');

browseButton.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', () => {
    if(fileInput.files.length > 0) {
        fileName.textContent = fileInput.files[0].name;
    } else {
        fileName.textContent = "No file selected.";
    }
});

})();
</script>

        <button type="submit" class="logout-btn" style="background:#4CAF50; margin-top:20px;">
            <i class="bi bi-save"></i> Update Room
        </button>
    </form>
</div>
@endsection