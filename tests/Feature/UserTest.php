<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('api/showtransport');
        $response->assertStatus(200);
    }

    public function test_add_transport(): void
    {
        $data = [
            'transport' => 'value1',
        ];
        $response = $this->post('api/Addtransport', $data);
        $response->assertStatus(200);
    }
}
