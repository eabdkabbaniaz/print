<?php

namespace Database\Seeders;

use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurant::create([
            'name' => 'superstar',
            'start' => '2024-08-14 12:00:00',
            'end' => '2024-08-14 20:14:00',
            'status' => true,
        ]);



        Setting::create([
            'name' => 'Reservation',
            'status' => true,
        ]);
        Setting::create([
            'name' => 'payment',
            'status' => true,
        ]);


    }
}
