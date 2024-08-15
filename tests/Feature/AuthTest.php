<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected $token;
    
    
    protected function setUp(): void
    {
        parent::setUp();
       $this->test_register();
    }
    public function test_login(): void
    {
    $loginData = [
        'phone' => '123456789',
        'password' => '123456789',
    ];

    $response = $this->post('api/login', $loginData);
    $response->assertStatus(200);
    $this->token = $response['data'];

}
public function test_register(): void
{
$loginData = [
    'phone' => '123456789',
    'password' => '123456789',
    'name'=>'walaa'
];
$response = $this->post('api/register', $loginData);
$response->assertStatus(200);
$this->token = $response['data'];
$this->assertDatabaseHas('users', [
    'phone' => '123456789',
    // 'password' => '$2y$10$8P1AmohJoRl0V9grWKvA.exiFC4lS.1TtaWX.P9gF8fcN.HpwZpNO',
    'name'=>'walaa'
]);


}






}