<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::group((['middleware' => 'auth',]), function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/admin/companies', CompanyController::class);
    Route::resource('/admin/employees', EmployeeController::class);
    Route::get('uploads/{filename}', [CompanyController::class, 'displayImage'])->name('displayimage');
});
