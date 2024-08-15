<?php

namespace Database\Seeders;
use App\Models\Transport;
use Illuminate\Support\Facades\DB;

use App\Models\Address\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$cites =[
    'الميدان',
    'المرجة',
    'الصالحية',
    'الجسر الأبيض',
    'المزرعة',
    'القابون',
    'المزة',
    'الشاغور',
    'التجارة',
    'العباسيين',
    'ركن الدين',
    'برزة',
    'جوبر',
    'العدوي',
    'كفرسوسة',
    'المهاجرين',
    'المهاجرين العليا',
    'المهاجرين السفلى',
    'ساروجة',
    'القصاع',
    'باب توما',
    'باب شرقي',
    'الزبلطاني',
    'الشيخ محي الدين',
    'الشيخ خالد',
    'دمر',
    'دمر البلد',
    'قدسيا',
    'أبو رمانة',
    'المزرعة',
    'مشروع دمر',
    'أوتوستراد المزة',
    'أوتوستراد المزة جبل',
    'باب سريجة',
    'القنوات',
    'الميدان الوسطاني',
    'الميدان التحتاني',
    'القدم',
    'العسالي',
    'نهر عيشة',
    'عين كرش',
    'المنطقة الصناعية',
    'الحريقة',
    'السويقة',
    'بستان الدور',
    'بستان القصر',
    'المهاجرين الجديدة',
    'القصور',
    'ركن الدين الجديدة',
    'ركن الدين القديمة',
    'الشيخ سعد',
    'المزة 86',
    'مزة جبل',
    'الرازي',
    'الشريبيشات',
    'مزة فيلات',
    'مزة فيلات غربية',
    'حي الورود',
    'حي الطيران',
    'مشروع الفاروق',
    'مشروع الأوقاف',
    'مشروع الزاهرة',
    'الزاهرة',
    'الزاهرة القديمة',
    'الزاهرة الجديدة',
    'الزاهرة شرقية',
    'الزاهرة غربية',
    'الشيخ ظاهر',
    'المزرعة',
    'مشروع الجزيرة',
    'حي الورود',
    'جادات الميدان',
    'السبع بحرات',
    'التكية السليمانية',
    'الحميدية',
    'سوق الصاغة',
    'سوق الطويل',
    'السويقة',
    'سوق مدحت باشا',
    'الشام الجديدة',
    'الروضة',
    'السومرية',
    'الشيخ سعد',
    'الشيخ طه',
    'الشريبيشات',
    'البرامكة',
    'المزيرعة',
    'العدوي',
    'القابون',
    'جوبر',
    'عين ترما',
    'القدم',
    'اليرموك',
    'التضامن',
    'الحجر الأسود',
    'مخيم فلسطين',
    'الميدان الأوسط',
    'الميدان الشمالي',
    'الميدان التحتاني',
    'الميدان الجديد',
    'الكسوة',
    'سبينة',
    'جرمانا',
    'صحنايا',
    'داريا'
  ];
foreach($cites as $city){
        Address::create([
            'name' => $city,
            // 'parent_id' => $ParentId
        ]);
    }



    
      $transports = Transport::all();

      foreach ($cites as $city) {
          foreach ($transports as $transport) {
              DB::table('transportation_costs')->insert([
                  'transport_id' => $transport->id,
                  'city_id' => $this->getCityIdByName($city), // Assuming you have a method to get city ID by name
                  'cost' => $this->generateRandomCost(), // Generate a random cost for demonstration purposes
                  'created_at' => now(),
                  'updated_at' => now(),
              ]);
          }
      }
  }

  /**
   * Assuming there is a method to get city_id by name
   */
  private function getCityIdByName($cityName)
  {
      return DB::table('addresses')->where('name', $cityName)->value('id');
  }

  private function generateRandomCost()
  {
      return rand(100, 1000); // Example: random cost between 100 and 1000
  }
}