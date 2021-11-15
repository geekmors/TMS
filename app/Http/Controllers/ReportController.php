<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Users;
class ReportController extends Controller
{
    //
    public function index(Request $request){
        if(auth()->user()->role_id == 3){ // if the user is an employee, send them to the their report page
            $userReportURL = '/reports/user/'.(auth()->user()->id);
            return redirect($userReportURL);
        }
        else{// if the user is an HR, render the reports page first
            return view('pages.reports');
        }
    }
    public function userReport(Request $request, $userID){
        //if the user who is an employee attempts to access another user's report, then send them to their own report
        if(auth()->user()->id != $userID && auth()->user()->role_id == 3){
            return redirect('/reports/user/'.(auth()->user()->id));
        }
        else{
            $user = Users::where('id','=', $userID)->first();
            
            return view('pages.user-report', ["user"=>$user]);
            // render the user's report
                // get querystrings
                // get data based on querystrings
                // render page or json
        }
    }
    public function allUserReport(Request $request){
        // get querystrings
        // get data based on query strings
        // render page or json
    }
    public function downloadUserReportCSV(Request $request){
        // get query params
        // get data based on query params
        // set headers
        // generate csv string
        // send csv for download
    }
    public function downloadAllUserReportCSV(Request $request){
        // get query params
        // get data based on query params
        // set headers
        // generate csv string
        // send csv for download
    }
    private function getQueryParams($req){
        //Possible query string => ?from=YYYY-MM-DD&to=YYYY-MM-DD&sort_from=asc|desc&sort_person=asc|desc&sort_hours=asc&desc&only_users=1,2,3,4,5
    }
}
