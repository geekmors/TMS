<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Users;

class UsersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_example()
    {
        $user = Users::first();
        if(!$user){

            $this->assertTrue(true);
        }
        else{
            $this->assertTrue(false);
        }
    }
}
