<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaEnderecoController extends Controller
{
    // Listar endereços vinculados a uma pessoa
    public function index($pessoaId)
    {
        $pessoa = Pessoa::with('enderecos')->findOrFail($pessoaId);

        return response()->json($pessoa->enderecos);
    }

    // Vincular um endereço à pessoa
    public function store(Request $request, $pessoaId)
    {
        $request->validate([
            'end_id' => 'required|exists:endereco,end_id',
        ]);

        $pessoa = Pessoa::findOrFail($pessoaId);
        $pessoa->enderecos()->syncWithoutDetaching([$request->end_id]);

        return response()->json(['message' => 'Endereço vinculado com sucesso']);
    }

    // Atualizar dados do relacionamento pivô (se houver campos extras)
    public function update(Request $request, $pessoaId, $enderecoId)
    {
        // Aqui você pode validar e atualizar campos extras no pivô
        // Exemplo: tipo_residencia, observações etc
        // Se não houver campos extras, esse método pode ser ignorado
        return response()->json(['message' => 'Atualização de pivô ainda não implementada']);
    }

    // Remover o vínculo
    public function destroy($pessoaId, $enderecoId)
    {
        $pessoa = Pessoa::findOrFail($pessoaId);
        $pessoa->enderecos()->detach($enderecoId);

        return response()->json(['message' => 'Endereço desvinculado com sucesso']);
    }
}
