<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'سندويش دجاج',
                'category_path' => '/images/category/25.jijf',
                'section_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'سندويش لحم',
                'category_path' => '/images/category/13.jijf',
                'section_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => ' البيتزا',
                'category_path' => '/images/category/27.jfif',
                'section_id' => 2,  // افتراضياً، القسم الثاني
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'الشوربات',
                'category_path' => '/images/category/33.jpeg',
                'section_id' => 2,  // افتراضياً، القسم الثاني
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => ' السلطات',
                'category_path' => '/images/category/38.jpeg',
                'section_id' => 2,  // افتراضياً، القسم الثالث
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
