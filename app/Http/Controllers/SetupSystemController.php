<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\UserSetting;
use App\Models\Role;
use App\Models\DomainList;
use App\Models\SystemSetting;

use Log;
class SetupSystemController extends Controller
{
    //
    public function index(Request $request){
        return view('pages.setupSystem');
    }
    public function viewSetupSystemSettings(){
        Log::debug('in viewSetupSystemSettings');
        $user =  Users::where('id','=', auth()->user()->id)->first();
        if($user){
            return view('pages.setupSystemSettings', [
                'hasData'=>true,
                'user'=>$user,
                'userSettings'=>UserSetting::where('users_id','=', $user->id)->first(),
                'role'=>Role::where('id','=', $user->role_id)->first()
            ]);
        }
        else return view('pages.setupSystemSettings',['hasData'=>false]);
    }
    public function createSetupSystemSettings(Request $request){
        $request->validate([
            'companyLogo'=>'mimes:png,jpeg|max:4096'
        ]);

        $systemSetting = new SystemSetting;
        $systemSetting->system_time = time(); //[K.A.] will change later on in the project
        $systemSetting->enforce_domain = $request->input('enforceDomainList');

        if($request->file()){
            $name = $request->file->getClientOriginalName();
            $filePath = $request->file('companyLogo')->storeAs('uploads', $name, 'public');
            
            $systemSetting->system_logo = "/storage/" . $filePath;

        }
        else
            $systemSetting->system_logo = "https://lh5.googleusercontent.com/CMVK4PrU4gQAS06mB_rxj6v6QyEBJWOQp4RsbJwpFR8AOzpfnf3-366JHbA7ozGQAnpzqWTf6J-X4g-zvXeZ=w1920-h937-rw"; //default company Logo
        
        $domain = new DomainList;
        $domain->domain_name = $request->input('domain');
        $domain->save();

        $systemSetting->save();
        // add domain to domain_list
        // create system settings
        // forget sessions 'run_setup' and 'last_setup_route_visited'
    }
}
