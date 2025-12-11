<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AdminRoomController extends Controller
{
    // Show all rooms
    public function index()
    {
$rooms = Room::all()->map(function($room) {
        // Decode inclusions & gallery safely
        $inclusions = is_array($room->inclusions) 
    ? $room->inclusions 
    : json_decode($room->inclusions ?? '[]', true);
        $room->inclusions = $inclusions;
        $room->gallery = json_decode($room->gallery ?? '[]', true);
        return $room;
    });

    return view('admin.room', compact('rooms'));
}

    public function edit($id)
    {
        $room = Room::findOrFail($id);  // Get the room by ID
        return view('admin.room-edit', compact('room')); // Pass $room to the view
    }   

    // Update the room
    public function update(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required',
            'room_floor' => 'required',
            'rent_fee' => 'required|numeric',
            'status' => 'required',
            'description' => 'nullable|string',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->only('room_number','room_floor','rent_fee','status','description'));

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }


    public function destroy($id)
{
    $room = Room::findOrFail($id);

    // Delete image from storage if exists
    if ($room->image) {
        \Storage::disk('public')->delete($room->image);
    }

    $room->delete();

    return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
}

public function store(Request $request)
{
    $data = $request->validate([
        'room_number' => 'required|integer',
        'room_floor'  => 'required|string',
        'gender'      => 'required|string',
        'bedspace'    => 'required|integer',
        'status'      => 'required|string',
        'rent_fee'    => 'required|numeric',
        'description' => 'required|string',
        'inclusions'  => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ]);

    $room = new Room();
    $room->room_number = $data['room_number'];
    $room->room_floor  = $data['room_floor'];
    $room->gender      = $data['gender'];
    $room->bedspace    = $data['bedspace'];
    $room->status      = $data['status'];
    $room->rent_fee    = $data['rent_fee'];
    $room->description = $data['description'];

    // Inclusions
    $inclusions = array_filter(array_map('trim', explode(',', $request->inclusions ?? '')));
    $room->inclusions = json_encode($inclusions);

    // Main image
    if ($request->hasFile('image')) {
        $room->image = $request->file('image')->store('rooms', 'public');
    }

    // Gallery
    $galleryPaths = [];
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $file) {
            $galleryPaths[] = $file->store('rooms/gallery', 'public');
        }
    }
    $room->gallery = json_encode($galleryPaths);

    $room->save();

    return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
}
}