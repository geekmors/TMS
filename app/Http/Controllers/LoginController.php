<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\Users;
use App\Models\UserSetting;
use App\Models\SystemSetting;
use App\Models\DomainList;
use Log;

class LoginController extends Controller
{
    public function index(){
        return view('pages.login');
    }
    public function signOut(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    // redirects to the google login page.
    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }
    // Will login the user to the session
    // create the user if the user does not exist
    // run setup job if the system is currently being setup
    public function handleProviderCallback(Request $request) {
        // check if the login was successful
        try{
            $user = Socialite::driver('google')->user();
        }
        catch(\Exception $e){
            // per UC-1
            if($request->session()->has("run_setup"))
                return redirect()->to('/setup');
            
            return redirect()->to('/login');    
        }
        
        // check if the system should enforce domain on login
        //      note: if no system setting exists as yet, then the function returns false
        if(SystemSetting::enforceDomain()){
            $emailDomain = explode('@', $user->user["email"])[1]; //extract the email domain from the user's email
            Log::info('Enforcing Domain');
            // check if the user's email domain is NOT in the domain list, in which case we redirect to the login page
            if(!DomainList::contains($emailDomain)){
                return redirect('/login');
            }
        }

        // check if the user already exists, if they do just log them in
        $existingUser = Users::where('email', '=', $user->email)->first();
        
        if($existingUser){
            // update the user's last login timestamp before logging in
            $existingUser->timestamp_lastlogin = date('Y-m-d H:i:s');
            $existingUser->save();
            auth()->login($existingUser, true);
        }
        else{// if the user did not exist
            // create a new user
            $newUser = new Users;
            // if we are in the setup process then the new user is set to admin, else set the new user to employee
            $roleID = $request->session()->has("run_setup")? 1 /* admin */ : 3 /* employee */;
            $newUser->createUser($user, $role_id = $roleID)->save();
            
            // add default user settings
            $userSetting = new UserSetting;
            $userSetting->createDefault($newUser->id, $user->user["picture"])->save();

            //login the new user
            auth()->login($newUser, true);

            // if we are in the setup process then we redirect to the next route in the setup process
            if($request->session()->has('run_setup')){                
                return redirect()->to('/setup/system-settings');
            }
            
        }
        // Redirect to the home page if the user is created and logged in
        return redirect('/');
    }
}
