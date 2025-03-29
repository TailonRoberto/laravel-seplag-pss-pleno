<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;

class ServidorEfetivoController extends Controller
{
    public function index()
    {
        return ServidorEfetivo::with('pessoa')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'se_matricula' => 'required|string|max:50',
        ]);

        return ServidorEfetivo::create($data);
    }

    public function show($id)
    {
        return ServidorEfetivo::with('pessoa')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = ServidorEfetivo::findOrFail($id);

        $data = $request->validate([
            'se_matricula' => 'sometimes|string|max:50',
        ]);

        $registro->update($data);
        return $registro;
    }

    public function destroy($id)
    {
        $registro = ServidorEfetivo::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
