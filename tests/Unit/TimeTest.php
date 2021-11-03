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
    public function test_timeInOutValid(){
        $this->assertTrue(Time::isValidInOut('12:34:45', '13:21:34'));
        $this->assertFalse(Time::isValidInOut('09:45:12', '08:12:04'));
    }
}
