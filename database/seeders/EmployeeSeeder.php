<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            ['name' => 'Budi Santoso'],
            ['name' => 'Siti Rahayu'],
            ['name' => 'Ahmad Wijaya'],
            ['name' => 'Dewi Lestari'],
            ['name' => 'Eko Prasetyo'],
            ['name' => 'Rina Wulandari'],
            ['name' => 'Joko Widodo'],
            ['name' => 'Maya Sari'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
