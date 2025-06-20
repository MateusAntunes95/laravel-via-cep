@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <h2 class="mb-4">Usuários Cadastrados</h2>

    <a href="{{ url('/form') }}" class="btn btn-success mb-3">Novo Usuário</a>

    @if ($users->isEmpty())
        <div class="alert alert-info">
            Nenhum usuário cadastrado ainda.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CEP</th>
                        <th>Endereço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->address->cep ?? '-' }}</td>
                            <td>
                                @if ($user->address)
                                    {{ $user->address->logradouro }}, {{ $user->address->bairro }},
                                    {{ $user->address->cidade }} - {{ $user->address->estado }}
                                @else
                                    <span class="text-muted">Endereço não disponível</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
