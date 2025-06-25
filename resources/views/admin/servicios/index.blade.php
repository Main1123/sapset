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
                <input type="hidden" id="selected_image_path" name="selected_image_path"> 
                <input type="hidden" id="selected_image_id" name="imagen_id">
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
                        <label for="imagen" class="form-label">Imagen del Servicio</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="imagen" name="imagen">
                            <button class="btn btn-outline-secondary" type="button" id="btnSelectExistingImage">Seleccionar existente</button>
                        </div>
                        <div id="current_image_preview" style="margin-top: 10px;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio del Servicio</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="active" class="form-label">Activo</label>
                        <select class="form-control" id="active" name="active" required>
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

<div class="modal fade" id="modalSelectorImagenes" tabindex="-1" aria-labelledby="modalSelectorImagenesLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSelectorImagenesLabel">Seleccionar Imagen Existente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="image-gallery" class="row row-cols-1 row-cols-md-3 g-4">
                </div>
                <div class="alert alert-info mt-3" id="no-images-message" style="display: none;">
                    No hay imágenes guardadas todavía.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
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
                        <th>Activo</th>
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
    let dataTableInstance;
    let isSelectingImage = false; // Declarar la variable aquí

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
            order: [[0, 'asc']],
            // Define las columnas y cómo se renderizan
            columns: [
                { data: 'id' },
                { data: 'titulo' },
                { data: 'descripcion' },
                { data: 'precio' },
                {
                    data: 'active',
                    render: function(data, type, row) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    }
                },
                {
                    data: 'imagene', // <--- ¡CORREGIDO AQUÍ! ESPERA 'imagene'
                    render: function(data, type, row) {
                        const imageUrl = data ? `/storage/${data}` : 'https://via.placeholder.com/50';
                        return `<img src="${imageUrl}" class="img-thumbnail" width="50" height="50"/>`;
                    },
                    orderable: false // Generalmente las columnas de imagen no son ordenables
                },
                {
                    data: null, // No hay una propiedad de datos directa para las acciones
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm" onclick="editServicio(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="deleteServicio(${row.id})"><i class="fas fa-trash"></i></button>
                        `;
                    },
                    orderable: false, // Las columnas de acciones no son ordenables
                    searchable: false // Las columnas de acciones no son buscables
                }
            ]
        });
    }

    initializeDataTable(); 
    getServicios(); 

    function getServicios(){
        fetch('/api/servicios')
        .then(response => response.json())
        .then(data => {
            dataTableInstance.clear();
            const servicios = data.services || data;

            servicios.forEach(service => {
                dataTableInstance.row.add(service).draw(false); // <--- ¡Pasa el objeto completo!
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
        $('#active').val('1'); 
        $('#selected_image_path').val(''); 
        $('#selected_image_id').val(''); 
        $('#modalNuevoServicio').modal('show'); 
    });

    window.editServicio = function(id) {
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
            $('#btnGuardarServicio').text('Actualizar');
            $('#service_id').val(servicioData.id);
            $('#titulo').val(servicioData.titulo);
            $('#descripcion').val(servicioData.descripcion);
            $('#precio').val(servicioData.precio);
            $('#active').val(servicioData.active);

            // Usa 'imagene' para la vista previa también
            if (servicioData.imagene) { 
                $('#current_image_preview').html(`<img src="/storage/${servicioData.imagene}" alt="Imagen actual" width="100">`);
                $('#selected_image_path').val(servicioData.imagene); 
                if (servicioData.imagen_id) { 
                    $('#selected_image_id').val(servicioData.imagen_id); 
                } else {
                    $('#selected_image_id').val(''); 
                }
            } else {
                $('#current_image_preview').html('');
                $('#selected_image_path').val('');
                $('#selected_image_id').val(''); 
            }
            $('#imagen').val(''); 

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
        let selectedImagePath = $('#selected_image_path').val(); 
        let selectedImageId = $('#selected_image_id').val(); 

        if (selectedImagePath && !$('#imagen')[0].files.length) {
            form.append('imagen_existente', selectedImagePath);
            if (selectedImageId) { 
                form.append('imagen_id', selectedImageId); 
            }
            form.delete('imagen'); 
        } else {
            form.delete('imagen_existente');
            form.delete('imagen_id');
        }

        let url = '/api/servicios';
        let httpMethodForFetch = 'POST'; 
        
        if (serviceId) { 
            url = '/api/servicios/' + serviceId;
            form.append('_method', 'PUT'); 
        }

        const headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json' 
        };

        fetch(url, {
            method: httpMethodForFetch,
            headers: headers,
            body: form, 
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { 
                    console.error("Respuesta del servidor NO OK (texto):", text);
                    try {
                        const error = JSON.parse(text);
                        throw error;
                    } catch (e) {
                        throw { message: "Error inesperado del servidor. Respuesta HTML recibida.", fullResponse: text }; 
                    }
                });
            }
            return response.json(); 
        })
        .then(res => {
            Swal.fire(res.msj || res.message || 'Operación exitosa', '', 'success'); 
            $('#formServicio').trigger('reset'); 
            $('#modalNuevoServicio').modal('hide'); 
            $('#current_image_preview').html(''); 
            $('#selected_image_path').val(''); 
            $('#selected_image_id').val(''); 
            getServicios(); 
        })
        .catch(error => {
            console.error('Hubo un problema al guardar/actualizar el servicio:', error);
            let errorMessage = "Ha ocurrido un problema al guardar/actualizar el servicio.";
            if (error.errors) { 
                errorMessage = "Errores de validación:<br>";
                for (let field in error.errors) {
                    errorMessage += `<strong>${field}:</strong> ${error.errors[field].join(', ')}<br>`;
                }
            } else if (error.fullResponse) {
                errorMessage = "Se recibió una respuesta inesperada del servidor. Revisa la consola para más detalles.";
            } else if (error.message) {
                errorMessage = error.message;
            }
            Swal.fire("Error", errorMessage, "error"); 
        });
    });

    window.deleteServicio = function(id) {
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
                    Swal.fire(res.msj || 'Eliminación exitosa', '', 'success');
                    getServicios();
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
                $('#selected_image_path').val(''); 
                $('#selected_image_id').val(''); 
            }
            reader.readAsDataURL(file);
        } else {
            if (!$('#selected_image_path').val()) {
                $('#current_image_preview').html('');
            }
        }
    });

    $('#btnSelectExistingImage').on('click', function() {
        isSelectingImage = true; 
        loadExistingImages(); 
        $('#modalSelectorImagenes').modal('show'); 
    });

    $('#modalSelectorImagenes').on('show.bs.modal', function() {
        // No es necesario llamar a loadExistingImages aquí, ya se llama antes
    });

    $('#modalSelectorImagenes').on('hidden.bs.modal', function () {
        if (isSelectingImage) { 
            $('#modalNuevoServicio').modal('show');
            isSelectingImage = false; 
        }
    });

    function loadExistingImages() {
        fetch('/api/imagenes')
            .then(response => response.json())
            .then(data => {
                const gallery = $('#image-gallery');
                gallery.empty(); 
                $('#no-images-message').hide(); 

                const imagenes = data.imagenes || []; 

                if (imagenes.length === 0) {
                    $('#no-images-message').show(); 
                    return;
                }

                imagenes.forEach(image => { 
                    const imageUrl = `/storage/${image.path}`;

                    const imageCard = `
                        <div class="col">
                            <div class="card h-100 image-card" data-image-id="${image.id}" data-image-full-path="${image.path}" style="cursor: pointer;">
                                <img src="${imageUrl}" class="card-img-top p-2" alt="${image.filename}" style="height: 150px; object-fit: contain;">
                                <div class="card-body">
                                    <p class="card-text text-truncate">${image.filename}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    gallery.append(imageCard); 
                });

                $('.image-card').on('click', function() {
                    const selectedImageId = $(this).data('image-id'); 
                    const selectedImageFullPath = $(this).data('image-full-path'); 
                    const selectedImageUrl = `/storage/${selectedImageFullPath}`; 

                    $('#selected_image_id').val(selectedImageId); 
                    $('#selected_image_path').val(selectedImageFullPath); 
                    $('#current_image_preview').html(`<img src="${selectedImageUrl}" class="img-thumbnail" width="100"/>`); 
                    $('#imagen').val(''); 

                    $('#modalSelectorImagenes').modal('hide'); 
                });
            })
            .catch(error => {
                console.error('Error al cargar las imágenes existentes:', error);
                Swal.fire("Error", "No se pudieron cargar las imágenes existentes.", "error");
            });
    }

    $('#modalNuevoServicio').on('hidden.bs.modal', function () {
        if (!isSelectingImage) { 
            $('#formServicio').trigger('reset');
            $('#current_image_preview').html('');
            $('#service_id').val(''); 
            $('#modalServicioLabel').text('Nuevo Servicio');
            $('#btnGuardarServicio').text('Guardar');
            $('#active').val('1');
            $('#selected_image_path').val('');
            $('#selected_image_id').val('');
        }
    });
</script>
@endpush