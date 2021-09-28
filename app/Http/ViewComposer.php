<?php
namespace App\Http;

use Illuminate\Contracts\View\View;
use App\Models\SystemSetting;

class ViewComposer {

  protected $logo;

  /**
   * Create a new ViewComposer instance.
   */
  public function __construct()
  {
      $logo = SystemSetting::getCompanyLogo(); 

    $this->logo = $logo ? $logo : config('default_company_logo');
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