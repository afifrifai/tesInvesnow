<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Super Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'komda',
                'display_name' => 'KOMDA',
                'description' => 'Can access limited features!'
            ],
            [
                'name' => 'pengurus',
                'display_name' => 'Pengurus',
                'description' => 'Can access limited features!'
            ],
            [
                'name' => 'anggota',
                'display_name' => 'anggota',
                'description' => 'Can access limited features!'
            ],
        ];

        foreach ($roles as $key => $value) {
            $role = Role::create([
                'name' => $value['name'],
                'display_name' => $value['display_name'],
                'description' => $value['description']
            ]);

            User::first()->attachRole($role);
        }
    }
}
