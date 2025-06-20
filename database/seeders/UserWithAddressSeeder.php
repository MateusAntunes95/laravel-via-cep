<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserWithAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            $user = User::create([
                'name' => "Usuário {$i}",
                'email' => "usuario{$i}@example.com",
                'password' => Hash::make('password'),
            ]);

            $user->address()->create([
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
            ]);
        }
    }
}
