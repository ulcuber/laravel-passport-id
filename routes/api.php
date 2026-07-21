<?php

declare(strict_types=1);

use App\Http\Controllers\OAuthUserController;
use App\Http\Controllers\OIDConnectUserController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckToken;

Route::middleware('auth:passport')->group(function () {
    Route::get('user', OAuthUserController::class)->name('user');
    Route::get('oidc-user', OIDConnectUserController::class)->middleware(CheckToken::using('openid'))->name('oidc-user');
});
