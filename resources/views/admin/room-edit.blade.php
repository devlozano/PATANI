<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room #{{ $room->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 6px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Room #{{ $room->id }}</h1>

        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Room Number</label>
            <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}">

            <label>Room Floor</label>
            <input type="text" name="room_floor" value="{{ old('room_floor', $room->room_floor) }}">

            <label>Rent Fee</label>
            <input type="number" name="rent_fee" value="{{ old('rent_fee', $room->rent_fee) }}" step="0.01">

            <label>Status</label>
            <select name="status">
                <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $room->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>

            <label>Description</label>
            <textarea name="description">{{ old('description', $room->description) }}</textarea>

            <button type="submit">Update Room</button>
        </form>
    </div>
</body>
</html>
