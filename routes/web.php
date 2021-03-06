<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SetupSystemController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// If the user is not logged in, then these routes are made available
Route::middleware(['isNotLoggedIn'])->group(function(){
    // Routes for logging in with google
    Route::get('/redirect-google-login', [LoginController::class, 'redirectToProvider'])->name('googleAuth');
    Route::get('/authorized', [LoginController::class, 'handleProviderCallback'])->name('authorize');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});
// If the user is logged in, then these routes are made available
Route::middleware(['isLoggedIn'])->group(function(){
    Route::get('/signout', [LoginController::class,'signOut'])->name('signout');
    Route::redirect('/','/timesheet');
    Route::get('/roles', [RoleController::class,'index'])->name('roles');
    
    // Routes for UC-8 to UC-10
    //-------------------------
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::post('/timesheet/create', [TimesheetController::class, 'newEntry'])->name('timesheet.newEntry');
    Route::post('/timesheet/update', [TimesheetController::class, 'update'])->name('timesheet.update');
    //----------------
    

    // Routes for UC-13 & UC-14 (note: use case ids may change)
    //-------------
    Route::get('/reports', [ReportController::class, 'index'] )->name('reports');
    // Route::get('/reports/user/{$id}?<querystrings>')
    Route::get('/reports/user/{userID}', [ReportController::class, 'userReport'])->name('user-report');
    Route::get('/reports/user/{userID}/entries', [ReportController::class, 'getEntriesForUserInDate'])->name('user-report-entries');
    // Route::get('/reports/user/{$id}/download/{$format}?<querystrings>')
    Route::get('/reports/user/{userID}/download/csv', [ReportController::class, 'downloadUserReportCSV']);
    Route::middleware(['isNotEmployee'])->group(function(){
        //Route::get('/reports/all?<querystrings>')
        Route::get('/reports/all', [ReportController::class, 'allUserReport'])->name('all-user-report');
        Route::get('/reports/all/download/csv', [ReportController::class, 'downloadAllUserReportCSV']);
        //Route::get('/reports/all/download/{$format}?<querystrings>')
    });
    //--------------

    Route::middleware(['isAdmin'])->group(function(){//only Admin users should access these routes.
        // Routes for UC-2
        //-------------------
        //calls controller to load page only - app > http > SystemSettingsController
        Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('viewPage');
        //saving domain
        Route::post('/system-settings', [SystemSettingsController::class, 'store'])->name('addDomain');
        //deleting domain
        Route::post('/system-settings/removeSite', [SystemSettingsController::class, 'removeSite'])->name('removeThisDomain');

        //toggle on enforcement
        Route::get('/system-settings/enforce', [SystemSettingsController::class, 'update'])->name('updateEnforcement');
        //-------------------
        //-------------------

        // Routes for UC-3
        //-------------------
        //redirect to user management page
        Route::get('/user', [UserManagementController::class, 'index'])->name('viewUsers');
        //First Name Filter
        Route::post('/user', [UserManagementController::class, 'search'])->name('filterFName');
        //Update User's role
        Route::post('/updateRole/{UID}', [UserManagementController::class, 'update'])->name('UpdateRole');
        //-------------------
    });

    // UC-11
    //----------------

    Route::get('/preferences',[UserSettingController::class, 'index'])->name('viewPreference');
    Route::get('/preferences/darkmode',[UserSettingController::class,'darkmode'])->name('darkmode');
    Route::post('/preferences/update',[UserSettingController::class, 'update'])->name('update');
    // Route::post('/preferences/store',function(Request $request){
    //     dd($request()->all());
    // });
    Route::post('/preferences',[UserSettingController::class, 'update'])->name('updatePreference');
    //-----------

});

// Routes for UC-1
//--------------------
/*Route::middleware(['isFirstUse'])->group(function(){
    Route::get('/setup', [SetupSystemController::class, 'index'])->name('initSetup');
    Route::get('/setup/system-settings', [SetupSystemController::class, 'viewSetupSystemSettings'])->name('setupSystemSettings');
    Route::post('/setup/system-settings', [SetupSystemController::class, 'createSetupSystemSettings'])->name('createSystemSettings');
});
//-------------------*/




