<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServidorEfetivo;

class ServidorEfetivoSeeder extends Seeder
{
    public function run(): void
    {
        ServidorEfetivo::insert([
            ['pes_id' => 1, 'se_matricula' => '20230001'],
        ]);
    }
}
