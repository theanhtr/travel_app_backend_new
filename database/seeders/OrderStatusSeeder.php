<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create(['name' => 'Unpaid']);
        OrderStatus::create(['name' => 'Paid']);
        OrderStatus::create(['name' => 'Processing']);
        OrderStatus::create(['name' => 'Completed']);
        OrderStatus::create(['name' => 'Cancelled']);
        OrderStatus::create(['name' => 'Pending']);
        OrderStatus::create(['name' => 'Converted']);
        OrderStatus::create(['name' => 'Awaiting Feedback']);
        OrderStatus::create(['name' => 'Under Development']);
        OrderStatus::create(['name' => 'Error']);

    }
}
