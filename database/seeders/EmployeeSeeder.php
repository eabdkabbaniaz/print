<?php

namespace Database\Seeders;
use App\Models\Employee_transport;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $ahmad = User::create([
            'name'=>'ahmad',
            'phone'=>'0937530961',
            'password'=>bcrypt('123456789'),
        ]);
        
        $ayman = User::create([
            'name'=>'ayman',
            'phone'=>'0937530962',
            'password'=>bcrypt('123456789'),
        ]);
        
        $ali = User::create([
            'name'=>'ali',
            'phone'=>'0937530963',
            'password'=>bcrypt('123456789'),
        ]);
        
        $omar = User::create([
            'name'=>'omar',
            'phone'=>'0937530964',
            'password'=>bcrypt('123456789'),
        ]);

        $waiter = Role::query()->where('name','waiter')->first();
        $delivery = Role::query()->where('name','delivery')->first();

        $casher = Role::query()->where('name','casher')->first();
        $chef = Role::query()->where('name','chef')->first();

        setPermissionsTeamId(1);
        $ahmad->assignRole($waiter);
        $ali->assignRole($delivery);
        $omar->assignRole($casher);
        $ayman->assignRole($chef);
        $waiterpermissions = $waiter->permissions()->pluck('name')->toArray();
        $deliverypermissions = $delivery->permissions()->pluck('name')->toArray();
        $casherpermissions = $casher->permissions()->pluck('name')->toArray();
        $chefpermissions = $ayman->permissions()->pluck('name')->toArray();
        $ahmad->givePermissionTo($waiterpermissions);
        $ahmad->load('roles', 'permissions'); //to recognize the permissions
        $ali->givePermissionTo($deliverypermissions);
        $ali->load('roles', 'permissions'); //to recognize the permissions
        $omar->givePermissionTo($casherpermissions);
        $omar->load('roles', 'permissions'); //to recognize the permissions
        $ayman->givePermissionTo($chefpermissions);
        $ayman->load('roles', 'permissions'); //to recognize the permissions









        DB::table('employees')->insert([
            [
                'active' => true,
                'address' => '123 Main St, Cityville',
                'user_id' => 1, // Ensure this user exists in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'active' => true,
                'address' => '456 Oak Ave, Townsville',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'active' => false,
                'address' => '789 Pine Rd, Villageburg',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'active' => true,
                'address' => '321 Maple Ln, Hamletton',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        Employee_transport::Create([
            'employee_id' =>4 ,
            'transport_id' => 1
          ]);


    }







    }

