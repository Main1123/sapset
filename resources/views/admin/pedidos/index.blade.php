@extends('admin.layout')

@section('title', 'Pedidos')
@section('header', 'Pedidos')

@section('content')

<div class="modal fade" id="modalNuevoPedido" tabindex="-1" aria-labelledby="modalNuevoPedidoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoPedidoLabel">Nuevo Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoPedido">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarPedido">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Pedidos</h3>
                <div class="card-tools">
                    <button data-bs-toggle="modal" data-bs-target="#modalNuevoPedido" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Pedido
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="pedidosTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
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
        if ($.fn.DataTable.isDataTable('#pedidosTable')) {
            $('#pedidosTable').DataTable().destroy();
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
    getPedidos();

    function getPedidos(){
        fetch('/api/pedidos')
        .then(response => response.json())
        .then(data => {
            dataTableInstance.clear(); 
            const pedidos = data.pedido || data; 

            pedido.forEach(pedido => { 
                dataTableInstance.row.add([
                    pedido.id,
                    pedido.nombre_cliente,
                    pedido.cedula,
                    pedido.email,
                    pedido.telefono,
                    pedido.direccion,
                    pedido.servicio_id,
                    pedido.monto,
                    pedido.estado,
                    pedido.observaciones,
                    `
                    <button class="btn btn-primary btn-sm" onclick="editPedido(${pedido.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deletePedido(${pedido.id})"><i class="fas fa-trash"></i></button>
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

    $('#btnAbrirModalNuevoPedido').on('click', function() {
        $('#formNuevoPedido').trigger('reset');
        $('#pedido_id').val(''); // Limpia el ID oculto al abrir para una nueva imagen
        $('#modalNuevoPedidoLabel').text('Nuevo Pedido');
        $('#btnGuardarPedido').text('Guardar');
        $('#modalNuevoPedido').modal('show');
    });

    window.editPedido = function(id) {
        fetch('/api/pedidos/' + id)    
        .then(response => {
            if (!response.ok) {
                throw new Error('Pedido no encontrado o error en la API');
            }
            return response.json();
        })
        .then(data => {
            const imagenData = data.imagen || data; 

            $('#modalNuevoPedidoLabel').text('Editar Imagen');
            $('#btnGuardarPedido').text('Actualizar');
            $('#pedido_id').val(pedidoData.id); // <-- ¡CORRECTO! Asigna el ID al input oculto
            $('#nombre_cliente').val(pedidoData.nombre_cliente);
            $('#cedula').val(pedidoData.cedula);
            $('#email').val(pedidoData.email);
            $('#telefono').val(pedidoData.telefono);
            $('#direccion').val(pedidoData.direccion);
            $('#servicio_id').val(pedidoData.servicio_id);
            $('#monto').val(pedidoData.monto);
            $('#estado').val(pedidoData.estado);
            $('#observaciones').val(pedidoData.observaciones);

            $('#modalNuevoPedido').modal('show');

            console.log('Datos de imagen para edición:', imagenData);
        })
        .catch(error => {
            console.error('Error al cargar imagen para edición:', error);
            Swal.fire("Error", "No se pudo cargar la imagen para edición.", "error");
        });
    }

    $(document).on('submit', '#formNuevoPedido', function(e){
        e.preventDefault();
        let form = new FormData(this);
        let pedidoId = $('#pedido_id').val(); // <-- ¡CORREGIDO! Ahora usa el ID correcto del input oculto

        let url = '/api/pedidos';
        let method = 'POST';
        
        if (pedidoId) {
            url = '/api/pedidos/' + pedidoId;
            method = 'POST'; // Cambiado a POST porque FormData con _method=PUT/PATCH funciona mejor con POST en algunos servidores/configuraciones de Laravel para envío de archivos. Laravel interpretará el _method.
            form.append('_method', 'PUT'); // Esto es crucial para que Laravel reconozca la petición como PUT/PATCH
        }

        // Importante: Eliminar el encabezado Content-Type cuando se usa FormData para que el navegador lo establezca correctamente con el boundary.
        // También añadimos el CSRF token, aunque FormData ya debería incluirlo si el campo CSRF está en el formulario.
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            body: form,
        })
        .then(response => {
            if (!response.ok) {
                console.log('Respuesta del servidor (fallo):', response);
                console.log('Status (fallo):', response.status);
                console.log('Status text (fallo):', response.statusText);
                return response.text().then(text => {
                    console.log('Respuesta completa (fallo):', text);
                    try {
                        const error = JSON.parse(text);
                        throw error;
                    } catch (e) {
                        throw { message: text };
                    }
                });
            }
            return response.json();
        })
        .then(res => {
            Swal.fire(res.message || 'Operación exitosa', '', 'success');
            $('#formNuevoPedido').trigger('reset');
            $('#modalNuevoPedido').modal('hide');
            getImagenes(); // Recargar la tabla después de guardar/actualizar
        })
        .catch(error => {
            console.error('Hubo un problema al guardar/actualizar el pedido:', error);
            let errorMessage = "Ha ocurrido un problema al guardar/actualizar el pedido.";
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

    $('#modalNuevoPedido').on('hidden.bs.modal', function () {
        $('#formNuevoPedido').trigger('reset');
        $('#modalNuevoPedidoLabel').text('Nuevo Pedido');
        $('#btnGuardarPedido').text('Guardar');
    });
});
</script>
@endpush