<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Users;
use Log;
class SetupSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Get the first User from the database
        $user = Users::first();
                
        // if no user exists then we must run the system setup process per UC-1
        if(!$user && !$request->session()->has('run_setup')){
            // set the session keys used in the process
            $request->session()->put('run_setup','true');
            $request->session()->put('last_setup_route_visited','setup');
            Log::debug('middleware setupsystem line 28 '.$request->path());
            return redirect('/setup');
        }
        // if we are already in the setup process
        else if ($request->session()->has('run_setup')){
            Log::debug('in middleware setupsystem line 33'.$request->path());

            // check if the requested path is a valid setup path
            if($this->IsValidSetupPath($request->path())){               
                // set the current requested path as the new last setup route visited then continue 
                $request->session()->put('last_setup_route_visited', $request->path());
                Log::debug('in middleware setupsystem line 37'.$request->path());
                return $next($request);
            }
            else{     
                Log::debug('in middleware setupsystem line 43');

                // in the event the user tries to visit a non valid setup route then they will be sent back to the last valid setup route they visited.
                return redirect('/'.$request->session()->get('last_setup_route_visited'.$request->path()));
            }

        }
        
        // if setup has already been done, we just continue.
        return $next($request);
    }

    // returns true if the $current requested path is in the list of allowed paths during setup
    protected function IsValidSetupPath($current){
        $paths = ["setup","redirect-google-login","authorized","setup/system-settings"];
        foreach($paths as $path){
            if($path == $current) 
                return true;
        }
        return false;
    }
}
