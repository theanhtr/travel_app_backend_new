<?php

namespace Database\Seeders;

use App\Helper\GetRoleIdHelper;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Role;

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

        $admin = User::create([
            'email' => 'theanh090602@gmail.com',
            'password' => bcrypt('anhtran96'),
            'role_id' => GetRoleIdHelper::getAdminRoleId(),
        ]);

        $admin -> information() -> create([
            'first_name' => 'Tran',
            'last_name' => 'The Anh',
            'phone_number' => '0912945494',
            'date_of_birth' => Carbon::createFromFormat('Y-m-d H:i:s', '2002-06-09 10:15:30'),
            'email_contact' => 'trtheanh96@gmail.com'
        ]);

        $users = User::factory(5) -> create();
    }
}
