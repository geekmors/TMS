<?php

namespace App\Models;
use Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
    
    static public function reportAll($query_params){
        // get report data
        $rawSelect = `
            time.date_worked as 'date_worked',
            users.first_name ,
            users.last_name,
            sec_to_time(SUM(time_to_sec(time.total_hours))) as 'total_hours'
        `;
        $report = Time::selectRaw('date_worked, users.first_name, users.last_name, sec_to_time(SUM(time_to_sec(total_hours))) as total_hours')
            ->join("users", "users.id", "=", "time.users_id")
            ->whereBetween('date_worked',[$query_params["from_date"], $query_params["to_date"]])
            ->groupBy("date_worked")
            ->groupBy("users_id")
            ->groupBy("first_name")
            ->groupBy("last_name")
            ->orderBy("date_worked", $query_params["sort_date"])
            ->orderBy("total_hours", $query_params["sort_hours"])
            ->orderBy("users.last_name", $query_params["sort_name"])
            ->orderBy("users.first_name", $query_params["sort_name"])
            ->get();
        
        // if no data exists then send empty array.
        if(is_null($report)) return [];
        
        // format report data
        $report = Time::formatAllUserReport($report);

        return $report;
        // return report data
    }
    static public function formatAllUserReport($data){
        
        $reformated = [];
        $timeHelper = new TimeHelper;

        foreach($data as $row){
            $reformated[]= [
                "date" => $row->date_worked,
                "name" => $row->first_name.' '.$row->last_name,
                "hours_str" => $timeHelper->toTimeString($row->total_hours),
                "hours_dec" => $timeHelper->toDecimalTime($row->total_hours),
                "total_hours"=>$row->total_hours
            ];
        }
        return $reformated;
    }
    static public function formatUserReport($data){
        
        $reformated = [];
        $timeHelper = new TimeHelper;

        foreach($data as $row){
            $reformated[]= [
                "date" => $row->date_worked,
                "hours_str" => $timeHelper->toTimeString($row->total_hours),
                "hours_dec" => $timeHelper->toDecimalTime($row->total_hours),
                "total_hours"=>$row->total_hours,
                "entry_count" => $row->entry_count
            ];
        }
        return $reformated;
    }
    static public function reportFor($query_params, $userId){
        $report = Time::selectRaw('date_worked, sec_to_time(SUM(time_to_sec(total_hours))) as total_hours, count(date_worked) as entry_count')
            ->whereBetween('date_worked',[$query_params["from_date"], $query_params["to_date"]])
            ->where('users_id', '=', $userId)
            ->groupBy("date_worked")
            ->orderBy("date_worked", $query_params["sort_date"])
            ->get();
    
        // if no data exists then send empty array.
        if(is_null($report)) return [];
        
        // format report data
        $report = Time::formatUserReport($report);

        return $report;
        // return report data
    }
    static public function getEntriesFor($userId, $date){
        $entries = Time::where("users_id", "=", $userId)
            ->where("date_worked",'=', $date)
            ->orderBy("time_in", "desc")
            ->get();

        return $entries ?? [];
    }
}
