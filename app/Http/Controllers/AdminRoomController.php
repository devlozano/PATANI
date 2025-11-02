<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AdminRoomController extends Controller
{
    // Show all rooms
    public function index()
    {
        $rooms = Room::all();
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
    $request->validate([
        'room_number' => 'required',
        'room_floor' => 'required',
        'gender' => 'required',
        'bedspace' => 'required|numeric',
        'status' => 'required',
        'rent_fee' => 'required|numeric',
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['room_number', 'room_floor', 'gender', 'bedspace', 'status', 'rent_fee', 'description']);

    // Handle image upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('rooms', 'public');
        $data['image'] = $path;
    }

    Room::create($data);

    return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
}   
}