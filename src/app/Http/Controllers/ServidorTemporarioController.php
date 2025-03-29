<?php

namespace App\Http\Controllers;

use App\Models\ServidorTemporario;
use Illuminate\Http\Request;

class ServidorTemporarioController extends Controller
{
    public function index()
    {
        return ServidorTemporario::with('pessoa')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'st_data_admissao' => 'nullable|date',
            'st_data_demissao' => 'nullable|date|after_or_equal:st_data_admissao',
        ]);

        return ServidorTemporario::create($data);
    }

    public function show($id)
    {
        return ServidorTemporario::with('pessoa')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = ServidorTemporario::findOrFail($id);

        $data = $request->validate([
            'st_data_admissao' => 'nullable|date',
            'st_data_demissao' => 'nullable|date|after_or_equal:st_data_admissao',
        ]);

        $registro->update($data);
        return $registro;
    }

    public function destroy($id)
    {
        $registro = ServidorTemporario::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
