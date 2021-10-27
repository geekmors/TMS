<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Time;
use Log;

class TimesheetController extends Controller
{
    //
    public function index(){
        $entryLog = Time::getAllForUser(auth()->user()->id);
        return view('pages.timesheet', [
            "entryLog"=>$entryLog
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
                "data" => $entryData
            ]);
        }
        catch(Exception $e){
            Log::channel('TMSErrors')->error($e);
            Log::channel('TMSErrors')->error($request->all());
            return abort(400, 'Server could not save the new entry');
        }
    }
}
