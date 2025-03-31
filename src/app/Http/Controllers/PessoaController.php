<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\MinioService;

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

    //-- todas as fotos assinadas de uma pessoa 
    public function fotos($id, MinioService $minio)
    {
        $fotos = FotoPessoa::where('pes_id', $id)->get();

        $fotos->transform(function ($foto) use ($minio) {
            $extension = pathinfo($foto->fp_hash, PATHINFO_EXTENSION);
            $mime = match (strtolower($extension)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                default => 'image/jpeg'
            };

            $foto->url = $minio->generateSignedUrl($foto->fp_hash, $foto->fp_bucket, $mime);

            return $foto;
        });

        return response()->json($fotos);
    }
}
