@extends('layouts.app')

@section('title', 'Cadastrar Usuário')

@section('content')
    <h2>Cadastrar Usuário</h2>

    <form method="POST" action="{{ url('/api/users') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>


        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">CEP</label>
            <input type="text" name="cep" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
