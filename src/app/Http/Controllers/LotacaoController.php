<?php

namespace App\Http\Controllers;

use App\Models\Lotacao;
use Illuminate\Http\Request;

class LotacaoController extends Controller
{
    public function index()
    {
        return Lotacao::with(['pessoa', 'unidade'])->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'unid_id' => 'required|exists:unidade,unid_id',
            'lot_data_lotacao' => 'nullable|date',
            'lot_data_remocao' => 'nullable|date|after_or_equal:lot_data_lotacao',
            'lot_portaia' => 'nullable|string|max:255',
        ]);

        return Lotacao::create($data);
    }

    public function show($id)
    {
        return Lotacao::with(['pessoa', 'unidade'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = Lotacao::findOrFail($id);

        $data = $request->validate([
            'unid_id' => 'sometimes|exists:unidade,unid_id',
            'lot_data_lotacao' => 'nullable|date',
            'lot_data_remocao' => 'nullable|date|after_or_equal:lot_data_lotacao',
            'lot_portaia' => 'nullable|string|max:255',
        ]);

        $registro->update($data);
        return $registro;
    }

    public function destroy($id)
    {
        $registro = Lotacao::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
