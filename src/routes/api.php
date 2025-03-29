<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\LotacaoController;

Route::apiResource('servidores-efetivos', ServidorEfetivoController::class);
Route::apiResource('servidores-temporarios', ServidorTemporarioController::class);
Route::apiResource('unidades', UnidadeController::class);
Route::apiResource('lotacoes', LotacaoController::class);

Route::get('/teste', function () {
    return ['status' => 'rota funcionando!'];
});

