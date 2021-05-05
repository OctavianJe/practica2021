<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminSeeder
 *
 * @package Database\Seeders
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();

        $admin->name = 'Admin';
        $admin->email = 'admin@admin.ro';
        $admin->password = Hash::make('parola');
        $admin->role = User::ROLE_ADMIN;
        $admin->email_verified_at = now();

        $admin->save();
    }
}
