<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Time;

class TimeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_timelogForUser()
    {
        $entries = Time::getAllForUser(1);
        $this->assertTrue(count($entries) > 0);
    }
}
