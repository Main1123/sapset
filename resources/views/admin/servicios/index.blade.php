@extends('admin.layout')

@section('title', 'Servicios')
@section('header', 'Servicios')

@section('content')

<div class="modal fade" id="modalNuevoServicio" tabindex="-1" aria-labelledby="modalNuevoServicioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalServicioLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formServicio" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="service_id" name="id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del Servicio</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Servicio</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio del Servicio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen del Servicio</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                        <div id="current_image_preview" style="margin-top: 10px;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarServicio">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Servicios</h3>
            <div class="card-tools">
                <button data-bs-toggle="modal" data-bs-target="#modalNuevoServicio" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Servicio
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
                        <th>Precio</th>
                        <th>Estado</th>
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#serviciosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        order: [[0, 'asc']]
    });

    get();

    function get(){
        fetch('/api/servicios')
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('#serviciosTable tbody');
            tbody.innerHTML = '';
            // Asegúrate de que 'data.service' es el array correcto de servicios
            data.service.forEach(service => { 
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${service.id}</td>
                    <td>${service.titulo}</td>
                    <td>${service.descripcion}</td>
                    <td>${service.precio}</td>
                    <td>${service.estado}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="edit(${service.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteService(${service.id})"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
    }

    $('.card-tools button').on('click', function() {
        $('#formServicio').trigger('reset');
        $('#service_id').val('');
        $('#modalServicioLabel').text('Nuevo Servicio');
        $('#btnGuardarServicio').text('Guardar');
        $('#current_image_preview').html('');
        $('#modalNuevoServicio').modal('show');
    });

    window.edit = function(id) {
        fetch('/api/servicios/' + id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Servicio no encontrado o error en la API');
            }
            return response.json();
        })
        .then(data => {
            // Revisa la consola para asegurar que data.estado o data.active viene correctamente
            // Si tu API devuelve 'active' en lugar de 'estado', cambia `data.estado` por `data.active` aquí
            $('#modalServicioLabel').text('Editar Servicio');
            $('#btnGuardarServar').text('Actualizar');
            $('#service_id').val(data.service.id);
            $('#titulo').val(data.service.titulo);
            $('#descripcion').val(data.service.descripcion);
            $('#precio').val(data.service.precio);
            $('#imagen').val(data.service.imagen);
            $('#activo').val(data.service.activo);

            if (data.service.imagen) {
                $('#current_image_preview').html(`<img src="/storage/${data.service.imagen}" alt="Imagen actual" width="100">`);
            } else {
                $('#current_image_preview').html('');
            }
            $('#imagen').val('');

            $('#activo').val(data.service.activo); 

            $('#modalNuevoServicio').modal('show');

            console.log(data.service);
        })
        .catch(error => {
            console.error('Error al cargar servicio para edición:', error);
            Swal.fire("Error", "No se pudo cargar el servicio para edición.", "error");
        });
    }

    $(document).on('submit', '#formServicio', function(e){
        e.preventDefault();
        let form = new FormData(this);
        let serviceId = $('#service_id').val();

        let url = '/api/servicios';
        let method = 'POST';

        if (serviceId) {
            url = '/api/servicios/' + serviceId;
            method = 'POST';
            form.append('_method', 'PUT'); 
        }

        fetch(url, {
            method: method,
            body: form,
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(res => {
            Swal.fire(res.msj, '', 'success');
            $('#formServicio').trigger('reset');
            $('#modalNuevoServicio').modal('hide');
            get();
        })
        .catch(error => {
            console.error('Hubo un problema al guardar/actualizar el servicio:', error);
            let errorMessage = "Ha ocurrido un problema al guardar/actualizar el servicio.";
            if (error.errors) {
                errorMessage = "Errores de validación:<br>";
                for (let field in error.errors) {
                    errorMessage += `<strong>${field}:</strong> ${error.errors[field].join(', ')}<br>`;
                }
            } else if (error.message) {
                errorMessage = error.message;
            }
            Swal.fire("Error", errorMessage, "error");
        });
    });

    window.deleteService = function(id) {
        Swal.fire({
            title: "¿Estás seguro de eliminar este servicio?",
            icon: "warning",
            iconHtml: "❓",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/api/servicios/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(res => {
                    Swal.fire(res.msj, '', 'success');
                    if (typeof get === 'function') {
                        get();
                    } else {
                        console.error("La función 'get()' no está definida o no es accesible.");
                    }
                })
                .catch(error => {
                    console.error('Hubo un problema con la petición fetch:', error);
                    Swal.fire("Error al eliminar", "Ha ocurrido un problema al intentar eliminar el servicio.", "error");
                });
            } else if (result.isDismissed) {
                Swal.fire("Cancelado", "La eliminación ha sido cancelada.", "info");
            }
        });
    }
});
</script>
@endpush