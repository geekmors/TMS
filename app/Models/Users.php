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
    public function createUser($user, $role_id=3){
        $this->first_name = $user->user["given_name"];
        $this->last_name = $user->user["family_name"];
        $this->email = $user->user["email"];
        $this->google_id = $user->id;
        $this->timestamp_lastlogin = date('Y-m-d H:i:s');
        $this->role_id = $role_id; // 1->admin; 3->employee
        return $this;

    }
    public $timestamps = false;
}
