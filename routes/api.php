<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('designerRegister', 'designerRegister');
    Route::post('userRegister', 'userRegister');
    Route::post('login', 'login');
    Route::post('registration', 'registration');
});

Route::get('test',function(){
    dd('work');
});

Route::prefix('user')->group(function () {
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetToken']);
    Route::post('/reset-password-token', [AuthController::class, 'resetPassword']);
});
