<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'WebMaster',
            'menu' => 'webmaster'
        ]);

        Role::create([
            'name' => 'WebManager',
            'menu' => 'webmanager'
        ]);

        Role::create([
            'name' => 'Admin',
            'menu' => 'admin'
        ]);

        Role::create([
            'name' => 'User',
            'menu' => 'user'
        ]);
    }
}
