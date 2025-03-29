<?php


namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index()
    {
        return Unidade::paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unid_nome' => 'required|string|max:255',
            'unid_sigla' => 'required|string|max:20',
        ]);

        return Unidade::create($data);
    }

    public function show($id)
    {
        return Unidade::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = Unidade::findOrFail($id);

        $data = $request->validate([
            'unid_nome' => 'sometimes|string|max:255',
            'unid_sigla' => 'sometimes|string|max:20',
        ]);

        $registro->update($data);
        return $registro;
    }

    public function destroy($id)
    {
        $registro = Unidade::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
