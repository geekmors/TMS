<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\DomainList;

class DomainListTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_contains()
    {
       //$this->assertTrue(!is_null(DomainList::first()));
        
        if(DomainList::contains('gmail.com'))
            $this->assertTrue(true); 
        else if(!DomainList::contains('ksm.com'))
            $this->assertFalse(false);
        $this->assertTrue(DomainList::contains('ksm.com'));
    }
}
