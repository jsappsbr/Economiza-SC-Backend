<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Market;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        Market::query()->insert([
            [
                'name' => 'Supermercado Koch - Itajaí e Região',
                'website' => 'https://www.superkoch.com.br',
                'code' => 'website_lj5',
            ],
            [
                'name' => 'Supermercado Koch - Itapema e Região',
                'website' => 'https://www.superkoch.com.br',
                'code' => 'website_lj9',
            ],
            [
                'name' => 'Supermercado Koch - Penha e Região',
                'website' => 'https://www.superkoch.com.br',
                'code' => 'website_lj23',
            ],
            [
                'name' => 'Supermercado Koch - Florianópolis Ilha',
                'website' => 'https://www.superkoch.com.br',
                'code' => 'website_lj47',
            ],
            [
                'name' => 'Supermercado Koch - Navegantes',
                'website' => 'https://www.superkoch.com.br',
                'code' => 'website_lj44',
            ],
            [
                "name" => 'Bistek - Lages',
                "code" => 'loja05',
                "website" => 'https://loja05.bistek.com.br',
            ],
            [
                "name" => 'Bistek - São José',
                "code" => 'loja16',
                "website" => 'https://loja16.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Brusque',
                "code" => 'loja07',
                "website" => 'https://loja07.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Criciúma',
                "code" => 'loja10',
                "website" => 'https://loja10.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Blumenau',
                "code" => 'loja17',
                "website" => 'https://loja17.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Itajaí',
                "code" => 'loja18',
                "website" => 'https://loja18.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Palhoça',
                "code" => 'loja20',
                "website" => 'https://loja20.bistek.com.br',
            ],
            [
                "name" => 'Bistek - Florianópolis',
                "code" => 'bistek',
                "website" => 'https://www.bistek.com.br',
            ]
        ]);
    }
}
