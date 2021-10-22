<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    protected $table ='system_setting';
    public $timestamps = false;

    //returns the enforce_domain user setting, if there are no system settings then false is returned
    public static function enforceDomain(){
        $systemSetting = SystemSetting::first();
        if(!is_null($systemSetting)){
            return $systemSetting->enforce_domain;
        }
        return false;
        
    }
}
