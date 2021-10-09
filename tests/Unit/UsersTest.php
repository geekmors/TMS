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
    public function test_user_settings(){
        $user = Users::first();
        
        $this->assertFalse(is_null($user));
        $this->assertTrue(!is_null($user->settings()));
        $this->assertTrue($user->settings()->is_enabled == 1);
    }
    public function test_user_role(){
        $user = Users::first();
        $this->assertFalse(is_null($user));
        $this->assertTrue(!is_null($user->role()));
        $this->assertTrue($user->role()->description == 'admin');
    }
}
