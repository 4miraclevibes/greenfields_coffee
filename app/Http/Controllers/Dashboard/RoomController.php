<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomDetail;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomDetails')->get();
        return view('pages.backend.rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name'
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function barcode(Room $room)
    {
        return view('pages.backend.rooms.barcode', compact('room'));
    }

    // Room Detail CRUD
    public function storeDetail(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $room->roomDetails()->create([
            'name' => $request->name
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room location added successfully.');
    }

    public function updateDetail(Request $request, RoomDetail $roomDetail)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $roomDetail->update([
            'name' => $request->name
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room location updated successfully.');
    }

    public function destroyDetail(RoomDetail $roomDetail)
    {
        $roomDetail->delete();

        return redirect()->route('rooms.index')->with('success', 'Room location deleted successfully.');
    }
}
