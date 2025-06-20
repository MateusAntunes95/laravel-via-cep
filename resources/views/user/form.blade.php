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

        {{-- Paginação estilo Bootstrap --}}
        <nav aria-label="Navegação de páginas" class="mt-4 d-flex justify-content-center">
            <ul class="pagination">

                {{-- Página Anterior --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                {{-- Links numéricos --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">
                                {{ $page }}
                                <span class="visually-hidden">(página atual)</span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Próxima Página --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </span>
                    </li>
                @endif

            </ul>
        </nav>
    @endif
@endsection
