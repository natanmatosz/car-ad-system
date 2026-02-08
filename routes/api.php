<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function (): void {
    Route::post('/', [UserController::class, 'store']);
    Route::post('/{uuid}/verification', [UserController::class, 'verifyCode']);
});
