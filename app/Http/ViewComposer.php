<?php
namespace App\Http;

/**
 * Use this file to define global data to use in all views
 */


use Illuminate\Contracts\View\View;
use App\Models\SystemSetting;
use App\Models\UserSetting;
use Log;
class ViewComposer {

  protected $logo;

  /**
   * Create a new ViewComposer instance.
   */
  public function __construct()
  {
     
      $this->userSetting = [];
      if(auth()->check()){
        $userId = auth()->user()->id;
        $this->userSetting = UserSetting::where('users_id','=',$userId)->first();
      }
  }

  /**
   * Compose the view.
   *
   * @return void
   */
  public function compose(View $view)
  {
    if($this->userSetting){
      $view->with('userSetting', $this->userSetting);
    }
  }

}