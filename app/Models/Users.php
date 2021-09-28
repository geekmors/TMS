<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Users extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    public function settings(){
        return $this->hasOne(UserSetting::class,'user_id','id');
    }
    public function role(){
        return $this->hasOne(Role::class,'role_id','id');
    }
    public $timestamps = false;
}
