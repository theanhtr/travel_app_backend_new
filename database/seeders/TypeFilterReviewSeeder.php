<?php

namespace Database\Seeders;

use App\Models\TypeFilterReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeFilterReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeFilterReview::create(['name' => 'All']);
        TypeFilterReview::create(['name' => 'With Comment']);
        TypeFilterReview::create(['name' => 'With Photos']);
    }
}
