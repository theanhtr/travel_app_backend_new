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
            'province_id' => 40,
            'popular_destination_name'=>'Cửa Lò',
            'district_id' => 413,
            'image_path' => 'cua_lo.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 68,
            'district_id' => 672,
            'popular_destination_name'=>'Đà Lạt',
            'image_path' => 'da_lat.webp'
        ]);

        PopularDestination::create([
            'province_id' => 48,
            'district_id' => null,
            'popular_destination_name'=>'Đà Nẵng',
            'image_path' => 'da_nang.webp'
        ]);

        PopularDestination::create([
            'province_id' => 2,
            'district_id' => null,
            'popular_destination_name'=>'Hà Giang',
            'image_path' => 'ha_giang.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 22,
            'district_id' => 193,
            'popular_destination_name'=>'Hạ Long',
            'image_path' => 'ha_long.webp'
        ]);

        PopularDestination::create([
            'province_id' => 1,
            'district_id' => null,
            'popular_destination_name'=>'Hà Nội',
            'image_path' => 'ha_noi.webp'
        ]);

        PopularDestination::create([
            'province_id' => 79,
            'district_id' => null,
            'popular_destination_name'=>'TP Hồ Chí Minh',
            'image_path' => 'ho_chi_minh.webp'
        ]);

        PopularDestination::create([
            'province_id' => 49,
            'district_id' => 503,
            'popular_destination_name'=>'Hội An',
            'image_path' => 'hoi_an.webp'
        ]);

        PopularDestination::create([
            'province_id' => 46,
            'district_id' => null,
            'popular_destination_name'=>'Thừa Thiên Huế',
            'image_path' => 'hue.webp'
        ]);

        PopularDestination::create([
            'province_id' => 14,
            'district_id' => 123,
            'popular_destination_name'=>'Mộc Châu',
            'image_path' => 'moc_chau.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 56,
            'district_id' => 568,
            'popular_destination_name'=>'Nha Trang',
            'image_path' => 'nha_trang.webp'
        ]);

        PopularDestination::create([
            'province_id' => 60,
            'district_id' => 593,
            'popular_destination_name'=>'Phan Thiết',
            'image_path' => 'phan_thiet.webp'
        ]);

        PopularDestination::create([
            'province_id' => 44,
            'district_id' => 455,
            'popular_destination_name'=>'Phong Nha Kẻ Bàng',
            'image_path' => 'phong_nha_ke_bang.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 91,
            'district_id' => 911,
            'popular_destination_name'=>'Phú Quốc',
            'image_path' => 'phu_quoc.webp'
        ]);

        PopularDestination::create([
            'province_id' => 52,
            'district_id' => 540,
            'popular_destination_name'=>'Quy Nhơn',
            'image_path' => 'quy_nhon.webp'
        ]);

        PopularDestination::create([
            'province_id' => 38,
            'district_id' => 382,
            'popular_destination_name'=>'Sầm Sơn',
            'image_path' => 'sam_son.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 10,
            'district_id' => 88,
            'popular_destination_name'=>'Sa Pa',
            'image_path' => 'sapa.jpg'
        ]);

        PopularDestination::create([
            'province_id' => 37,
            'district_id' => null,
            'popular_destination_name'=>'Tràng An',
            'image_path' => 'trang_an.jpeg'
        ]);

        PopularDestination::create([
            'province_id' => 77,
            'district_id' => 747,
            'popular_destination_name'=>'Vũng Tàu',
            'image_path' => 'vung_tau.webp'
        ]);
    }
}
