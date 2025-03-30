<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServidorTemporario;

class ServidorTemporarioSeeder extends Seeder
{
    public function run(): void
    {
        ServidorTemporario::insert([
            [
                'pes_id' => 2,
                'st_data_admissao' => '2023-01-15',
                'st_data_demissao' => null, // Se ainda estiver ativo
            ],
        ]);
    }
}