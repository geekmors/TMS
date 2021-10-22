<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SystemSetting;

class SystemSettingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_firstSetting()
    {
        $setting = SystemSetting::first();
        if(!$setting->enforce_domain){
            $this->assertFalse(false);
        }
        print($setting->enforce_domain);
    }
    public function test_enforceDomain()
    {
        $setting = SystemSetting::where('id','=','40')->first();
        $this->assertTrue(is_null($setting));
        $this->assertTrue(SystemSetting::enforceDomain()==0);
    }
}
