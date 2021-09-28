<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SetupSystemController;
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

Route::view('/','pages.home')->name('home');
Route::get('/roles',[RoleController::class,'index'])->name('roles');

// Routes for logging in with google
Route::get('/redirect-google-login', [LoginController::class,'redirectToProvider'])->name('googleAuth');
Route::get('/authorized',[LoginController::class,'handleProviderCallback'])->name('authorize');

// Routes for UC-1
//--------------------
Route::middleware(['isFirstUse'])->group(function(){
    Route::get('/setup', [SetupSystemController::class, 'index'])->name('initSetup');
    Route::get('/setup/system-settings', [SetupSystemController::class, 'viewSetupSystemSettings'])->name('setupSystemSettings');
    Route::post('/setup/system-settings', [SetupSystemContoller::class, 'createSetupSystemSettings'])->name('createSystemSettings');
});
//-------------------