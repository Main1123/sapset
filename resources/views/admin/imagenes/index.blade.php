@extends('admin.layout')

@section('title', 'Imagenes')
@section('header', 'Imagenes')

@section('content')

<div class="modal fade" id="modalNuevaImagen" tabindex="-1" aria-labelledby="modalNuevaImagenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaImagenLabel">Nueva Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImagen" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="imagen_id" name="id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filename" class="form-label">Nombre de la Imagen</label>
                        <input type="text" class="form-control" id="filename" name="filename" required>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Seccion</label>
                        <textarea class="form-control" id="section" name="section" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="path" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="path" name="path">
                        <div id="current_image_preview" style="margin-top: 10px;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarImagen">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Imagenes</h3>
            <div class="card-tools">
                <button data-bs-toggle="modal" data-bs-target="#modalNuevaImagen" class="btn btn-primary btn-sm" id="btnAbrirModalNuevaImagen">
                    <i class="fas fa-plus"></i> Nueva Imagen
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="imagenesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Seccion</th>
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
        if ($.fn.DataTable.isDataTable('#imagenesTable')) {
            $('#imagenesTable').DataTable().destroy();
        }
        dataTableInstance = $('#imagenesTable').DataTable({
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
    getImagenes();

    function getImagenes(){
        fetch('/api/imagenes')
        .then(response => response.json())
        .then(data => {
            dataTableInstance.clear(); 
            const imagenes = data.imagenes || data; 

            imagenes.forEach(imagen => { 
                const imageUrl = imagen.path ? `/storage/${imagen.path}` : 'https://via.placeholder.com/50'; 
                dataTableInstance.row.add([
                    imagen.id,
                    imagen.filename,
                    imagen.section,
                    `<img src="${imageUrl}" class="img-thumbnail" width="50" height="50"/>`,
                    `
                    <button class="btn btn-primary btn-sm" onclick="editImagen(${imagen.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deleteImagen(${imagen.id})"><i class="fas fa-trash"></i></button>
                    `
                ]).draw(false);
            });
            dataTableInstance.draw(); 
        })
        .catch(error => {
            console.error('Error al cargar las imágenes:', error);
            Swal.fire("Error", "No se pudieron cargar las imágenes.", "error");
        });
    }

    $('#btnAbrirModalNuevaImagen').on('click', function() {
        $('#formImagen').trigger('reset');
        $('#imagen_id').val('');
        $('#modalNuevaImagenLabel').text('Nueva Imagen');
        $('#btnGuardarImagen').text('Guardar');
        $('#current_image_preview').html('');
        $('#modalNuevaImagen').modal('show');
    });

    window.editImagen = function(id) {
        fetch('/api/imagenes/' + id)
        .then(response => {
            if (!response.ok) {
                throw new Error('Imagen no encontrada o error en la API');
            }
            return response.json();
        })
        .then(data => {
            const imagenData = data.imagen || data; 

            $('#modalNuevaImagenLabel').text('Editar Imagen');
            $('#btnGuardarImagen').text('Actualizar');
            $('#id').val(imagenData.id);
            $('#filename').val(imagenData.filename);
            $('#section').val(imagenData.section);

            // Se elimina la línea que causaba el error: $('#path').val(data.imagen.path);

            if (imagenData.path) {
                $('#current_image_preview').html(`<img src="/storage/${imagenData.path}" alt="Imagen actual" width="100">`);
            } else {
                $('#current_image_preview').html('');
            }
            $('#path').val(''); 

            $('#modalNuevaImagen').modal('show');

            console.log('Datos de imagen para edición:', imagenData);
        })
        .catch(error => {
            console.error('Error al cargar imagen para edición:', error);
            Swal.fire("Error", "No se pudo cargar la imagen para edición.", "error");
        });
    }

    $(document).on('submit', '#formImagen', function(e){
        e.preventDefault();
        let form = new FormData(this);
        let imagenId = $('#imagen_id').val();

        let url = '/api/imagenes';
        let method = 'POST';

        if (imagenId) {
            url = '/api/imagenes/' + imagenId;
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
            Swal.fire(res.msj || 'Operación exitosa', '', 'success');
            $('#formImagen').trigger('reset');
            $('#modalNuevaImagen').modal('hide');
            $('#current_image_preview').html('');
            getImagenes();
        })
        .catch(error => {
            console.error('Hubo un problema al guardar/actualizar la imagen:', error);
            let errorMessage = "Ha ocurrido un problema al guardar/actualizar la imagen.";
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

    window.deleteImagen = function(id) {
        Swal.fire({
            title: "¿Estás seguro de eliminar esta imagen?",
            icon: "warning",
            iconHtml: "❓",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/api/imagenes/' + id, {
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
                    Swal.fire(res.msj || 'Eliminación exitosa', '', 'success');
                    getImagenes();
                })
                .catch(error => {
                    console.error('Hubo un problema con la petición fetch:', error);
                    let errorMessage = "Ha ocurrido un problema al intentar eliminar la imagen.";
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

    $('#path').on('change', function() {
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

    $('#modalNuevaImagen').on('hidden.bs.modal', function () {
        $('#formImagen').trigger('reset');
        $('#current_image_preview').html('');
        $('#imagen_id').val('');
        $('#modalNuevaImagenLabel').text('Nueva Imagen');
        $('#btnGuardarImagen').text('Guardar');
    });
});
</script>
@endpush