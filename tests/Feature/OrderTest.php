<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function OrderLocal()
    {
        $dataOrder = [
            'section_name' => 'pizza',
            'status' => '1'
        ];
        $response = $this->post('api/AddSection', $dataOrder);
    }
}
