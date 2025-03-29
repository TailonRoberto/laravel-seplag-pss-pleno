<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;


class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unidade::insert([
            ['unid_nome' => 'Secretaria da Educação', 'unid_sigla' => 'SEDUC'],
            ['unid_nome' => 'Secretaria da Saúde', 'unid_sigla' => 'SESAU'],
            ['unid_nome' => 'Secretaria da Fazenda', 'unid_sigla' => 'SEFAZ'],
            ['unid_nome' => 'Secretaria de Segurança', 'unid_sigla' => 'SEGUR'],
            ['unid_nome' => 'Secretaria de Meio Ambiente', 'unid_sigla' => 'SEMA'],
        ]);
    }
}
