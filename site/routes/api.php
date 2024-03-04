<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\ValidateController;
use App\Http\Controllers\Api\ServeiImatgeController;

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

Route::prefix('api')->group(function () {
  Route::get('/image', [ServeiImatgeController::class, 'index']);
  Route::get('/image/{id}', [ServeiImatgeController::class, 'show']);
  Route::post('/image', [ServeiImatgeController::class, 'store']);
  Route::put('/image', [ServeiImatgeController::class, 'update']);
  Route::delete('/image/{id}', [ServeiImatgeController::class, 'destroy']);
});

Route::prefix('v1')->group(function () {
  Route::get('/ValidateSession', [ValidateController::class, 'index'])->name('ValidateSession');
});