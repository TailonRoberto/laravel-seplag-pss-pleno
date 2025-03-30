<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pessoa;
use Illuminate\Support\Carbon;

class PessoaSeeder extends Seeder
{
    public function run(): void
    {
        Pessoa::insert([
            [
                'pes_nome' => 'João da Silva',
                'pes_data_nascimento' => '1990-05-15',
                'pex_sexo' => 'M',
                'pes_mae' => 'Maria da Silva',
                'pes_pai' => 'José da Silva',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pes_nome' => 'Maria Oliveira',
                'pes_data_nascimento' => '1985-08-20',
                'pex_sexo' => 'F',
                'pes_mae' => 'Ana Oliveira',
                'pes_pai' => 'Carlos Oliveira',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}