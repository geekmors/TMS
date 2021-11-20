<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use the roles database
use App\Models\Roles;
//use the users database
use App\Models\Users;
//use the users database
use App\Models\UserSetting;
//use the db query
use DB;
use Log;

class UserManagementController extends Controller
{
    //redirect to main page
    public function index(){
    
        //fetches all stored data in db
        $userRoles = DB::table('roles')->get();
        //getting all values from users
        $users = DB::table('users')->get();
        //retutning to home page
        return view('pages.userManagement', ['users'=>$users], ['userRoles'=>$userRoles]);
    }

    public function search(){
        //get queried search
        $reqValue = request('searchName');
        //get all first names that start with value queried
        $users = Users::query()->where('first_name', 'LIKE', "{$reqValue}%")->get();
        //getting the rest of values
        $userRoles = DB::table('roles')->get();
        //retutning to home page
        return view('pages.userManagement', ['users'=>$users], ['userRoles'=>$userRoles]);
    }

    public function update(Request $request, $UID){
        $data  = $request->all();
        
        try{
            //Log::info("new role:".$data["newRoleVal"]." for user: ".$UID);

            $userTable = Users::find($UID);
            if(is_null($userTable)) 
                throw new Exception("User Does Not Exist");
            $userTable->role_id = $data["newRoleVal"];
            $userTable->save();
            return response()->json(["status"=>true, "data"=>$userTable ]);
        }
        catch(Exception $e){
            return abort(400, $e->getMessage());
        }
    }

    //public function update(Request $request, $UID){
        /*$userTable = Users::find($UID);
        $userTable->role_id = $request;
        $userTable->save();
        return $userTable;*/
        
    //}
}
