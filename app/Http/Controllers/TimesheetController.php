<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Time;
use Log;

class TimesheetController extends Controller
{
    //
    public function index(Request $request){
        
        // if the query string json is set to true i.e. ?json=true, then data is returned as json object
        if($request->query('json', false) == true){ 

            return $this->getEntryData(auth()->user()->id, $request);
        }
        // Expected URL: /timesheet?from=YYYY-MM-DD&to=YYYY-MM-DD&sort_date=asc|desc&sort_starttime=asc|desc
        // if query strings are not set, then it fallbacks to the default values for each query string variable
        $queryParams = [
            "user_id" => auth()->user()->id,
            "from" => $request->query("from", date("Y-m")."01"),
            "to" => $request->query("to", date("Y-m-d")),
            "sort_date" => $request->query("sort_date", "desc"),
            "sort_timeIn" => $request->query("sort_starttime", "desc")
        ];
        return view('pages.timesheet', [
            "timeSheetEntries" => Time::getTimeEntryDataFor($queryParams)
        ]);
    }
    public function newEntry(Request $request){
        $entryData = $request->all();
        try{
            $timeEntry = new Time;
            $timeEntry->newEntry(auth()->user()->id, $entryData)->save();
            return response()->json([
                "status" => true, 
                "message" => "new entry saved successfully", 
                "data" => $timeEntry
            ]);
        }
        catch(Exception $e){
            Log::channel('TMSErrors')->error($e->getMessage());
            Log::channel('TMSErrors')->error($request->all());
            return abort(400, 'Server could not save the new entry');
        }
    }
    public function update(Request $request){
        $data = $request->all();
        try{

            $entry = Time::where('id', '=', $data['id'])->first();
            
            if(is_null($entry)) // make sure the entry exists
                throw new Exception('Entry with id "'.$data['id'].'" does not exist');
            
            if(auth()->user()->id == $entry->users_id){ // the user can only edit their own entries
                $entry->updateEntry($data)->save();
                return response()->json([
                    "status" => true,
                    "message" => "Successfully updated entry ".$entry->entry." from ". $entry->date_worked,
                    "data" => $entry
                ]);
            }
            else{ // if the entry does not belong to the user then send an access denied code
                return abort(413, 'acceess denied');
            }
        }
        catch(Exception $e){// if any errors occur then log the error and report back to the client.
            Log::channel('TMSErrors')->error($e->getMessage());
            Log::channel('TMSErrors')->error('Failed to update entry with data: '.$request->all());
            return abort(400, 'Server could not update the entry: '.$e->getMessage());
        }

    }

    private function getEntryData($user_id, Request $request){
        // URL expected: /timesheet?json=true&from=MM-DD-YYYY&to=MM-DD-YYY&sort_date=desc|asc&sort_timeStart=asc|desc
        //    will use current month as default from and to range and desc as default sort_date value
        /**
         * Returns a PHP associative array represented as the following Object 
         *  ["data"=>[
         *      "YYYY-MM-DD"=>[
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
         * ]
         * 
         */
        try{
            $queryParams = [
                "user_id" => $user_id,
                "from" => $request->query("from", date("Y-m")."01"),
                "to" => $request->query("to", date("Y-m-d")),
                "sort_date" => $request->query("sort_date", "desc"),
                "sort_timeIn" => $request->query("sort_starttime", "desc")
            ];
            return response()->json(["data" => Time::getTimeEntryDataFor($queryParams)]);
        }
        catch(Exception $e){
            Log::channel('TMSErrors')->error($e->getMessage());
            Log::channel('TMSErrors')->error('Failed to update entry with data.'.$request->fullUrl());
            return abort(400, 'Server could not get Timesheet Entry Summary Data: '.$e->getMessage());
        }
    }
}
