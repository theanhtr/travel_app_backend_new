<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(RoleImageSeeder::class);
        $this->call(RoleAmenitySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(SortBySeeder::class);
    }
}
