<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateReservationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /** @test */
    function guests_may_not_create_reservations()
    {
        $this->withExceptionHandling();
        $this->get('/reservations/create')->assertRedirect('/login');
        $this->post('/reservations')->assertRedirect('/login');
    }

    /** @test */
    function a_reservation_requires_a_reason()
    {
        $this->createResevation(['reason' => null])->assertSessionHasErrors('reason');
    }

    /** @test */
    function a_reservation_requires_a_destination()
    {
        $this->createResevation(['destination' => null])->assertSessionHasErrors('destination');
    }

    /** @test */
    function a_reservation_requires_a_start_at()
    {
        $this->createResevation(['start_at' => null])->assertSessionHasErrors('start_at');
    }

    /** @test */
    function a_reservation_requires_an_end_at()
    {
        $this->createResevation(['end_at' => null])->assertSessionHasErrors('end_at');
    }

    /** @test */
    function unauthorized_users_may_not_delete_reservations()
    {
        $this->withExceptionHandling();

        $reservation = create('App\Reservation');

        $this->delete($reservation->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($reservation->path())
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    function authorized_users_can_update_reservations()
    {
        $this->signIn();

        $reservation = create('App\Reservation', ['user_id' => auth()->id()]);

        $update = [
            'reason' => 'User make update'
        ];

        $response = $this->patch($reservation->path(), array_replace($reservation->toArray(), $update));

        $this->assertDatabaseHas('reservations', $update);

        $this->get($response->headers->get('Location'))->assertSee($update['reason']);
    }

    /** @test */
    function authorized_users_can_delete_reservations()
    {
        $this->signIn();

        $reservation = create('App\Reservation', ['user_id' => auth()->id()]);

        $response = $this->json('DELETE', $reservation->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);

        $this->assertEquals(0, Activity::count());
    }

    protected function createResevation($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $reservation = make('App\Reservation', $overrides+['user_id' => auth()->id()]);

        $inputs = array_replace($reservation->toArray(), $overrides);

        return $this->post(route('reservations.store'), $inputs);
    }

}
