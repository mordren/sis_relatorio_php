@extends('layouts.app')

@section('title', 'Equipamentos de Medição')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Equipamentos de Medição</h1>
        <a href="{{ route('equipamentos-medicao.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Novo Equipamento
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($equipamentos->isEmpty())
        <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
            Nenhum equipamento registrado. <a href="{{ route('equipamentos-medicao.create') }}" class="text-blue-600 hover:text-blue-800 underline">Criar novo</a>
        </div>
    @else
        <div class="overflow-x-auto shadow rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nº Série</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Data Calibração</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($equipamentos as $eq)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $eq->getTypeLabel() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $eq->numero_serie }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $eq->data_calibracao?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $eq->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $eq->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('equipamentos-medicao.edit', $eq) }}" class="text-blue-600 hover:text-blue-900 mr-4">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('equipamentos-medicao.destroy', $eq) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza?')">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $equipamentos->links() }}
        </div>
    @endif
</div>
@endsection
