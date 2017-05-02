<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateVehicleTest extends TestCase
{
    use DatabaseMigrations;

    protected $types = ['Car', 'Bus', 'Van', 'Coaster'];

    protected function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /** @test */
    function guests_may_not_create_vehicles()
    {
        $this->withExceptionHandling();
        $this->get('/vehicles/create')->assertRedirect('/login');
        $this->post('/vehicles')->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_may_not_create_new_vehicles()
    {
        $user = create('App\User', ['role_id' => 1]);
        $this->signIn($user);

        $this->get('/vehicles/create')
            ->assertRedirect('/vehicles')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function an_approver_can_create_new_vehicles()
    {
        $this->signIn(create('App\User', ['role_id' => 2]));

        $vehicle = make('App\Vehicle');

        $response = $this->post('/vehicles', $vehicle->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($vehicle->model)
            ->assertSee($vehicle->types);
    }

    /** @test */
    function an_admin_can_create_new_vehicles()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $vehicle = make('App\Vehicle');

        $response = $this->post('/vehicles', $vehicle->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($vehicle->model)
            ->assertSee($vehicle->types);
    }

    /** @test */
    function a_vehicle_requires_a_registration_no()
    {
        $this->createVehicle(['registration_no' => null])->assertSessionHasErrors('registration_no');
    }

    /** @test */
    function a_vehicle_requires_a_types()
    {
        $this->createVehicle(['types' => null])->assertSessionHasErrors('types');
    }

    /** @test */
    function a_vehicle_requires_a_capacity()
    {
        $this->createVehicle(['capacity' => null])->assertSessionHasErrors('capacity');
    }

    /** @test */
    function unauthorized_users_may_not_update_vehicles()
    {
        $this->withExceptionHandling();

        $vehicle = create('App\Vehicle');

        $this->delete($vehicle->path())->assertRedirect('/login');

        $this->signIn(create('App\User', ['role_id' => 1]));
        $this->delete($vehicle->path())
            ->assertStatus(302)
            ->assertRedirect('/vehicles')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function unauthorized_users_may_not_delete_vehicles()
    {
        $this->withExceptionHandling();

        $vehicle = create('App\Vehicle');

        $this->delete($vehicle->path())->assertRedirect('/login');

        $this->signIn(create('App\User', ['role_id' => 1]));
        $this->delete($vehicle->path())
            ->assertStatus(302)
            ->assertRedirect('/vehicles')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function approver_may_not_delete_vehicles()
    {
        $this->withExceptionHandling();

        $vehicle = create('App\Vehicle');

        $this->delete($vehicle->path())->assertRedirect('/login');

        $this->signIn(create('App\User', ['role_id' => 2]));
        $this->delete($vehicle->path())
            ->assertStatus(302)
            ->assertRedirect('/vehicles')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function approver_can_update_vehicles()
    {
        $this->signIn(create('App\User', ['role_id' => 2]));

        $vehicle = create('App\Vehicle');

        $update = [
            'model' => 'User make update to Model'
        ];

        $response = $this->patch($vehicle->path(), array_replace($vehicle->toArray(), $update));

        $this->assertDatabaseHas('vehicles', $update);

        $this->get($response->headers->get('Location'))
            //->assertSessionHas('flash_success')
            ->assertSee($update['model']);
    }

    /** @test */
    function admin_can_update_vehicles()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $vehicle = create('App\Vehicle');

        $update = [
            'model' => 'User make update to Model'
        ];

        $response = $this->patch(route('vehicles.update', $vehicle), array_replace($vehicle->toArray(), $update));

        $this->assertDatabaseHas('vehicles', $update);

        $this->get($response->headers->get('Location'))
            ->assertSee($update['model']);
    }

    /** @test */
    function admin_can_delete_vehicles()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $vehicle = create('App\Vehicle');

        $response = $this->json('DELETE', $vehicle->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('vehicles', ['id' => $vehicle->id]);

        $this->assertEquals(0, Activity::count());
    }

    protected function createVehicle($overrides = [])
    {
        $this->withExceptionHandling()->signIn(create('App\User', ['role_id' => 3]));

        $vehicle = make('App\Vehicle', $overrides);

        return $this->post('/vehicles', $vehicle->toArray());
    }

}
