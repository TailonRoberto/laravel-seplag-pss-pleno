<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class MinioService
{
    public function uploadAndGenerateSignedUrl($file)
    {
        $filename = Str::uuid() . '.' . $file->extension();
        $bucket = env('MINIO_BUCKET');

      
        Storage::disk('minio')->put(
            $filename,
            file_get_contents($file),
            [
                'visibility' => 'private',
                'ContentType' => $file->getMimeType(),
                'ContentDisposition' => 'inline',
            ]
        );

        
        $client = new S3Client([
            'version' => 'latest',
            'region' => env('MINIO_REGION'),
            'endpoint' => env('MINIO_PUBLIC_URL'), 
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => env('MINIO_KEY'),
                'secret' => env('MINIO_SECRET'),
            ],
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $filename,
            'ResponseContentType' => $file->getMimeType(),
        ]);

        $request = $client->createPresignedRequest($command, Carbon::now()->addMinutes(5));

        $url = (string) $request->getUri();

        return [
            'filename' => $filename,
            'url' => $url,
        ];
    }

    public function generateSignedUrl($filename, $bucket, $mimeType = 'image/jpeg')
    {
        $client = new S3Client([
            'version' => 'latest',
            'region' => env('MINIO_REGION'),
            'endpoint' => env('MINIO_PUBLIC_URL'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => env('MINIO_KEY'),
                'secret' => env('MINIO_SECRET'),
            ],
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $filename,
            'ResponseContentType' => $mimeType,
        ]);

        $request = $client->createPresignedRequest($command, now()->addMinutes(5));

        return (string) $request->getUri();
    }
    
    // -- metodo criado para para reconhecer imagens locais (arquivos),
    // -- promover a comunicação pelo cli para inserir imagens por seeds
    public function uploadFromPathUsingS3Client(string $path, string $originalName)
    {
        $filename = Str::uuid() . '.' . pathinfo($originalName, PATHINFO_EXTENSION);

        $client = new S3Client([
            'version' => 'latest',
            'region' => env('MINIO_REGION', 'us-east-1'),
            'endpoint' => env('MINIO_URL', 'http://minio:9000'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => env('MINIO_KEY'),
                'secret' => env('MINIO_SECRET'),
            ],
        ]);

        $client->putObject([
            'Bucket' => env('MINIO_BUCKET'),
            'Key' => $filename,
            'Body' => file_get_contents($path),
            'ContentType' => mime_content_type($path),
            'ContentDisposition' => 'inline',
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket' => env('MINIO_BUCKET'),
            'Key' => $filename,
            'ResponseContentType' => mime_content_type($path),
        ]);

        $request = $client->createPresignedRequest($command, now()->addMinutes(5));

        return [
            'filename' => $filename,
            'url' => (string) $request->getUri(),
        ];
    }
}
