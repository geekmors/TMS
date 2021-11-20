<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DomainList;
use App\Models\SystemSetting;

use DB;

class SystemSettingsController extends Controller
{
    public function index() {
        //redirects to page - resources > views > pages > systemSettings
        //return view('pages.systemSettings');

        //fetches all stored data in db
        $dName = DB::select('select * from domain_list');

        //fetches last enforcement state
        $state = SystemSetting::orderBy('id', 'desc')->first()->enforce_domain;
        //error_log($state);

        return view('pages.systemSettings', ['dName'=>$dName], ['state'=>$state]);
    }


    public function store() {
        //creates a variable of the domain list table
        $domainName = new DomainList;

        //store request value (optional)
        $reqValue = request('dAdd');

        //check for uniqueness
        $user = DomainList::where('domain_name', '=', $reqValue)->first();
        //if unique store and redirect, reflecting update
        if ($user === null) {
            //gets the post and saves it
            $domainName->domain_name = $reqValue;
            $domainName->save();
            //after having it stored, redirects to system setting page, showing update
            return redirect('/system-settings');
        }
        //else just redirect
        else{
            return redirect('/system-settings');
        }
    }

    public function removeSite(){
        //gets the amount of sites
        $amount = DomainList::select('select * from domain_list')->count();
        //if there are more than one site, it's removed; else it notifies the user of illegal action
        if($amount > 1){
            $siteID = $_POST['siteID'];
            //find the row using the passed id
            $dList = DomainList::find($siteID);
            //delete row
            $dList->delete();
            //return successful message
            echo json_encode(array("statusCode"=>200));
        }
        else{
            //return failed message
            echo json_encode(array("statusCode"=>201));
        }
    }

    public function update() {
        //create copy of systemSetting db
        $sysSet = new SystemSetting;

        //get last record(update) in database
        $lastRec = SystemSetting::orderBy('id', 'desc')->first();

        //checks if the table is empty
        if($lastRec === NULL){
            //if empty, then enforcement is off and it's getting turned on
            $sysSet->enforce_domain = 1;
        }
        else{
            //check id enforcement is on
            if($lastRec->enforce_domain === 1){
                //set enforcement to off
                $sysSet->enforce_domain = 0;
            }
            else{
                //set enforcement to on
                $sysSet->enforce_domain = 1;
            }
        }

        //getting current time 
        $currentTime = \Carbon\Carbon::now()->toDateTimeString();
        //setting time on db copy
        $sysSet->system_time = $currentTime;

        //saving both fields in database
        $sysSet->save();

        //redirecting to system settings page
        return redirect('/system-settings');
    }
}
