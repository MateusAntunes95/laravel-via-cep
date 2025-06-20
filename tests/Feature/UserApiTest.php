<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected function mockViaCepApi($cep = '01001000')
    {
        Http::fake([
            "https://viacep.com.br/ws/{$cep}/json/" => Http::response([
                'cep' => $cep,
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Boa vista',
                'localidade' => 'Criciuma',
                'uf' => 'SC',
            ], 200),
        ]);
    }

    public function test_can_list_users_empty()
    {
        $response = $this->getJson('/api/users');
        $response->assertStatus(200)
            ->assertExactJson([]);
    }

    public function test_can_create_user_and_address()
    {
        $this->mockViaCepApi('01001000');

        $postData = [
            'name' => 'teste',
            'email' => 'teste@example.com',
            'password' => 'password123',
            'cep' => '01001-000',
        ];

        $response = $this->postJson('/api/users', $postData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'name', 'email', 'created_at', 'updated_at',
                'address' => [
                    'id', 'user_id', 'cep', 'logradouro', 'bairro', 'cidade', 'estado', 'created_at', 'updated_at'
                ]
            ])
            ->assertJsonFragment([
                'name' => 'teste',
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Boa vista',
                'cidade' => 'Criciuma',
                'estado' => 'SC',
            ]);

        $this->assertDatabaseHas('users', ['email' => 'teste@example.com']);
        $this->assertDatabaseHas('addresses', ['cep' => '01001000']);
    }

    public function test_can_show_user_with_address()
    {
        $this->mockViaCepApi('01001000');

        $user = User::factory()->create([
            'name' => 'teste',
            'email' => 'teste@example.com',
            'password' => bcrypt('password123'),
        ]);

        $user->address()->create([
            'cep' => '01001000',
            'logradouro' => 'Praça da Sé',
            'bairro' => 'Boa vista',
            'cidade' => 'Criciuma',
            'estado' => 'SC',
        ]);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'teste',
                'email' => 'teste@example.com',
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Boa vista',
                'cidade' => 'Criciuma',
                'estado' => 'SC',
            ]);
    }
}
