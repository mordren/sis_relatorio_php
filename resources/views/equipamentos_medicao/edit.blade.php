@extends('layouts.app')

@section('title', 'Editar Equipamento de Medição')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Editar Equipamento de Medição</h1>
        <span class="text-sm text-gray-600">ID: {{ $equipamento->id }}</span>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Erros encontrados:</strong>
            <ul class="list-disc ml-5 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('equipamentos-medicao.update', $equipamento) }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="tipo" class="block text-gray-700 font-bold mb-2">Tipo de Equipamento <span class="text-red-600">*</span></label>
            <select name="tipo" id="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('tipo') border-red-500 @enderror" required>
                <option value="">— Selecione —</option>
                <option value="detector" {{ old('tipo', $equipamento->tipo) === 'detector' ? 'selected' : '' }}>Detector de Gases</option>
                <option value="explosimetro" {{ old('tipo', $equipamento->tipo) === 'explosimetro' ? 'selected' : '' }}>Explosímetro</option>
                <option value="oximetro" {{ old('tipo', $equipamento->tipo) === 'oximetro' ? 'selected' : '' }}>Oxímetro</option>
            </select>
            @error('tipo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="numero_serie" class="block text-gray-700 font-bold mb-2">Nº Série <span class="text-red-600">*</span></label>
            <input type="text" name="numero_serie" id="numero_serie" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('numero_serie') border-red-500 @enderror" value="{{ old('numero_serie', $equipamento->numero_serie) }}" required>
            @error('numero_serie')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="data_calibracao" class="block text-gray-700 font-bold mb-2">Data de Calibração</label>
            <input type="date" name="data_calibracao" id="data_calibracao" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('data_calibracao') border-red-500 @enderror" value="{{ old('data_calibracao', $equipamento->data_calibracao?->format('Y-m-d')) }}">
            @error('data_calibracao')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="observacao" class="block text-gray-700 font-bold mb-2">Observação</label>
            <textarea name="observacao" id="observacao" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('observacao') border-red-500 @enderror">{{ old('observacao', $equipamento->observacao) }}</textarea>
            @error('observacao')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="ativo" class="flex items-center">
                <input type="checkbox" name="ativo" id="ativo" class="rounded" value="1" {{ old('ativo', $equipamento->ativo) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700 font-bold">Ativo</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Atualizar
            </button>
            <a href="{{ route('equipamentos-medicao.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
