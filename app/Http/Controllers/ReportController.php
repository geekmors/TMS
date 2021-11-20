<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        $defaultFrom = strtotime(date('Y-m-d').' -20 days');
        // get querystrings
        $query_params = [
            "from_date" => $request->query("from_date", date("Y-m-d", $defaultFrom)),
            "to_date" => $request->query("to_date", date("Y")."-12-31"),
            "sort_name" => $request->query("sort_name", 'asc'),
            "sort_date" => $request->query("sort_date", 'asc'),
            "sort_hours" => $request->query("sort_hours", 'asc')
        ];
        // get data based on query strings
        $reportData = Time::reportAll($query_params);
        // render page or json
        if($request->query("json", "false") == "true")
            return response()->json($reportData);
        return view('pages.all-user-report', ["reportData" => $reportData, "query_params"=>$query_params]);
    }
    public function downloadUserReportCSV(Request $request){
        // get query params
        // get data based on query params
        // set headers
        // generate csv string
        // send csv for download
    }
    public function downloadAllUserReportCSV(Request $request){
        $defaultFrom = strtotime(date('Y-m-d').' -20 days');
        // get querystrings
        $query_params = [
            "from_date" => $request->query("from_date", date("Y-m-d", $defaultFrom)),
            "to_date" => $request->query("to_date", date("Y")."-12-31"),
            "sort_name" => $request->query("sort_name", 'asc'),
            "sort_date" => $request->query("sort_date", 'asc'),
            "sort_hours" => $request->query("sort_hours", 'asc')
        ];
        // get data based on query strings
        $reportData = Time::reportAll($query_params);
        // set headers
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="all_user_report-'.date('Y-m-d').'.csv"',
        ];
        // generate csv string
        $CSV_content = 'Date,Name,Hours Worked,Hours(decimal)';
        foreach($reportData as $row){
            $CSV_content .= PHP_EOL.date('d-M-y', strtotime($row["date"].' '.$row["total_hours"])).','
                .$row["name"].','
                .$row["hours_str"].','
                .$row["hours_dec"];
        }
        // send csv for download
        return Response::make($CSV_content, 200, $headers);
    }
    private function getQueryParams($req){
        //Possible query string => ?from=YYYY-MM-DD&to=YYYY-MM-DD&sort_from=asc|desc&sort_person=asc|desc&sort_hours=asc&desc&only_users=1,2,3,4,5
    }
}
