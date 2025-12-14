<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    // Show all rooms
    public function index()
    {
        $rooms = Room::all()->map(function($room) {
            // Decode inclusions & gallery safely so the View can loop through them
            $room->inclusions = is_string($room->inclusions) 
                ? json_decode($room->inclusions, true) 
                : ($room->inclusions ?? []);
                
            $room->gallery = is_string($room->gallery) 
                ? json_decode($room->gallery, true) 
                : ($room->gallery ?? []);
                
            return $room;
        });

        return view('admin.room', compact('rooms'));
    }

    // Store (Add New Room)
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

        // 1. Handle Inclusions
        $inclusions = array_filter(array_map('trim', explode(',', $request->inclusions ?? '')));
        $room->inclusions = json_encode($inclusions);

        // 2. Handle Main Image
        if ($request->hasFile('image')) {
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        // 3. Handle Gallery
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

    // Update the room
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'room_number' => 'required',
            'room_floor'  => 'required',
            'gender'      => 'required',
            'bedspace'    => 'required',
            'status'      => 'required',
            'rent_fee'    => 'required|numeric',
            'description' => 'required|string',
            'inclusions'  => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $room = Room::findOrFail($id);

        // Update Basic Fields
        $room->room_number = $data['room_number'];
        $room->room_floor  = $data['room_floor'];
        $room->gender      = $data['gender'];
        $room->bedspace    = $data['bedspace'];
        $room->status      = $data['status'];
        $room->rent_fee    = $data['rent_fee'];
        $room->description = $data['description'];

        // Update Inclusions
        if ($request->has('inclusions')) {
            $inclusions = array_filter(array_map('trim', explode(',', $request->inclusions ?? '')));
            $room->inclusions = json_encode($inclusions);
        }

        // Update Main Image
        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        // Update Gallery
        if ($request->hasFile('gallery')) {
            $currentGallery = json_decode($room->gallery ?? '[]', true);
            if (!is_array($currentGallery)) $currentGallery = [];

            foreach ($request->file('gallery') as $file) {
                $currentGallery[] = $file->store('rooms/gallery', 'public');
            }
            $room->gallery = json_encode($currentGallery);
        }

        $room->save();

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    // Delete Room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // ✅ SECURITY CHECK: Prevent deletion if room has active bookings
        // We check for 'Approved', 'Pending', or 'Paid' statuses.
        $hasActiveBookings = $room->bookings()
            ->whereIn('status', ['Approved', 'Pending', 'Paid'])
            ->exists();

        if ($hasActiveBookings) {
            // ❌ RETURN ERROR: Triggers the RED alert in your HTML
            return redirect()->back()->with('error', 'Cannot delete this room! It currently has active occupants or pending bookings.');
        }

        // If no active bookings, proceed with deletion:
        
        // 1. Delete Main Image
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        // 2. Delete Gallery Images
        $gallery = json_decode($room->gallery ?? '[]', true);
        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}