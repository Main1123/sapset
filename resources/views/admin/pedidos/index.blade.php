@extends('admin.layout')

@section('title', 'Pedidos')
@section('header', 'Gestión de Pedidos')

@section('content')

<div class="modal fade" id="modalNuevoPedido" tabindex="-1" aria-labelledby="modalNuevoPedidoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoPedidoLabel">Nuevo Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoPedido" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="pedido_id" name="id">

                    <div class="row">
                        <div class="col mb-3">
                            <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                        </div>
                        <div class="col mb-3">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="servicio_id" class="form-label">Servicio</label>
                        <select class="form-control" id="servicio_id" name="servicio_id">
                            <option value="">Seleccione un servicio</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                        </div>
                        <div class="col mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="">Seleccione un estado</option>
                                <option value="0">Pendiente</option>
                                <option value="1">Completado</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarPedido">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Pedidos</h3>
            <div class="card-tools">
                <button id="btnAbrirModalNuevoPedido" data-bs-toggle="modal" data-bs-target="#modalNuevoPedido" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Pedido
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="pedidosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Cliente</th>
                        <th>Cédula</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Servicio</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
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
    let cachedServicios = []; // Para almacenar los servicios una vez y no recargarlos siempre

    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#pedidosTable')) {
            $('#pedidosTable').DataTable().destroy();
        }
        dataTableInstance = $('#pedidosTable').DataTable({
            // *** ¡CAMBIO CRÍTICO AQUÍ! URL del archivo de idioma para DataTables 2.x ***
            language: {
                url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json' // Asegúrate de que esta URL sea accesible
            },
            // *****************************************************************
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            order: [[0, 'asc']],
            // *** Configuración de columnas explícita para DataTables 2.x y manejo de datos ***
            columns: [
                { data: 'id' },
                { data: 'nombre_cliente' },
                { data: 'cedula' },
                { data: 'email' },
                { data: 'telefono' },
                { data: 'direccion' },
                {
                    data: 'servicio_id',
                    render: function(data, type, row) {
                        // Busca el nombre del servicio en el caché
                        const servicio = cachedServicios.find(s => s.id === data);
                        return servicio ? (servicio.nombre || servicio.descripcion) : 'N/A';
                    }
                },
                { data: 'monto' },
                {
                    data: 'estado',
                    render: function(data, type, row) {
                        if (data === 0) {
                            return 'Pendiente';
                        } else if (data === 1) {
                            return 'Completado';
                        }
                        return 'Desconocido';
                    }
                },
                { data: 'observaciones', defaultContent: '' }, // Usa defaultContent para campos que pueden ser nulos
                {
                    data: null, // Para la columna de 'Acciones'
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm me-1" onclick="editPedido(${row.id})" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="deletePedido(${row.id})" title="Eliminar"><i class="fas fa-trash"></i></button>
                        `;
                    }
                }
            ]
            // *****************************************************************************************
        });
    }

    // Inicializa la tabla y carga los pedidos y servicios al principio
    initializeDataTable();
    getServicios().then(() => { // Carga los servicios primero
        getPedidos(); // Luego carga los pedidos una vez que los servicios estén disponibles
    });


    function getPedidos() {
        fetch('/api/pedidos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                dataTableInstance.clear();
                const pedidos = data.pedido; // Asumiendo que la API devuelve un objeto con la clave 'pedido' que contiene un array

                if (!Array.isArray(pedidos)) {
                    console.error("La respuesta de la API no es un array en la clave 'pedido':", pedidos);
                    Swal.fire("Error", "Formato de datos de pedidos incorrecto. Se esperaba un array bajo la clave 'pedido'.", "error");
                    return;
                }

                // Pasa el objeto completo 'pedido' a row.add para que 'columns.data' funcione
                pedidos.forEach(pedido => {
                    dataTableInstance.row.add(pedido);
                });
                dataTableInstance.draw();
            })
            .catch(error => {
                console.error('Error al cargar los pedidos:', error);
                Swal.fire("Error", "No se pudieron cargar los pedidos.", "error");
            });
    }

    function getServicios() {
        return fetch('/api/servicios')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar servicios: ' + response.statusText);
                }
                return response.json();
            })
            .then(servicios => {
                cachedServicios = Array.isArray(servicios) ? servicios : []; // Almacena los servicios en caché
                const selectServicio = $('#servicio_id');
                selectServicio.empty().append('<option value="">Seleccione un servicio</option>');
                if (Array.isArray(servicios)) {
                    servicios.forEach(servicio => {
                        selectServicio.append(new Option(servicio.nombre || servicio.descripcion, servicio.id));
                    });
                } else {
                    console.warn("La API de servicios no devolvió un array:", servicios);
                }
                return cachedServicios; // Retorna el caché para futuras promesas
            })
            .catch(error => {
                console.error('Error al cargar servicios:', error);
                Swal.fire("Advertencia", "No se pudieron cargar los servicios para el formulario.", "warning");
                return [];
            });
    }

    $('#btnAbrirModalNuevoPedido').on('click', function() {
        $('#formNuevoPedido').trigger('reset');
        $('#pedido_id').val('');
        $('#modalNuevoPedidoLabel').text('Nuevo Pedido');
        $('#btnGuardarPedido').text('Guardar');
        getServicios(); // Asegura que los servicios se carguen al abrir el modal para un nuevo pedido
    });

    window.editPedido = function(id) {
        fetch('/api/pedidos/' + id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Pedido no encontrado o error en la API: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const pedidoData = data.pedido || data; // Manejo si la respuesta es { pedido: ... } o solo el objeto pedido

                if (!pedidoData || !pedidoData.id) {
                    throw new Error("Datos de pedido incompletos o inválidos.");
                }

                $('#modalNuevoPedidoLabel').text('Editar Pedido');
                $('#btnGuardarPedido').text('Actualizar');
                $('#pedido_id').val(pedidoData.id);

                $('#nombre_cliente').val(pedidoData.nombre_cliente);
                $('#cedula').val(pedidoData.cedula);
                $('#email').val(pedidoData.email);
                $('#telefono').val(pedidoData.telefono);
                $('#direccion').val(pedidoData.direccion);
                $('#monto').val(pedidoData.monto);
                $('#estado').val(pedidoData.estado);
                $('#observaciones').val(pedidoData.observaciones);

                getServicios().then(() => { // Carga los servicios y luego selecciona el correspondiente
                    $('#servicio_id').val(pedidoData.servicio_id);
                });

                $('#modalNuevoPedido').modal('show');
            })
            .catch(error => {
                console.error('Error al cargar pedido para edición:', error);
                Swal.fire("Error", "No se pudo cargar el pedido para edición: " + error.message, "error");
            });
    }

    $(document).on('submit', '#formNuevoPedido', function(e){
        e.preventDefault();

        const form = this;
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let formData = new FormData(form);
        let pedidoId = $('#pedido_id').val();

        let url = '/api/pedidos';
        let method = 'POST';

        if (pedidoId) {
            url = '/api/pedidos/' + pedidoId;
            method = 'POST';
            formData.append('_method', 'PUT'); // Es crucial para que Laravel reconozca la petición como PUT/PATCH
        }

        fetch(url, {
            method: method,
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                return response.json().catch(() => {
                    return response.text().then(text => {
                        throw new Error(`Error ${response.status}: ${response.statusText || 'Unknown Error'}. Detalles: ${text}`);
                    });
                }).then(errorData => {
                    throw errorData;
                });
            }
            return response.json();
        })
        .then(res => {
            Swal.fire(res.message || 'Operación exitosa', '', 'success');
            $('#formNuevoPedido').trigger('reset');
            $('#modalNuevoPedido').modal('hide');
            getPedidos(); // Recargar la tabla después de guardar/actualizar
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
            } else if (typeof error === 'string') {
                errorMessage = error;
            }
            Swal.fire("Error", errorMessage, "error");
        });
    });

    window.deletePedido = function(id) {
        Swal.fire({
            title: "¿Estás seguro de eliminar este pedido?",
            icon: "warning",
            iconHtml: "❓",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/api/pedidos/' + id, {
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
                    Swal.fire(res.message || 'Eliminación exitosa', '', 'success');
                    getPedidos(); // Recargar la tabla después de eliminar
                })
                .catch(error => {
                    console.error('Hubo un problema con la petición de eliminación:', error);
                    let errorMessage = "Ha ocurrido un problema al intentar eliminar el pedido.";
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
        $('#pedido_id').val('');
        $('#modalNuevoPedidoLabel').text('Nuevo Pedido');
        $('#btnGuardarPedido').text('Guardar');
        // No es necesario limpiar y volver a cargar los servicios aquí, getServicios() se llama al abrir el modal para nuevo pedido
        // y al editar se encarga de rellenar el select correctamente.
        $('#servicio_id').empty().append('<option value="">Seleccione un servicio</option>');
    });
});
</script>
@endpush