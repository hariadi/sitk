<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateDriverTest extends TestCase
{
    use DatabaseMigrations;

    protected $types = ['Car', 'Bus', 'Van', 'Coaster'];

    protected function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /** @test */
    function guests_may_not_create_drivers()
    {
        $this->withExceptionHandling();
        $this->get('/drivers/create')->assertRedirect('/login');
        $this->post('/drivers')->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_may_not_create_new_drivers()
    {
        $user = create('App\User', ['role_id' => 1]);
        $this->signIn($user);

        $this->get('/drivers/create')
            ->assertRedirect('/drivers')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function an_approver_can_create_new_drivers()
    {
        $this->signIn(create('App\User', ['role_id' => 2]));

        $driver = make('App\Driver');

        $response = $this->post('/drivers', $driver->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($driver->name)
            ->assertSee($driver->email);
    }

    /** @test */
    function an_admin_can_create_new_drivers()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $driver = make('App\Driver');

        $response = $this->post('/drivers', $driver->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($driver->name)
            ->assertSee($driver->email);
    }

    /** @test */
    function a_driver_requires_a_name()
    {
        $this->createDriver(['name' => null])->assertSessionHasErrors('name');
    }

    /** @test */
    function a_driver_requires_a_email()
    {
        $this->createDriver(['email' => null])->assertSessionHasErrors('email');
    }

    /** @test */
    function a_driver_requires_a_phone()
    {
        $this->createDriver(['phone' => null])->assertSessionHasErrors('phone');
    }

    /** @test */
    function unauthorized_users_may_not_update_drivers()
    {
        $this->withExceptionHandling();

        $driver = create('App\Driver');

        $this->get(route('drivers.edit', $driver))->assertRedirect('/login');
        $this->patch(route('drivers.update', $driver))->assertRedirect('/login');
    }

    /** @test */
    function unauthorized_users_may_not_delete_drivers()
    {
        $this->withExceptionHandling();

        $driver = create('App\Driver');

        $this->delete($driver->path())->assertRedirect('/login');

        $this->signIn(create('App\User', ['role_id' => 1]));
        $this->delete($driver->path())
            ->assertStatus(302)
            ->assertRedirect('/drivers')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function approver_may_not_delete_drivers()
    {
        $this->withExceptionHandling();

        $driver = create('App\Driver');

        $this->signIn(create('App\User', ['role_id' => 2]));
        $this->delete($driver->path())
            ->assertStatus(302)
            ->assertRedirect('/drivers')
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function approver_can_update_drivers()
    {
        $this->signIn(create('App\User', ['role_id' => 2]));

        $driver = create('App\Driver');

        $update = [
            'name' => 'Updated Name',
            'phone' => 'Updated Phone',
            'email' => 'updated@email.com',
        ];

        $response = $this->patch('/drivers/' . $driver->id, $update);

        $this->assertDatabaseHas('drivers', $update);

        $this->get($response->headers->get('Location'))
            ->assertSeeText('Pemandu telah dikemaskini!')
            ->assertSee($update['name'])
            ->assertSee($update['phone'])
            ->assertSee($update['email']);
    }

    /** @test */
    function admin_can_update_drivers()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $driver = create('App\Driver');

        $update = [
            'name' => 'Updated Name',
            'phone' => 'Updated Phone',
            'email' => 'updated@email.com',
        ];

        $response = $this->patch(route('drivers.update', $driver), $update);

        $this->assertDatabaseHas('drivers', $update);

        $this->get($response->headers->get('Location'))
            ->assertSeeText('Pemandu telah dikemaskini!')
            ->assertSee($update['name'])
            ->assertSee($update['phone'])
            ->assertSee($update['email']);
    }

    /** @test */
    function admin_can_delete_drivers()
    {
        $this->signIn(create('App\User', ['role_id' => 3]));

        $driver = create('App\Driver');

        $response = $this->json('DELETE', $driver->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('drivers', ['id' => $driver->id]);

        $this->assertEquals(0, Activity::count());
    }

    protected function createDriver($overrides = [])
    {
        $this->withExceptionHandling()->signIn(create('App\User', ['role_id' => 3]));

        $driver = make('App\Driver', $overrides);

        return $this->post('/drivers', $driver->toArray());
    }

}
