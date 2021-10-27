<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;
    protected $table ='time';
    public $timestamps = false;

    static public function getAllForUser($userId){
        return Time::all()->where('users_id','=', $userId);        
    }
    public function getRegularHours($totalTime){

    }
    public function getOverTimeHours($totalTime){

    }
    public function sumHoursWorkedForDate($dateWorked){

    }
    public function newEntry($userId, $data){
        $this->users_id = $userId;
        $this->date_worked = $data["entry_date"];
        $this->entry = $data["entry_name"];
        $this->time_in = $data["entry_start_time"].':00';
        $this->time_out = $data["entry_end_time"].':00';
        $this->total_hours = $data["entry_elapsed_time"];
        
        return $this;
    }
}
