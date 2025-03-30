<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return null; // Impede redirecionamento
    }

    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'message' => 'Token inválido ou usuário não autenticado.'
        ], 401));
    }
}
