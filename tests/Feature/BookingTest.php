<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends AuthTest
{

    protected $time;
    public $id;
    /**
     * A basic feature test example.
     */


    protected function setUp(): void
    {
        parent::setUp();
        $this->test_time();
        $this->test_add_table_reservation();
    }
    public function test_add_table(): void
    {

        $datatable = [
            'sizeId' => 1,
            'number' => 4,
            'type_table' => 1,
        ];


        $response = $this->post('api/table/store', $datatable);
        $response->assertStatus(200);
        for ($i = 0; $i < $datatable['number']; $i++) {
            $this->assertDatabaseHas('tables', [
                'size_id' => 1,
                'type_id' => 1,
            ]);
        }

    }

    public function test_time(): void
    {
        $datatime = [
            'Date' => '2027-7-29',
            'persons' => 7,
            'table_status' => 1,
        ];
        $response = $this->post('api/time', $datatime);
        $response->assertStatus(200);
    }

    public function test_add_reservation(): void
    {
   $datatime = [
            'Date' => '2027-7-29',
            'persons' => 7,
            'table_status' => 1,
            'time_id' => 1,

        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ])->post('api/AddReservation', $datatime);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', [
            'Date' => '2027-7-29',
            'persons' => 7,
            'table_status' => 1,
            'time_id' => 1,
        ]);
    }

    public function test_show_table(): void
    {
        $datatable = [
            'Date' => '2027-7-29',
            'time_id' => 1,
        ];
        $response = $this->post('api/ShowTable', $datatable);
        $response->assertStatus(200);
    }
    public function test_add_table_reservation(): void
    {
        $datatime = [
            'Date' => '2027-7-29',
            'persons' => 7,
            'time_id' => 1,
            'table_id' => [1, 1],
        ];
        $response = $this->post('api/AddTableReservation', $datatime);
        $response->assertStatus(200);
        $this->id = $response['data']['id'];
        $this->assertDatabaseHas('reservations', [
            'Date' => '2027-7-29',
            'persons' => 7,
            'table_status' => 1,
            'time_id' => 1,
        ]);
    }

    public function test_show_reservation(): void
    {

        $response = $this->get('api/ShowallReservation');
        $response->assertStatus(200);


    }
    public function test_show_user_reservation(): void
    {


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ])->post('api/ShowuserReservation', );
        $response->assertStatus(200);
    }
    public function test_edit_table_reservation(): void
    {
        $datatime = [
            'Date' => '2027-7-29',
            'persons' => 7,
            'time_id' => 1,
            'table_id' => [1, 1],
            'id' => $this->id,
        ];
        $response = $this->post('api/EditReservation', $datatime);
        $response->assertStatus(200);
    }

    public function test_delete_reservation(): void
    {
        $datatime = [
            'id' => $this->id,
        ];
        $response = $this->post('api/DeleteReservation', $datatime);
        $response->assertStatus(200);
    }



}

