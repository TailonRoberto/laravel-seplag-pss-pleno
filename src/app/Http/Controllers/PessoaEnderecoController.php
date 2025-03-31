<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaEnderecoController extends Controller
{
   
    public function index($pessoaId)
    {
        $pessoa = Pessoa::with('enderecos')->findOrFail($pessoaId);

        return response()->json($pessoa->enderecos);
    }

   
    public function store(Request $request, $pessoaId)
    {
        $request->validate([
            'end_id' => 'required|exists:endereco,end_id',
        ]);

        $pessoa = Pessoa::findOrFail($pessoaId);
        $pessoa->enderecos()->syncWithoutDetaching([$request->end_id]);

        return response()->json(['message' => 'Endereço vinculado com sucesso']);
    }

    //-- Como nao se tem outros campos no pivô esse metodo fica aguardando para ser implementado futuramente;
    public function update(Request $request, $pessoaId, $enderecoId)
    {
       
        return response()->json(['message' => 'Atualização de pivô ainda não implementada']);
    }

    //-- Remover o vínculo
    public function destroy($pessoaId, $enderecoId)
    {
        $pessoa = Pessoa::findOrFail($pessoaId);
        $pessoa->enderecos()->detach($enderecoId);

        return response()->json(['message' => 'Endereço desvinculado com sucesso']);
    }
}
