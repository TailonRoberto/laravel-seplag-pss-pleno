<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pessoa;
use App\Models\Endereco;

class PessoaEnderecoSeeder extends Seeder
{
    public function run(): void
    {
        $pessoas = Pessoa::all();
        $enderecos = Endereco::all();

        if ($pessoas->isNotEmpty() && $enderecos->isNotEmpty()) {           
            $pessoas[0]->enderecos()->attach($enderecos[0]->end_id); 
            $pessoas[0]->enderecos()->attach($enderecos[1]->end_id); 
            $pessoas[1]->enderecos()->attach($enderecos[1]->end_id); 
            $pessoas[1]->enderecos()->attach($enderecos[2]->end_id); // @@
        }
    }
}