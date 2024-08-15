<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MenuTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // public function test_menu(): void
    // {
    // //     $dataSection= [
    // //         'section_name' => 'pizza',
    // //         'status'=>'1'
    // //     ];
    // //    $response = $this->post('api/AddSection', $dataSection);
    //     $dataCategory= [
    //         'section_id' => 1,
    //         'name'=>'pizza',
    //         'photo'=>'C:\Users\vision\Pictures\crestiano.bmp',
    //     ];
    //     $response = $this->post('api/AddCategory', $dataCategory);



    //    // $response->assertStatus(200);
    //     $response->assertStatus(200);
    // }
    public function test_menu(): void
    {
        $dataSection = [
            'section_name' => 'pizza',
            'status' => '1'
        ];
        $responseSection = $this->post('api/AddSection', $dataSection);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('aaa.jpg');

        $dataCategory = [
            'section_id' => $responseSection['data']['id'],
            'category_name' => 'pizza',
            'photo' => $file,
        ];
        $responseCategory = $this->post('api/AddCategory', $dataCategory);
        $imageProduct= UploadedFile::fake()->image('aaa.jpg');

        $dataprodct = [
            'category_id' => $responseCategory['data']['id'], // تأكد من أن هذا معرف صالح للفئة
            'name' => 'pizza',
            'photo' => $imageProduct,
            'product_information' => 'Some information about the product',
            'price' => 12.99, // تأكد من أن السعر هو قيمة عددية صحيحة
            'calories' => 250, // تأكد من أن السعرات الحرارية هي قيمة عددية صحيحة
        ];
      
       

        $responseProduct = $this->post('api/Addproduct', $dataprodct);
        // dd($responseProduct );

        $dataOffer = [
            'name' => 'pizza',
            'total_price' => 1,
            'start_datetime' => '2024-06-27 11:27:00',
            'end_datetime' => '2024-06-28 11:47:00',
            'offers' => [
                ['product_id' => $responseProduct['data']['id'], 'amount' => 4],
                ['product_id' => $responseProduct['data']['id'], 'amount' => 8],
                ['product_id' => $responseProduct['data']['id'], 'amount' => 5],
            ],];

        $responseoffer = $this->post('api/offers/store', $dataOffer);
        $dataOrder = [
            'notes' => 'pizza',
            'offers' => [
                ['offer_id' => $responseoffer['data']['id'], 'amount' => 4],
            ],
            'products' => [
                ['product_id' => $responseProduct['data']['id'], 'amount' => 4 ,'price_per_one'=>4],
      
            ],
        ];

        $response = $this->post('api/orderLocal/store', $dataOrder);
// dd($response);

        $responseProduct->assertStatus(200);

    }

 

}
