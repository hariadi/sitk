<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PemohonTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $user = factory('App\User')->create(['role_id' => 1]);
        $this->be($user);
        $this->reservation = factory('App\Reservation')->create(['user_id' => $user->id]);
    }

    /** @test */
    public function it_show_reservations_dashboard()
    {
        $this->get('/dashboard')
            ->assertSee(auth()->user()->name)
            ->assertSeeText('Tempahan Baru')
            ->assertSeeText('Senarai Permohonan')
            ->assertSeeText('Status Tempahan')
            ->assertSeeText('Dalam Tindakan')
            ->assertSeeText('Lulus')
            ->assertSeeText('Ditolak');
    }

    /** @test */
    public function it_only_show_their_reservations()
    {
        $secondReservation = factory('App\Reservation')->create(['user_id' => auth()->id()]);
        $otherReservation = factory('App\Reservation')->create();

        $this->get('/dashboard')
            ->assertSee($this->reservation->reason)
            ->assertSee($secondReservation->reason)
            ->assertDontSee($otherReservation->reason);
    }

    /** @test */
    public function it_may_not_show_other_authorized_user_reservations()
    {
        $this->withExceptionHandling();
        $otherUser = factory('App\User')->create(['role_id' => 1]);
        $otherReservation = factory('App\Reservation')->create(['user_id' => $otherUser->id]);

        $this->get(route('reservations.show', $otherReservation))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    public function it_may_not_edit_other_authorized_user_reservations()
    {
        $this->withExceptionHandling();
        $otherUser = factory('App\User')->create(['role_id' => 1]);
        $otherReservation = factory('App\Reservation')->create(['user_id' => $otherUser->id]);

        $this->get($otherReservation->path())
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    public function it_may_not_update_other_authorized_user_reservations()
    {
        $this->withExceptionHandling();
        $otherUser = factory('App\User')->create(['role_id' => 1]);
        $otherReservation = factory('App\Reservation')->create(['user_id' => $otherUser->id]);

        $update = [
            'reason' => 'User make update'
        ];

        $this->patch($otherReservation->path(), $update)
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('flash_warning');
    }

    /** @test */
    public function it_may_not_delete_other_authorized_user_reservations()
    {
        $this->withExceptionHandling();

        $otherUser = factory('App\User')->create(['role_id' => 1]);
        $otherReservation = factory('App\Reservation')->create(['user_id' => $otherUser->id]);

        $this->json('DELETE', $otherReservation->path())
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('flash_warning');
    }
}
