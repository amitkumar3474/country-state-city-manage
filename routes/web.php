<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
Use App\Http\Controllers\RoleController;
Use App\Http\Controllers\PermissionController;
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
Route::get('login', [UserController::class, 'login'])->name('login');
Route::get('registration', [UserController::class, 'registration'])->name('registration');
Route::post('registerPost', [UserController::class, 'registerPost'])->name('registerPost');
Route::post('loginPost', [UserController::class, 'loginPost'])->name('loginPost');

Route::group(['middleware' => 'auth'], function(){

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    Route::get('logout', [UserController::class, 'logout'])->name('logout');

    Route::resource('user', UserController::class);

    Route::resource('country', CountryController::class);
    Route::resource('city', CityController::class);

    Route::post('getstate', [StateController::class, 'getstate'])->name('getstate');
    Route::resource('state', StateController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    
});

?>