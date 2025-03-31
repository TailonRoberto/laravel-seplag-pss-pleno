<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\Facades\Log;
use Throwable;

class ApiExceptionHandler
{
    public static function handle(Throwable $e, $request)
    {
        \Log::error('Exceção lançada: ' . get_class($e));

        if (! $request->is('api/*')) {
            return null;
        }

        if ($e instanceof HttpResponseException) {
            // Extrai a response JSON que foi criada dentro do middleware
            return $e->getResponse();
        }

        if ($e instanceof UnauthorizedHttpException) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Não autorizado.'
            ], 401);
        }
        
        if ($e instanceof HttpException) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Erro HTTP.',
            ], $e->getStatusCode());
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'objeto ou recurso não encontrado.',
            ], 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'objeto ou recurso não encontrado.',
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
            'error' => 'Error interno no servidor.',
            'message' => $e->getMessage(),
            'exception' => class_basename($e),
        ], 500);
    }
}
