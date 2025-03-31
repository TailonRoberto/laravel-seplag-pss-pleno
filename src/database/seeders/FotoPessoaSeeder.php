<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FotoPessoa;
use Illuminate\Support\Facades\App;
use App\Services\MinioService;

class FotoPessoaSeeder extends Seeder
{
    public function run(): void
    {
        $minio = App::make(MinioService::class);

        // Caminhos das imagens locais
        $path1 = database_path('seeders/images/pessoaFoto1.jpg');
        $path2 = database_path('seeders/images/pessoaFoto2.jpg');

        // Upload via método compatível com CLI (usando S3Client direto)
        $upload1 = $minio->uploadFromPathUsingS3Client($path1, 'pessoaFoto1.jpg');
        $upload2 = $minio->uploadFromPathUsingS3Client($path2, 'pessoaFoto2.jpg');

        // Salva os dados reais no banco
        FotoPessoa::insert([
            [
                'pes_id' => 1,
                'fp_data' => now(),
                'fp_bucket' => env('MINIO_BUCKET'),
                'fp_hash' => $upload1['filename'],
            ],
            [
                'pes_id' => 2,
                'fp_data' => now(),
                'fp_bucket' => env('MINIO_BUCKET'),
                'fp_hash' => $upload2['filename'],
            ],
        ]);
    }
}
