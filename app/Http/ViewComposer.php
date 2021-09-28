<?php
namespace App\Http;

/**
 * Use this file to define global data to use in all views
 */


use Illuminate\Contracts\View\View;
use App\Models\SystemSetting;
use Log;
class ViewComposer {

  protected $logo;

  /**
   * Create a new ViewComposer instance.
   */
  public function __construct()
  {
      $logo = SystemSetting::getCompanyLogo(); 
      $this->logo = $logo ? $logo : config('app.default_company_logo');
  }

  /**
   * Compose the view.
   *
   * @return void
   */
  public function compose(View $view)
  {
    $view->with('logo', $this->logo);
  }

}