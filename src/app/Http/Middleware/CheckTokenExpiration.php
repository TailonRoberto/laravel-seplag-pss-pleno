<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token && $token->expires_at && now()->greaterThan($token->expires_at)) {

            // Libera a rota para possibilitar o refresh-token
            if ($request->is('api/refresh-token')) {
                return $next($request);
            }

            return response()->json(['message' => 'Token expirado'], 401);
        }

        return $next($request);
    }
}
