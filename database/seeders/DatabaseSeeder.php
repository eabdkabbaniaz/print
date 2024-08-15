<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        $this->call([
            TransportSeeder::class,
            SectionSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            RolePermissionsSeeder::class,
            OrderTypeSeeder::class,
            TypeTable::class,
            TimesTableSeeder::class,
            TablesizesSeeder::class,
            TablesSeeder::class,
            EmployeeSeeder::class,
            AddressSeeder::class,
            SettingSeeder::class
        ]);
       

    }
}
