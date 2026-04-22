@extends('layouts.app')

@section('title', 'Novo Equipamento de Medição')
@section('page-title', 'Novo Equipamento de Medição')

@section('content')
<div class="mb-4">
    <a href="{{ route('equipamentos_medicao.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="card-modern" style="max-width: 640px">
    <form method="POST" action="{{ route('equipamentos_medicao.store') }}">
        @csrf

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tipo de Equipamento <span class="text-danger">*</span></label>
                <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                    <option value="">— Selecione —</option>
                    <option value="detector" {{ old('tipo') === 'detector' ? 'selected' : '' }}>Detector de Gases</option>
                    <option value="explosimetro" {{ old('tipo') === 'explosimetro' ? 'selected' : '' }}>Explosímetro</option>
                    <option value="oximetro" {{ old('tipo') === 'oximetro' ? 'selected' : '' }}>Oxímetro</option>
                </select>
                @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nº Série <span class="text-danger">*</span></label>
                <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror"
                       value="{{ old('numero_serie') }}" required>
                @error('numero_serie')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Data de Calibração</label>
                <input type="date" name="data_calibracao" class="form-control @error('data_calibracao') is-invalid @enderror"
                       value="{{ old('data_calibracao') }}">
                @error('data_calibracao')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1"
                           {{ old('ativo', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Observação</label>
                <textarea name="observacao" class="form-control @error('observacao') is-invalid @enderror"
                          rows="3">{{ old('observacao') }}</textarea>
                @error('observacao')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Salvar
            </button>
            <a href="{{ route('equipamentos_medicao.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
