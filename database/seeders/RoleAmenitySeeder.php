<?php

namespace Database\Seeders;

use App\Models\RoleAmenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleAmenity::create([
            'name' => 'Hotel'
        ]);

        RoleAmenity::create([
            'name' => 'Room'
        ]);

        RoleAmenity::create([
            'name' => 'Airline'
        ]);

        RoleAmenity::create([
            'name' => 'Flight'
        ]);
    }
}
