<?php

namespace Database\Seeders;

use App\Models\RoleImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleImage::create([
            'name' => 'Avatar'
        ]);

        RoleImage::create([
            'name' => 'Tourist Attraction'
        ]);

        RoleImage::create([
            'name' => 'Hotel'
        ]);

        RoleImage::create([
            'name' => 'Hotel Room'
        ]);

        RoleImage::create([
            'name' => 'Rating'
        ]);

        RoleImage::create([
            'name' => 'Airline'
        ]);

        RoleImage::create([
            'name' => 'Airline Aircraft'
        ]);

        RoleImage::create([
            'name' => 'Airline Flight'
        ]);
    }
}
