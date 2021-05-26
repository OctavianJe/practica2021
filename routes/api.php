<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/boards', [BoardController::class, 'all']);
    Route::put('/board', [BoardController::class, 'addBoard']);
});
