<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\User\EventController as UserEventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\Auth\RegisteredUserController;

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

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('user')->group(function () {
    
        Route::get('/events', [UserEventController::class, 'index']);
        Route::post('/events', [UserEventController::class, 'store']);
        Route::delete('/events/{event}', [UserEventController::class, 'destroy']);
    });

    Route::put('/events/{event}/join', [EventController::class, 'join']);
    Route::put('/events/{event}/withdraw', [EventController::class, 'withdraw']);
});

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:sanctum');
