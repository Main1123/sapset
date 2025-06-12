@extends('admin.layout')

@section('title', $configuracion ? 'Editar Configuración' : 'Nueva Configuración')
@section('header', $configuracion ? 'Editar Configuración' : 'Nueva Configuración')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $configuracion ? 'Editar Configuración' : 'Nueva Configuración' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ $configuracion ? route('admin.configuraciones.update', $configuracion->id) : route('admin.configuraciones.store') }}" method="POST">
                    @csrf
                    @if($configuracion)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" 
                               value="{{ old('nombre', $configuracion->nombre ?? '') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" 
                               value="{{ old('valor', $configuracion->valor ?? '') }}" required>
                        @error('valor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">
                            {{ old('descripcion', $configuracion->descripcion ?? '') }}
                        </textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.configuraciones.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> {{ $configuracion ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
