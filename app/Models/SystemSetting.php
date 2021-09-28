<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    protected $table ='system_setting';
    public $timestamps = false;

    public static function getCompanyLogo(){
        $systemSetting = SystemSetting::all();
        if(count($systemSetting) > 0){
            $systemSetting = $systemSetting->first();
            return $systemSetting->system_logo;
        }
        else return null;
    }
}
