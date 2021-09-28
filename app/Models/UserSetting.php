<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $table ='user_setting';
    public $timestamps = false;

    public function createDefault($userId, $avatar){
        $this->users_id = $userId;
        $this->dark_theme = false;
        $this->avatar = $avatar;
        $this->avatar_original = $this->avatar;
        $this->is_enabled = true;
        // set below user settings to default
        $this->typography_size_id = 1;
        $this->time_format_id = 1;
        //-------- 
        return $this;
    }
}
