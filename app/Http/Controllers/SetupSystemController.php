<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\UserSetting;
use App\Models\Role;
use App\Models\DomainList;
use App\Models\SystemSetting;
// use Log; // use if u need to debug the app, Log::debug('your error') is saved in the storage/framework/logs/ directory
// UC-1
class SetupSystemController extends Controller
{
    
    public function index(Request $request){
        return view('pages.setupSystem');
    }
    public function viewSetupSystemSettings(){
        $user =  Users::where('id','=', auth()->user()->id)->first();

        if($user){
            return view('pages.setupSystemSettings', [
                'hasData'=>true,
                'user'=>$user,
                'userSettings'=>$user->settings(),
                'role'=>Role::where('id','=', $user->role_id)->first()
            ]);
        }
        else return view('pages.setupSystemSettings',['hasData'=>false]);
    }
    public function createSetupSystemSettings(Request $request){
        // add user's email domain to domain_list
        $domain = new DomainList;
        $domain->domain_name = $request->input('domain');
        $domain->save();

        $systemSetting = new SystemSetting;
        $systemSetting->system_time = date('H:i:s'); //[K.A.] will change later on in the project
        $systemSetting->enforce_domain = $request->input('enforceDomainList','0') == "1";

        // save the system settings
        $systemSetting->save();

        // setup process is now done
            // forget sessions 'run_setup' and 'last_setup_route_visited'
        $request->session()->forget(['run_setup','last_setup_route_visited']);

        return redirect('/');
    }
}
