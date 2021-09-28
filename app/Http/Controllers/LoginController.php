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
                
                return redirect()->to('/setup');
            }

            return redirect()->to('/login');    
        }
        
        // check if the user already exists, if they do just log them in
        $existingUser = Users::where('email', '=', $user->email)->first();
        
        // [------] For UC-5 - remember to check if u should enforce domain_list before logging in the user
        //              if we must enforce domain then we must check that the user's email matches a domain in the domain list
        if($existingUser){
            $existingUser->timestamp_lastlogin = date('d M Y H:i:s');
            $existingUser->save();
            auth()->login($existingUser, true);
        }
        else{
            // create a new user
            $newUser = new Users;
            $newUser->createUser($user, $role_id = $request->session()->has("run_setup")? 1 : 3) // if run_setup is set the role id is set to admin else set it to employee
                ->save();
            
            // add default user settings
            $userSetting = new UserSetting;
            $userSetting->createDefault($newUser->id, $user->user["picture"])
                ->save();

            //login the new user
            auth()->login($newUser, true);

            // if we are in the setup process then we redirect to the next route in the setup process
            if($request->session()->has('run_setup')){                
                return redirect()->to('/setup/system-settings');
            }
            
        }
        // temp --------------
        return redirect('/');

    }
}
