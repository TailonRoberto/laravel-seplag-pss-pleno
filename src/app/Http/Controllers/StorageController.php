<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\MinioService;

class StorageController extends Controller
{
    public function upload(Request $request, MinioService $minio)
    {
        if (!$request->hasFile('files')) {
            return response()->json(['message' => 'Nenhum arquivo enviado.'], 400);
        }

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $uploaded[] = $minio->uploadAndGenerateSignedUrl($file);
        }

        return response()->json([
            'message' => 'Arquivos enviados com sucesso!',
            'arquivos' => $uploaded,
        ]);
    }


    public function list()
    {
        $files = Storage::disk('minio')->files();

        return response()->json([
            'arquivos' => $files
        ]);
    }
}
