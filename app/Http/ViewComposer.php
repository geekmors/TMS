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
      $this->isAdmin = false;
      $this->isNotEmployee = false;

      if(auth()->check()){
        $userId = auth()->user()->id;
        $this->userSetting = UserSetting::where('users_id','=',$userId)->first();
        $roleID = auth()->user()->role_id;
        $this->isAdmin = $roleID == 1;// 1=admin
        $this->isNotEmployee = $roleID !== 3; //2=HR and 3=Employee
      }
  }

  /**
   * Compose the view.
   *
   * @return void
   */
  public function compose(View $view)
  {
    $view->with('isAdmin', $this->isAdmin);
    $view->with('isNotEmployee', $this->isNotEmployee);

    if($this->userSetting){
      $view->with('userSetting', $this->userSetting);
    }
  }

}