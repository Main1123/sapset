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
            // *** CAMBIO CLAVE AQUÍ: URL del archivo de idioma para DataTables 2.x ***
            language: {
                url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json' // Usamos la versión 2.3.2, puedes verificar la más reciente en datatables.net/plug-ins/i18n/
            },
            // *****************************************************************
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            order: [[0, 'asc']],
            // *** RECOMENDADO: Definir las columnas explícitamente para mayor control y compatibilidad ***
            columns: [
                { data: 'id' },          // Mapea la columna 'ID' a la propiedad 'id' del objeto imagen
                { data: 'filename' },    // Mapea la columna 'Nombre' a la propiedad 'filename'
                { data: 'section' },     // Mapea la columna 'Seccion' a la propiedad 'section'
                {
                    data: 'path',        // Mapea la columna 'Imagen' a la propiedad 'path'
                    render: function(data, type, row) {
                        // `data` es el valor de 'path' para esta fila
                        const imageUrl = data ? `/storage/${data}` : 'https://via.placeholder.com/50';
                        return `<img src="${imageUrl}" class="img-thumbnail" width="50" height="50"/>`;
                    },
                    orderable: false,    // Deshabilita la ordenación por esta columna
                    searchable: false    // Deshabilita la búsqueda por esta columna
                },
                {
                    data: null,          // Para la columna de 'Acciones', no hay una propiedad de datos directa
                    render: function(data, type, row) {
                        // `row` es el objeto completo de la imagen, útil para pasar el ID a las funciones
                        return `
                            <button class="btn btn-primary btn-sm" onclick="editImagen(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="deleteImagen(${row.id})"><i class="fas fa-trash"></i></button>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
            // *****************************************************************************************
        });
    }

    initializeDataTable();
    getImagenes();

    function getImagenes(){
        fetch('/api/imagenes')
        .then(response => response.json())
        .then(data => {
            dataTableInstance.clear();
            const imagenes = data.imagenes || data; // Asume que la API devuelve un objeto con 'imagenes' o directamente un array

            // *** CAMBIO AQUÍ: Pasa el objeto completo 'imagen' a row.add para que 'columns.data' funcione ***
            // DataTables usará las definiciones en 'columns' para extraer los datos de cada objeto.
            imagenes.forEach(imagen => {
                dataTableInstance.row.add(imagen);
            });
            // **********************************************************************************************
            dataTableInstance.draw();
        })
        .catch(error => {
            console.error('Error al cargar las imágenes:', error);
            Swal.fire("Error", "No se pudieron cargar las imágenes.", "error");
        });
    }

    $('#btnAbrirModalNuevaImagen').on('click', function() {
        $('#formImagen').trigger('reset');
        $('#imagen_id').val(''); // Limpia el ID oculto al abrir para una nueva imagen
        $('#modalNuevaImagenLabel').text('Nueva Imagen');
        $('#btnGuardarImagen').text('Guardar');
        $('#current_image_preview').html(''); // Limpia la vista previa de la imagen
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
            const imagenData = data.imagen || data; // Manejo si la respuesta es { imagen: ... } o solo el objeto imagen

            $('#modalNuevaImagenLabel').text('Editar Imagen');
            $('#btnGuardarImagen').text('Actualizar');
            $('#imagen_id').val(imagenData.id);
            $('#filename').val(imagenData.filename);
            $('#section').val(imagenData.section);

            if (imagenData.path) {
                $('#current_image_preview').html(`<img src="/storage/${imagenData.path}" alt="Imagen actual" width="100">`);
            } else {
                $('#current_image_preview').html('');
            }
            $('#path').val(''); // Limpiar el input de archivo para que no se envíe un archivo "falso"

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
            method = 'POST'; // Cambiado a POST porque FormData con _method=PUT/PATCH funciona mejor con POST en algunos servidores/configuraciones de Laravel para envío de archivos. Laravel interpretará el _method.
            form.append('_method', 'PUT'); // Esto es crucial para que Laravel reconozca la petición como PUT/PATCH
        }

        fetch(url, {
            method: method,
            headers: {
                // 'Content-Type': 'multipart/form-data', // NO establecer Content-Type con FormData, el navegador lo hace automáticamente
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: form,
        })
        .then(response => {
            if (!response.ok) {
                // Intenta leer el mensaje de error del servidor
                return response.text().then(text => {
                    console.error('Respuesta completa del servidor (fallo):', text);
                    try {
                        const error = JSON.parse(text);
                        throw error; // Lanza el objeto de error parseado
                    } catch (e) {
                        throw { message: text || 'Error desconocido del servidor.' }; // Si no es JSON, usa el texto crudo
                    }
                });
            }
            return response.json();
        })
        .then(res => {
            Swal.fire(res.message || 'Operación exitosa', '', 'success');
            $('#formImagen').trigger('reset');
            $('#modalNuevaImagen').modal('hide');
            $('#current_image_preview').html('');
            getImagenes(); // Recargar la tabla después de guardar/actualizar
        })
        .catch(error => {
            console.error('Hubo un problema al guardar/actualizar la imagen:', error);
            let errorMessage = "Ha ocurrido un problema al guardar/actualizar la imagen.";
            if (error.errors) { // Si hay errores de validación de Laravel
                errorMessage = "Errores de validación:<br>";
                for (let field in error.errors) {
                    errorMessage += `<strong>${field}:</strong> ${error.errors[field].join(', ')}<br>`;
                }
            } else if (error.message) { // Si hay un mensaje de error general
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
                        'Content-Type': 'application/json', // Esto es correcto para DELETE con JSON
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
                    getImagenes(); // Recargar la tabla después de eliminar
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
        $('#imagen_id').val(''); // Asegurarse de limpiar el ID oculto al cerrar el modal
        $('#modalNuevaImagenLabel').text('Nueva Imagen');
        $('#btnGuardarImagen').text('Guardar');
    });
});
</script>
@endpush