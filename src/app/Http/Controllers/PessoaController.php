<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PessoaController extends Controller
{
    public function index()
    {
        return Pessoa::paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_nome' => 'required|string|max:255',
            'pes_data_nascimento' => 'required|date',
            'pex_sexo' => 'required|in:M,F',
            'pes_mae' => 'nullable|string|max:255',
            'pes_pai' => 'nullable|string|max:255',
        ]);

        return Pessoa::create($data);
    }

    public function show($id)
    {
        return Pessoa::with(['enderecos', 'fotos', 'servidorEfetivo', 'servidorTemporario', 'lotacoes'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        $data = $request->validate([
            'pes_nome' => 'sometimes|string|max:255',
            'pes_data_nascimento' => 'sometimes|date',
            'pex_sexo' => 'sometimes|in:M,F',
            'pes_mae' => 'nullable|string|max:255',
            'pes_pai' => 'nullable|string|max:255',
        ]);

        $pessoa->update($data);
        return $pessoa;
    }

    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->delete();

        return response()->json(['message' => 'Pessoa deletada com sucesso']);
    }
}
