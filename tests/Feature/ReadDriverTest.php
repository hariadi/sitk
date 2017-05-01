<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadDriverTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->driver = factory('App\Driver')->create();
        $this->be($user = factory('App\User')->create());
    }

    /** @test */
    public function an_authenticated_user_can_view_all_drivers()
    {
        $response = $this->get('/drivers')
            ->assertSee($this->driver->name)
            ->assertSee($this->driver->email)
            ->assertSee($this->driver->phone);
    }

    /** @test */
    public function an_authenticated_user_can_view_single_driver()
    {
        $response = $this->get('/drivers/' . $this->driver->id)
            ->assertSee($this->driver->name)
            ->assertSee($this->driver->email)
            ->assertSee($this->driver->phone);
    }
}
