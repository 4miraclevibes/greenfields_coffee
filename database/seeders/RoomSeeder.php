<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['name' => 'Meeting Room A'],
            ['name' => 'Meeting Room B'],
            ['name' => 'Conference Room'],
            ['name' => 'Executive Office'],
            ['name' => 'Reception Area'],
            ['name' => 'Break Room'],
            ['name' => 'IT Department'],
            ['name' => 'HR Department'],
            ['name' => 'Finance Department'],
            ['name' => 'Marketing Department']
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
