<?php

namespace App\Http\Controllers;
use App\Models\UserSetting;
use App\Models\Users;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\TypographySize;
use DB;
use Symfony\Contracts\Service\Attribute\Required;

class UserSettingController extends Controller
{
    public function index(){
       
        error_log (auth()->user()->id);
        $preferences = UserSetting::where('id','=',auth()->user()->id)->get();
     
        $typography = TypographySize::all();
        $state = UserSetting::where('id','=',auth()->user()->id)->first()->dark_theme;
        error_log($state);
         return view('pages.preferences',['preferences' =>$preferences, 'typography'=>$typography,'state'=>$state],);
}

    
    public function darkmode()
    {   
        $state = UserSetting::where('id','=',auth()->user()->id)->first()->dark_theme;
        $preferences = UserSetting::find(auth()->user()->id);
            if($state===1)
                 $state = 0;
            else
                $state=1;
        $preferences->dark_theme = $state;
        $preferences->save();
return redirect('/preferences');
    }


public function update(Request $request){
    $preferences = UserSetting::find(auth()->user()->id);
    if($request->hasFile('image')){
         $request->validate([
            'typo'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048' 
         ]);
         $imagename= time(). '.'. $request->image->extension(); 
         $request->image->move(public_path('images'),$imagename);
        
         $preferences->avatar= $imagename;
         $preferences->avatar_original= $imagename;
         
         $preferences->save();
        
         
    

} 
$textsize= TypographySize::where('description','=',$request->typo)->first()->id ;

if(is_numeric($textsize)){
    $preferences->typography_size_id = $textsize;
    $preferences->save();
}
return redirect('/preferences');
}

}

