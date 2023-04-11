<?php

namespace Database\Seeders;

use App\Models\SortBy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SortBySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SortBy::create(['name' => 'Lowest Price', 'type' => 1]);
        SortBy::create(['name' => 'Highest Price', 'type' => 1]);
        SortBy::create(['name' => 'Highest Rating', 'type' => 1]);
        SortBy::create(['name' => 'Nearest Distance', 'type' => 1]);

        SortBy::create(['name' => 'Earliest Departure', 'type' => 2]);
        SortBy::create(['name' => 'Latest Departure', 'type' => 2]);
        SortBy::create(['name' => 'Earliest Arrive', 'type' => 2]);
        SortBy::create(['name' => 'Latest Arrive', 'type' => 2]);
        SortBy::create(['name' => 'Shortest Duration', 'type' => 2]);
        SortBy::create(['name' => 'Lowest Price', 'type' => 2]);
        SortBy::create(['name' => 'Highest Price', 'type' => 2]);

    }
}
