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
                <button data-bs-toggle="modal" data-bs-target="#modalNuevoServicio" class="btn btn-primary btn-sm" id="btnAbrirModalNuevoServicio">
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

@push('scripts')
<script>
$(document).ready(function() {
    let dataTableInstance; 

    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#serviciosTable')) {
            $('#serviciosTable').DataTable().destroy();
        }
        dataTableInstance = $('#serviciosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            order: [[0, 'asc']]
        });
    }

    initializeDataTable();
    getServicios(); // Renamed to getServicios for clarity

    function getServicios(){ // Renamed to getServicios for clarity
        fetch('/api/servicios')
        .then(response => response.json())
        .then(data => {
            dataTableInstance.clear(); 
            const servicios = data.services || data; // Assuming `data.service` or just `data` contains the array

            servicios.forEach(services => { 
                const imageUrl = services.imagen ? `/storage/${services.imagen}` : 'https://via.placeholder.com/50'; 
                dataTableInstance.row.add([
                    services.id,
                    services.titulo,
                    services.descripcion,
                    services.precio,
                    services.estado == 1 ? 'Activo' : 'Inactivo', // Display "Activo" or "Inactivo"
                    `<img src="${imageUrl}" class="img-thumbnail" width="50" height="50"/>`,
                    `
                    <button class="btn btn-primary btn-sm" onclick="editServicio(${services.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deleteServicio(${services.id})"><i class="fas fa-trash"></i></button>
                    `
                ]).draw(false);
            });
            dataTableInstance.draw(); 
        })
        .catch(error => {
            console.error('Error al cargar los servicios:', error);
            Swal.fire("Error", "No se pudieron cargar los servicios.", "error");
        });
    }

    $('#btnAbrirModalNuevoServicio').on('click', function() {
        $('#formServicio').trigger('reset');
        $('#service_id').val(''); 
        $('#modalServicioLabel').text('Nuevo Servicio');
        $('#btnGuardarServicio').text('Guardar');
        $('#current_image_preview').html(''); 
        $('#estado').val('1'); // Set default to activo for new service
        $('#modalNuevoServicio').modal('show');
    });

    window.editServicio = function(id) { // Renamed for consistency
        fetch('/api/servicios/' + id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Servicio no encontrado o error en la API');
            }
            return response.json();
        })
        .then(data => {
            const servicioData = data.service || data; 

            $('#modalServicioLabel').text('Editar Servicio');
            $('#btnGuardarServicio').text('Actualizar'); // Corrected typo
            $('#service_id').val(servicioData.id);
            $('#titulo').val(servicioData.titulo);
            $('#descripcion').val(servicioData.descripcion);
            $('#precio').val(servicioData.precio);
            $('#estado').val(servicioData.estado); // Set select value correctly

            if (servicioData.imagen) {
                $('#current_image_preview').html(`<img src="/storage/${servicioData.imagen}" alt="Imagen actual" width="100">`);
            } else {
                $('#current_image_preview').html('');
            }
            $('#imagen').val(''); // Clear file input for security

            $('#modalNuevoServicio').modal('show');

            console.log('Datos de servicio para edición:', servicioData);
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
            method = 'PUT'; 
            form.append('_method', 'PUT'); 
        }

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            body: form,
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { // Get text for more detailed error
                    try {
                        const error = JSON.parse(text);
                        throw error;
                    } catch (e) {
                        throw { message: text }; // Throw text if not JSON
                    }
                });
            }
            return response.json();
        })
        .then(res => {
            Swal.fire(res.msj || 'Operación exitosa', '', 'success'); // Check for 'msj' or 'message'
            $('#formServicio').trigger('reset');
            $('#modalNuevoServicio').modal('hide');
            $('#current_image_preview').html('');
            getServicios(); // Recargar la tabla después de guardar/actualizar
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

    window.deleteServicio = function(id) { // Renamed for consistency
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
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    body: JSON.stringify({ id: id }) 
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(res => {
                    Swal.fire(res.msj || 'Eliminación exitosa', '', 'success'); // Check for 'msj' or 'message'
                    getServicios(); // Recargar la tabla después de eliminar
                })
                .catch(error => {
                    console.error('Hubo un problema con la petición fetch:', error);
                    let errorMessage = "Ha ocurrido un problema al intentar eliminar el servicio.";
                    if (error.message) {
                        errorMessage = error.message;
                    }
                    Swal.fire("Error al eliminar", errorMessage, "error");
                });
            } else if (result.isDismissed) {
                Swal.fire("Cancelado", "La eliminación ha sido cancelada.", "info");
            }
        });
    }

    $('#imagen').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#current_image_preview').html('<img src="' + e.target.result + '" class="img-thumbnail" width="100"/>');
            }
            reader.readAsDataURL(file);
        } else {
            $('#current_image_preview').html('');
        }
    });

    $('#modalNuevoServicio').on('hidden.bs.modal', function () {
        $('#formServicio').trigger('reset');
        $('#current_image_preview').html('');
        $('#service_id').val(''); 
        $('#modalServicioLabel').text('Nuevo Servicio');
        $('#btnGuardarServicio').text('Guardar');
        $('#estado').val('1'); // Reset state to default
    });
});
</script>
@endpush