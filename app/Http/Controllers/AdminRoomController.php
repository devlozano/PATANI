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
        'bedspace' => 'required|integer',
        'status' => 'required',
        'rent_fee' => 'required|numeric',
        'description' => 'required',
        'inclusions' => 'required|array',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $room = new Room();
    $room->room_number = $request->room_number;
    $room->room_floor = $request->room_floor;
    $room->gender = $request->gender;
    $room->bedspace = $request->bedspace;
    $room->status = $request->status;
    $room->rent_fee = $request->rent_fee;
    $room->description = $request->description;

    // Save inclusions as JSON
    $room->inclusions = json_encode($request->inclusions);

    // Save main image
    if ($request->hasFile('image')) {
        $room->image = $request->file('image')->store('rooms', 'public');
    }

    // Save gallery images as JSON
    if ($request->hasFile('gallery')) {
        $galleryPaths = [];
        foreach ($request->file('gallery') as $file) {
            $galleryPaths[] = $file->store('rooms/gallery', 'public');
        }
        $room->gallery = json_encode($galleryPaths);
    }

    $room->save();

    return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
}
}