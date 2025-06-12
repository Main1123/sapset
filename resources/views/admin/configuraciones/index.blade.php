@extends('admin.layout')

@section('title', 'Configuraciones')
@section('header', 'Configuraciones del Sistema')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Configuraciones</h5>
                <a href="{{ route('admin.configuraciones.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Nueva Configuración
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($configuraciones as $configuracion)
                            <tr>
                                <td>{{ $configuracion->nombre }}</td>
                                <td>{{ $configuracion->valor }}</td>
                                <td>{{ $configuracion->descripcion }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.configuraciones.edit', $configuracion->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.configuraciones.destroy', $configuracion->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta configuración?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
