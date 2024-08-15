<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
  
    public function run(): void
    {
        DB::table('sections')->insert([
          
            [
                'section_name' => 'قسم السندويش',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section_name' => 'قسم البيتزا',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
