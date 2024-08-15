<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transports')->insert([
            [
                'transport' => 'car',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'transport' => 'Bicycle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transport' => 'motor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
