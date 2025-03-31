<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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

            // Lança exceção apropriada, será capturada no ApiExceptionHandler
            throw new UnauthorizedHttpException('', 'Token expirado');
        }

        return $next($request);
    }
}
