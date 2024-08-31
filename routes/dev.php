<?php

use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Route;

Route::prefix('dev')->group(function () {
    Route::get('/product-admin-to-manufac', [DevController::class, 'productAdminToManufac']);
});
