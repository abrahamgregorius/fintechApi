<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [UserController::class, 'login']);

Route::middleware('login')->group(function() {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::post('/user/update', [UserController::class, 'update']);
    
    Route::middleware('admin')->group(function() {
        Route::post('/user/create', [UserController::class, 'store']);
    });


    
});