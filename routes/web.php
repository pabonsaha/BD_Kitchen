<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KitchenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginConfirm'])->name('loginConfirm');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/store',[AuthController::class,'store'])->name('register.store');


Route::get('/user-register',[AuthController::class,'userRegister'])->name('userRegister');
Route::post('/user-register',[AuthController::class,'userRegisterStore'])->name('userRegisterStore');



Route::get('kitchens',[HomeController::class,'kitchens'])->name('kitchens');
Route::get('kitchen/{slug}',[KitchenController::class,'index'])->name('kitchen.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});
