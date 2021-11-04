<?php

namespace App\Models;
use Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\TimeHelper;


class Time extends Model
{
    use HasFactory;
    protected $table ='time';
    public $timestamps = false;

    static public function getAllForUser($userId){
        return Time::where('users_id','=', $userId)->get();        
    }
    
    
    public function updateEntry($data){
        
        $this->date_worked = $data["entry_date"];
        $this->entry = $data["entry_name"];
        $this->total_hours = $data["entry_elapsed_time"];
        $this->time_in = $data["entry_start_time"];
        $this->time_out = $data["entry_end_time"];

        return $this;
    }
    public function newEntry($userId, $data){
        $this->users_id = $userId;
        $this->date_worked = $data["entry_date"];
        $this->entry = $data["entry_name"];
        $this->time_in = $data["entry_start_time"];
        $this->time_out = $data["entry_end_time"];
        $this->total_hours = $data["entry_elapsed_time"];
        
        return $this;
    }
    
    static public function getSummaryFromEntryQuerySet($entries){
        /**
         * Creates the below data structure:
         * 'YYYY-MM-DD'=>[
         *          "date"=>"YYYY-MM-DD", 
         *          "total_hours"=>"00:00:00", 
         *          "ot_hours":"00:00:00", 
         *          "reg_hours"=>"00:00:00", 
         *          "entries"=>[
         *              ["id"=>0, "date_worked"=>"YYYY-MM-DD" "users_id"=>id, "time_in"=>"00:00:00", "time_out"=>"00:00:00", "total_hours"=>"00:00:00", "entry"=>"entry name"],
         *              ...
         *          ]
         *      ],
         *      ...
         */
        $entrySummaryList = array();
        $timeHelper = new TimeHelper;

        foreach($entries as $entry){
            $entrySummaryList[$entry->date_worked]["entries"][] = $entry;
            $entrySummaryList[$entry->date_worked]["date"] = $entry->date_worked;
            $entrySummaryList[$entry->date_worked]["total_hours"] = $timeHelper->sumHours( 
                    $entry->total_hours, 
                    $entrySummaryList[$entry->date_worked]["total_hours"] ?? "00:00:00"
            );
            $entrySummaryList[$entry->date_worked]["ot_hours"] = $timeHelper->getOverTimeHours( $entrySummaryList[$entry->date_worked]["total_hours"]);
            $entrySummaryList[$entry->date_worked]["regular_hours"] = $timeHelper->getRegularHours( $entrySummaryList[$entry->date_worked]["total_hours"]);

        } 

        return $entrySummaryList;
    }
    static public function getTimeEntryDataFor($query_params){
        
        $entries = Time::where("users_id", "=" , $query_params["user_id"])
                        ->whereBetween("date_worked", [$query_params["from"], $query_params["to"]])
                        ->orderBy("date_worked",$query_params["sort_date"])
                        ->orderBy("time_in", $query_params["sort_timeIn"])
                        ->get();
        
        
        if(is_null($entries)) return false;

        $entrySummary = Time::getSummaryFromEntryQuerySet($entries);
        return $entrySummary;
    }
}
