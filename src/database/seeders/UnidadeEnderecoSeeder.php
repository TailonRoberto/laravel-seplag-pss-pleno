<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;
use App\Models\Endereco;

class UnidadeEnderecoSeeder extends Seeder
{
    public function run(): void
    {
        // Garantindo que temos registros suficientes
        $unidades = Unidade::all();
        $enderecos = Endereco::all();

        if ($unidades->count() < 5 || $enderecos->count() < 3) {
            return; 
        }

        // Exemplo de ligações diretas
        $unidades[0]->enderecos()->attach($enderecos[0]->end_id); 
        $unidades[1]->enderecos()->attach($enderecos[1]->end_id); 
        $unidades[2]->enderecos()->attach($enderecos[2]->end_id); 
        $unidades[3]->enderecos()->attach($enderecos[0]->end_id); 
        $unidades[4]->enderecos()->attach($enderecos[1]->end_id); 
    }
}
