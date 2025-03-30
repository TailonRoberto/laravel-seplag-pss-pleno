<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Endereco;

class EnderecoSeeder extends Seeder
{
    public function run(): void
    {
        Endereco::insert([
            [
                'end_tipo_logradouro' => 'Avenida',
                'end_logradouro' => 'Almirante Barroso',
                'end_numero' => '1000',
                'end_bairro' => 'Marco',
                'cid_id' => 1,
            ],
            [
                'end_tipo_logradouro' => 'Rua',
                'end_logradouro' => 'do Una',
                'end_numero' => '455',
                'end_bairro' => 'Guamá',
                'cid_id' => 1,
            ],
            [
                'end_tipo_logradouro' => 'Rodovia',
                'end_logradouro' => 'BR-316',
                'end_numero' => '200',
                'end_bairro' => 'Centro',
                'cid_id' => 2,
            ],
        ]);
    }
}