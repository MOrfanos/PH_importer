<?php

use App\Http\Controllers\V1\PornstarController;
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

Route::middleware(['throttle:' . config('throttling.api.Pornstars')])
    ->group(function () {
        Route::apiResource('pornstars', PornstarController::class)->only(['index', 'show']);
    });

