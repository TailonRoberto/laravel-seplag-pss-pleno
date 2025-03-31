<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class HandleApiExceptions
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {

            if (! $request->is('api/*')) {
                throw $e;
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Rota não encontrada.',
                ], 404);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => 'Não autorizado.',
                ], 401);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'error' => 'Erro de validação.',
                    'details' => $e->errors(),
                ], 422);
            }

            return response()->json([
                'error' => 'Erro inesperado no servidor.',
                'mensagem' => $e->getMessage(),
                'tipo' => class_basename($e),
            ], 500);
        }
    }
}
