<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
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

Route::post('/sanctum/token', [AuthController::class, 'requestToken']);
Route::post('signup', [AuthController::class, 'signup']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/sanctum/token', [AuthController::class, 'revokeToken']);
    Route::post('/products/search', [ProductController::class, 'index']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

