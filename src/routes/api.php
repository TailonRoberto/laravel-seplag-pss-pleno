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


Route::middleware(['auth:sanctum', CheckTokenExpiration::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});


Route::middleware(['auth:sanctum', CheckTokenExpiration::class])->group(function () {
   

    Route::post('fotos-pessoa/upload', [FotoPessoaController::class, 'storeWithUpload']);

    //-- rotas do Min.io (upload / list)
    Route::post('/minio/test-upload', [StorageTestController::class, 'upload']);
    Route::get('/minio/list', [StorageTestController::class, 'list']);

    // -- rotas especificadas (por unidade / endereco por nome )
    Route::get('servidores-efetivos/unidade/{unid_id}', [ServidorEfetivoController::class, 'porUnidade']);
    Route::get('servidores-efetivos/endereco-funcional', [ServidorEfetivoController::class, 'enderecoFuncionalPorNome']);

    // -- rotas para contempla a adição e edição da tabelas relacionas pivo
    Route::apiResource('pessoas.enderecos', PessoaEnderecoController::class)->only(['index', 'store', 'update', 'destroy']);

    //-- rotas para contempla a adição e edição da tabelas relacionas pivo
    Route::apiResource('unidades.enderecos', UnidadeEnderecoController::class)->only(['index', 'store', 'update', 'destroy']);



    // -- rotas de CRUD padrao
    Route::apiResource('servidores-efetivos', ServidorEfetivoController::class);
    Route::apiResource('servidores-temporarios', ServidorTemporarioController::class);
    Route::apiResource('unidades', UnidadeController::class);
    Route::apiResource('lotacoes', LotacaoController::class);
    Route::apiResource('pessoas', PessoaController::class);
    Route::apiResource('fotos-pessoa', FotoPessoaController::class);
    Route::apiResource('cidades', CidadeController::class);
    Route::apiResource('enderecos', EnderecoController::class);



});