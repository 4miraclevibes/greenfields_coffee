<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Americano',
                'is_available' => true,
                'image' => null,
                'descriptions' => 'Kopi hitam yang kuat dengan rasa yang khas'
            ],
            [
                'name' => 'Cappuccino',
                'is_available' => true,
                'image' => null,
                'descriptions' => 'Kopi dengan susu dan foam yang lembut'
            ],
            [
                'name' => 'Latte',
                'is_available' => true,
                'image' => null,
                'descriptions' => 'Kopi dengan susu yang creamy dan lembut'
            ],
            [
                'name' => 'Espresso',
                'is_available' => true,
                'image' => null,
                'descriptions' => 'Kopi murni yang kuat dan pekat'
            ],
            [
                'name' => 'Mocha',
                'is_available' => true,
                'image' => null,
                'descriptions' => 'Kopi dengan coklat yang manis'
            ],
            [
                'name' => 'Macchiato',
                'is_available' => false,
                'image' => null,
                'descriptions' => 'Kopi dengan sedikit susu di atasnya'
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
