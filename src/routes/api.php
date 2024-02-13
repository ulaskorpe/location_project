<?php

use App\Http\Controllers\LocationController;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


 
Route::group(['middleware'=>'throttle:login_register_limit'],function(){
    Route::post('/login-post',[AuthController::class,'login_post'])->name('admin-login-post');
    Route::post('/register',[AuthController::class,'register'])->name('register');
});
Route::group(['middleware'=>['auth:sanctum','throttle:30,60']],function(){
    Route::post('/logout',[AuthController::class,'logout'])->name('admin-logout-post');
    Route::post('/me',[AuthController::class,'me'])->name('admin-me-post');
    Route::resource('/locations',LocationController::class);
});