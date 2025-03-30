<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckTokenExpiration;
use App\Http\Controllers\{
    ServidorEfetivoController,
    ServidorTemporarioController,
    UnidadeController,
    LotacaoController,
    PessoaController,
    FotoPessoaController,
    CidadeController,
    EnderecoController, 
    AuthController,
    StorageTestController
};

// -- usando o auth:sanctum para deixar o codigo mais enxuto, já que no enunciado nao é especificado o auth 
Route::post('/login', [AuthController::class, 'login']);

Route::post('/minio/test-upload', [StorageTestController::class, 'upload']);
Route::get('/minio/list', [StorageTestController::class, 'list']);

Route::middleware(['auth:sanctum', CheckTokenExpiration::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});


Route::middleware(['auth:sanctum', CheckTokenExpiration::class])->group(function () {

    // -- rotas especificadas (por unidade / endereco por nome )
    Route::get('servidores-efetivos/unidade/{unid_id}', [ServidorEfetivoController::class, 'porUnidade']);
    Route::get('servidores-efetivos/endereco-funcional', [ServidorEfetivoController::class, 'enderecoFuncionalPorNome']);

    // -- rotas de CRUD padrao
    Route::apiResource('servidores-efetivos', ServidorEfetivoController::class);
    Route::apiResource('servidores-temporarios', ServidorTemporarioController::class);
    Route::apiResource('unidades', UnidadeController::class);
    Route::apiResource('lotacoes', LotacaoController::class);
    Route::apiResource('pessoas', PessoaController::class);
    Route::apiResource('fotos-pessoa', FotoPessoaController::class);

    // apenas com rota de get pq ja tem dados populados por (seeds), 
    // como no enunciado não pede o CRUD completo dessas, deixei assim, no ponto para uma possível escalada
    Route::get('cidades', [CidadeController::class, 'index']);
    Route::get('enderecos', [EnderecoController::class, 'index']);


});