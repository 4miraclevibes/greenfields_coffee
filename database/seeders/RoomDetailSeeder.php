<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all rooms
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Create dummy room details (locations) for each office
            $roomDetails = [
                ['name' => 'Meeting Room 1'],
                ['name' => 'Meeting Room 2'],
                ['name' => 'Meeting Room 3'],
                ['name' => 'Main Office'],
                ['name' => 'Lobby'],
                ['name' => 'Cafeteria'],
                ['name' => 'Work Space 1'],
                ['name' => 'Work Space 2'],
            ];

            foreach ($roomDetails as $detail) {
                RoomDetail::create([
                    'room_id' => $room->id,
                    'name' => $detail['name']
                ]);
            }
        }
    }
}
