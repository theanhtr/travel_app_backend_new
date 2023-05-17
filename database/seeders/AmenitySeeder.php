<?php

namespace Database\Seeders;

use App\Helper\GetRoleAmenityIdHelper;
use App\Models\Amenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Amenity::create([
            'name' => 'Free wifi',
            'font_awesome_class' => 'fa-solid fa-wifi',
            'description' => 'Free wifi high speed',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Free breakfast',
            'font_awesome_class' => 'fa-solid fa-utensils',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Non smoking',
            'font_awesome_class' => 'fa-solid fa-ban-smoking',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Non refunable',
            'font_awesome_class' => 'fa-brands fa-creative-commons-nc',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Digital TV',
            'font_awesome_class' => 'fa-regular fa-tv-retro',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Parking Area',
            'font_awesome_class' => 'fa-solid fa-circle-parking',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Swimming Pool',
            'font_awesome_class' => 'fa-solid fa-person-swimming',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);

        Amenity::create([
            'name' => 'Car Rental',
            'font_awesome_class' => 'fa-duotone fa-car',
            'role_amenity_id' => GetRoleAmenityIdHelper::getHotelRoleAmenityId(),
        ]);
    }
}
