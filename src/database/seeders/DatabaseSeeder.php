<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UnidadeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UnidadeSeeder::class,
            UserSeeder::class,
            CidadeSeeder::class,
            EnderecoSeeder::class,
            PessoaSeeder::class,
            FotoPessoaSeeder::class,          
            UnidadeSeeder::class,          
            ServidorEfetivoSeeder::class,
            ServidorTemporarioSeeder::class,
            LotacaoSeeder::class,
            PessoaEnderecoSeeder::class,
            UnidadeEnderecoSeeder::class,
        ]);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       // $this->call(UnidadeSeeder::class);
    }
}
