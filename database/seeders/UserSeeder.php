<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = User::create([
        //     'email' => 'theanh090602@gmail.com',
        //     'password' => bcrypt('anhtran96'),
        // ]);

        $users = User::factory(5) -> create();
    }
}
