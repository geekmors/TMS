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

    //search via first name
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
}
