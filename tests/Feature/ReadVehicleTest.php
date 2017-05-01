<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadVehicleTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->vehicle = factory('App\Vehicle')->create();
        $this->be($user = factory('App\User')->create());
    }

    /** @test */
    public function an_authenticated_user_can_view_all_vehicles()
    {
        $response = $this->get('/vehicles')
            ->assertSee($this->vehicle->model)
            ->assertSee($this->vehicle->types);
    }

    /** @test */
    function an_authenticated_user_can_filter_vehicles_by_any_types()
    {
        $car = create('App\Vehicle', ['types' => 'Car']);
        $van = create('App\Vehicle', ['types' => 'Van']);

        $this->get('vehicles?types=Car')
            ->assertSee($car->types)
            ->assertDontSee($van->types);
    }

    /** @test */
    public function an_authenticated_user_can_view_single_vehicle()
    {
        $response = $this->get('/vehicles/' . $this->vehicle->id)
            ->assertSee($this->vehicle->model)
            ->assertSee($this->vehicle->types);
    }
}
