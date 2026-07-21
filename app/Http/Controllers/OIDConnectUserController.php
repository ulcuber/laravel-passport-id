<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Used by Nuxt oidc provider to fetch user data after auth
 */
class OIDConnectUserController extends Controller
{
    public function __invoke(): ?array
    {
        return transform(auth()->user(), fn (User $user) => [
            'sub' => (string) $user->id,
            'name' => $user->name,
        ]);
    }
}
