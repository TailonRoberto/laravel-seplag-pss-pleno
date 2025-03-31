<?php

namespace App\Http\Controllers;

use App\Models\Endereco;

class EnderecoController extends Controller
{
    public function index()
    {
        return Endereco::with('cidade')->paginate(10); 
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'end_rua' => 'required|string|max:255',
            'end_numero' => 'required|string|max:20',
            'end_bairro' => 'required|string|max:255',
            'cid_id' => 'required|exists:cidades,cid_id',
        ]);

        return Endereco::create($data);
    }

    public function update(Request $request, $id)
    {
        $endereco = Endereco::findOrFail($id);

        $data = $request->validate([
            'end_rua' => 'sometimes|string|max:255',
            'end_numero' => 'sometimes|string|max:20',
            'end_bairro' => 'sometimes|string|max:255',
            'cid_id' => 'sometimes|exists:cidades,cid_id',
        ]);

        $endereco->update($data);
        return $endereco;
    }

    public function destroy($id)
    {
        $endereco = Endereco::findOrFail($id);
        $endereco->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso']);
    }
}