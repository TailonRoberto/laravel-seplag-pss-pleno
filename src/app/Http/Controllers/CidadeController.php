<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{
    public function index()
    {
        return Cidade::paginate(10); 
    }

    public function show($id)
    {
        return Cidade::findOrFail($id);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'cid_nome' => 'required|string|max:255',
            'cid_uf' => 'required|string|max:2',
        ]);

        return Cidade::create($data);
    }

    public function update(Request $request, $id)
    {
        $cidade = Cidade::findOrFail($id);

        $data = $request->validate([
            'cid_nome' => 'sometimes|string|max:255',
        ]);

        $cidade->update($data);
        return $cidade;
    }

    public function destroy($id)
    {
        $cidade = Cidade::findOrFail($id);
        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso']);
    }
    
}
