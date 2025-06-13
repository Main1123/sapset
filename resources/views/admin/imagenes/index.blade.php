@extends('admin.layout')

@section('title', 'Imagenes')
@section('header', 'Imagenes')


@section('content')
<div class="modal fade" id="modalNuevoServicio" tabindex="-1" aria-labelledby="modalNuevoServicioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoServicioLabel">Nueva Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoServicio">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="precio" name="precio" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarServicio">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Imagenes</h3>
            <div class="card-tools">
                <button data-bs-toggle="modal" data-bs-target="#modalNuevoServicio" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nueva Imagen
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="serviciosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
