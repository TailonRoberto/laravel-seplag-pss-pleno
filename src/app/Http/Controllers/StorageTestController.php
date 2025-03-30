<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageTestController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('files.*')) {
            return response()->json(['message' => 'Nenhum arquivo enviado.'], 400);
        }

        $arquivos = $request->file('files');
        $resultados = [];

        foreach ($arquivos as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            Storage::disk('minio')->put(
                $filename,
                file_get_contents($file),
                [
                    'visibility' => 'private',
                    'ContentType' => $file->getMimeType(),
                    'ContentDisposition' => 'inline'
                ]
            );

            $url = Storage::disk('minio')->temporaryUrl(
                $filename,
                now()->addMinutes(5),
                [
                    'ResponseContentType' => $file->getMimeType()
                ]
            );

            // $url = str_replace('http://minio:9000', 'http://localhost:9000', $url);

            $resultados[] = [
                'filename' => $filename,
                'url' => $url
            ];
        }

        return response()->json([
            'message' => 'Arquivos enviados com sucesso!',
            'arquivos' => $resultados
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
