<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeEnderecoController extends Controller
{
    public function index($unidadeId)
    {
        $unidade = Unidade::with('enderecos')->findOrFail($unidadeId);

        return response()->json($unidade->enderecos);
    }

    public function store(Request $request, $unidadeId)
    {
        $request->validate([
            'end_id' => 'required|exists:endereco,end_id',
        ]);

        $unidade = Unidade::findOrFail($unidadeId);
        $unidade->enderecos()->syncWithoutDetaching([$request->end_id]);

        return response()->json(['message' => 'Endereço vinculado com sucesso']);
    }

    public function update(Request $request, $unidadeId, $enderecoId)
    {
        return response()->json(['message' => 'Atualização de pivô ainda não implementada']);
    }

    public function destroy($unidadeId, $enderecoId)
    {
        $unidade = Unidade::findOrFail($unidadeId);
        $unidade->enderecos()->detach($enderecoId);

        return response()->json(['message' => 'Endereço desvinculado com sucesso']);
    }
}
