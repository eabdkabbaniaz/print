<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Enums\RoleType;
use App\Enums\PermissionType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      


        $roles = RoleType::getAll();
        

      

        foreach ($roles as $item) {
            $role = Role::create(['name' => $item]);

        }
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gamil.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole(RoleType::ADMIN);
    }
}
