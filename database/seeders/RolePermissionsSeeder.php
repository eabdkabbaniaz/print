<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\User;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create roles:
        $customerRole = Role::create(['name' => 'customer', 'team_id' => 1]);
        $waiterRole   = Role::create(['name' => 'waiter', 'team_id' => 1]);
        $casherRole   = Role::create(['name' => 'casher', 'team_id' => 1]);
        $deliveryRole = Role::create(['name' => 'delivery', 'team_id' => 1]);
        $managerRole  = Role::create(['name' => 'manager', 'team_id' => 1]);
        $chefRole     = Role::create(['name' => 'chef', 'team_id' => 1]);

        // Guard name should match

        //define permissions: 
        $permissions = [
            'register',
            'login'
        ];
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }


        // $permissions = Permission::pluck('id', 'id')->all();
        $customerRole->givePermissionTo(['register', 'login']);
        $casherRole->givePermissionTo(['register']);
        $managerRole->givePermissionTo(['register']);
        $waiterRole   = Role::create(['name' => 'waiter', 'team_id' => 1, 'guard_name' => 'api']);




        //create manage account:

        $managerUser = User::create([
            'name' => 'walaa rehawi',
            'phone' => '0937530968',
            'password' => bcrypt('123456789'),
        ]);
        // dd("jkll");        
        //give manager rule
        setPermissionsTeamId(1);
        $managerUser->assignRole('waiter'); // تأكد من استخدام نفس الحارس 'web'
        // give manager permission 



    }
}
