<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::view('/','home.home');

//  All Login and Register Route  //

Route::view('/login','user.login');

Route::post('/login',[UserController::class,'loginuser']);

Route::view('/register','user.register');

Route::post('/register',[UserController::class,'registeruser']);

Route::get('/logout',[UserController::class,'logout']);

Route::view('/forgetpassword','user.forgetpassword');

Route::post('/forgetpassword',[UserController::class,'forgetpassword']);

Route::post('/changepassword',[UserController::class,'changepassword']);

Route::get('/profile',[UserController::class,'profile']);

Route::post('/profile',[UserController::class,'updateprofile']);

Route::get('/changeuserpassword',[UserController::class,'changeuserpassword']);

Route::post('/updateuserpassword',[UserController::class,'updateuserpassword']);

Route::post('/changeemailaddress',[UserController::class,'updateemailaddress']);

Route::get('/onlineuser',[UserController::class,'onlineuser']);

//  All Login and Register Route End Here  //
