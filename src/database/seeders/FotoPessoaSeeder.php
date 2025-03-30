<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FotoPessoa;

class FotoPessoaSeeder extends Seeder
{
    public function run(): void
    {
        FotoPessoa::insert([
            [
                'pes_id' => 1,
                'fp_data' => now(),
                'fp_bucket' => 'fotos',
                'fp_hash' => 'joao.jpg',
            ],
            [
                'pes_id' => 2,
                'fp_data' => now(),
                'fp_bucket' => 'fotos',
                'fp_hash' => 'maria.jpg',
            ],
        ]);
    }
}