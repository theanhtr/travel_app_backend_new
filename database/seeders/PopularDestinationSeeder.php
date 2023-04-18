<?php

namespace Database\Seeders;

use App\Models\PopularDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopularDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopularDestination::create([
            'province_id' => 1,
            'image_path' => 'ha_noi.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 2,
            'image_path' => 'ha_giang.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 22,
            'image_path' => 'quang_ninh.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 79,
            'image_path' => 'hcm_city.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 46,
            'image_path' => 'hue.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 56,
            'image_path' => 'nha_trang.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 49,
            'image_path' => 'hoi_an.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 48,
            'image_path' => 'da_nang.jpg'
        ]);
    }
}
