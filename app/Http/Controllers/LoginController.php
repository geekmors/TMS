<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\Users;
use App\Models\UserSetting;
use Log;

class LoginController extends Controller
{
    // redirects to the google login page.
    public function redirectToProvider(){
        Log::debug('redirectToProvider line 15 ');
        return Socialite::driver('google')->redirect();
    }
    // Will login the user to the session
    // create the user if its not existing
    // run setup job if the system is currently being setup
    public function handleProviderCallback(Request $request) {
        // check if the login was successful
        try{
            $user = Socialite::driver('google')->user();
        }
        catch(\Exception $e){
            // per UC-1
            if($request->session()->has("run_setup")){
                Log:debug('exception in handleProverCallback line 29');
                return redirect()->to('/setup');
            }

            return redirect()->to('/login');    
        }
        
        // check if the user already exists, if they do just log them in
        $existingUser = Users::where('email', '=', $user->email)->first();
        
        if($existingUser){
            $existingUser->timestamp_lastlogin = date('d M Y H:i:s');
            $existingUser->save();
            auth()->login($existingUser, true);
        }
        else{
            // create a new user
            $newUser = new Users;
            $newUser->first_name = $user->user["given_name"];
            $newUser->last_name = $user->user["family_name"];
            $newUser->email = $user->user["email"];
            $newUser->google_id = $user->id;
            $newUser->dob = '0/0/0/'; // field will be removed from database
            $newUser->timestamp_lastlogin = date('Y-m-d H:i:s');
            

            // set the role to admin if this is the first user; else by default set the user to employee
            $newUser->role_id = $request->session()->has("run_setup")? 1 : 3; // 1->admin; 3->employee
            $newUser->save();
            // add default user settings
            $userSetting = new UserSetting;
            $userSetting->users_id = $newUser->id;
            $userSetting->dark_theme = false;
            $userSetting->avatar = $user->user["picture"];
            $userSetting->avatar_original = $userSetting->avatar;
            $userSetting->is_enabled = true;
            // set below user settings to default; 9/27/2021 - fix needed on migration side.
            $userSetting->typography_size_id = 1;
            $userSetting->time_format_id = 1;
            //--------            

            $userSetting->save();
            //login the new user
            auth()->login($newUser, true);

            if($request->session()->has('run_setup')){
                Log::debug('in authenticated/run setup redirect line 75');
                return redirect()->to('/setup/system-settings');
            }
            
        }
        // temp
        return redirect('/');

    }
}
