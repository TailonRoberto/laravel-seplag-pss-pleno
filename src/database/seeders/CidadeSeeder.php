<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cidade;

class CidadeSeeder extends Seeder
{
    public function run(): void
    {
        Cidade::insert([
            ['cid_nome' => 'Maranhão',       'cid_uf' => 'MA'],
            ['cid_nome' => 'Belém',  'cid_uf' => 'PA'],
            ['cid_nome' => 'São Paulo',      'cid_uf' => 'SP'],
            ['cid_nome' => 'Terezina',    'cid_uf' => 'PI'],
            ['cid_nome' => 'Goiania', 'cid_uf' => 'GO'],
        ]);
    }
}