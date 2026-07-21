<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Used by socialite to fetch user data after auth
 */
class OAuthUserController extends Controller
{
    public function __invoke()
    {
        return transform(auth()->user(), fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }
}
