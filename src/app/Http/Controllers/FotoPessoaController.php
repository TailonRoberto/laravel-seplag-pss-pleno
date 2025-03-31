<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use App\Services\MinioService;

class FotoPessoaController extends Controller
{
    public function index()
    {
        return FotoPessoa::with('pessoa')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'fp_data' => 'nullable|date',
            'fp_bucket' => 'required|string|max:255',
            'fp_hash' => 'required|string|max:255',
        ]);

        return FotoPessoa::create($data);
    }

    public function show($id)
    {
        return FotoPessoa::with('pessoa')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $foto = FotoPessoa::findOrFail($id);

        $data = $request->validate([
            'fp_data' => 'nullable|date',
            'fp_bucket' => 'sometimes|string|max:255',
            'fp_hash' => 'sometimes|string|max:255',
        ]);

        $foto->update($data);
        return $foto;
    }

    public function destroy($id)
    {
        $foto = FotoPessoa::findOrFail($id);
        $foto->delete();

        return response()->json(['message' => 'Foto deletada com sucesso']);
    }

    public function storeWithUpload(Request $request, MinioService $minio)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        //-- Upload e geração do nome único
        $uploadResult = $minio->uploadAndGenerateSignedUrl($request->file('foto'));

        // Salvar no banco
        $foto = FotoPessoa::create([
            'pes_id' => $data['pes_id'],
            'fp_data' => now(),
            'fp_bucket' => env('MINIO_BUCKET'),
            'fp_hash' => $uploadResult['filename'],
        ]);

        return response()->json([
            'message' => 'Foto enviada com sucesso!',
            'foto' => $foto,
            'url' => $uploadResult['url'],
        ]);
    }   
}
