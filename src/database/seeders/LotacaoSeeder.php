<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lotacao;

class LotacaoSeeder extends Seeder
{
    public function run(): void
    {
        Lotacao::insert([
            [
                'pes_id' => 1,
                'unid_id' => 1,
                'lot_data_lotacao' => '2023-01-15',
                'lot_data_remocao' => null,
                'lot_portaia' => 'PORTARIA-001',
            ],
            [
                'pes_id' => 2,
                'unid_id' => 2,
                'lot_data_lotacao' => '2023-03-20',
                'lot_data_remocao' => null,
                'lot_portaia' => 'PORTARIA-002',
            ],
        ]);
    }
}