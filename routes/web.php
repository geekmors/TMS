<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SetupSystemController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserManagementController;
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
    Route::view('/','pages.home')->name('home');
    Route::get('/roles', [RoleController::class,'index'])->name('roles');
    Route::view('/reports','pages.reports')->name('reports');
    
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::post('/timesheet/create', [TimesheetController::class, 'newEntry'])->name('timesheet.newEntry');
    Route::post('/timesheet/update', [TimesheetController::class, 'update'])->name('timesheet.update');

});

// Routes for UC-1
//--------------------
Route::middleware(['isFirstUse'])->group(function(){
    Route::get('/setup', [SetupSystemController::class, 'index'])->name('initSetup');
    Route::get('/setup/system-settings', [SetupSystemController::class, 'viewSetupSystemSettings'])->name('setupSystemSettings');
    Route::post('/setup/system-settings', [SetupSystemController::class, 'createSetupSystemSettings'])->name('createSystemSettings');
});
//-------------------


// Routes for UC-2
//-------------------
//calls controller to load page only - app > http > SystemSettingsController
Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('viewPage');
//saving domain
Route::post('/system-settings', [SystemSettingsController::class, 'store'])->name('addDomain');
//deleting domain
Route::get('/system-settings/delete/{id}', [SystemSettingsController::class, 'delete'])->name('removeDomain');
//toggle on enforcement
Route::get('/system-settings/enforce', [SystemSettingsController::class, 'update'])->name('updateEnforcement');
//-------------------


// Routes for UC-3
//-------------------
//redirect to user management page
Route::get('/user', [UserManagementController::class, 'index'])->name('viewUsers');
//First Name Filter
Route::post('/user', [UserManagementController::class, 'search'])->name('filterFName');
//-------------------