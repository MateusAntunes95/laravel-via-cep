<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        return User::with('address')->get();
    }

    public function show($id)
    {
        return User::with('address')->findOrFail($id);
    }

    public function store(UserRequest $request)
    {
        info('chegou aqui');
        $cep = preg_replace('/[^0-9]/', '', $request->cep);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->json('erro')) {
            return response()->json(['message' => 'CEP inválido'], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->address()->create([
            'cep' => $cep,
            'logradouro' => $response['logradouro'] ?? '',
            'bairro' => $response['bairro'] ?? '',
            'cidade' => $response['localidade'] ?? '',
            'estado' => $response['uf'] ?? '',
        ]);

        if ($request->wantsJson()) {
            return response()->json($user->load('address'), 201);
        }

        return redirect('/')->with('success', 'Usuário cadastrado com sucesso!');
    }

}
