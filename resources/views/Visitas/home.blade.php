@extends('layouts.menu')
@section('stylesExtra')
    <link href="{{ asset('Resources/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Resources/css/select2-bootstrap-5-theme.css') }}" rel="stylesheet">
@endsection
@section('scriptsExtra')
    <script src="{{ asset('Resources/js/visitante.js') }}"></script>
    <script src="{{ asset('Resources/js/select2.min.js') }}"></script>
@endsection
@section('controllerLinks')
    <input id="url-index" type="hidden" name="url-index" value="{{ route('indexVst') }}">
    <input id="url-store" type="hidden" name="url-store" value="{{ route('storeVst') }}">
    <input id="url-show" type="hidden" name="url-show" value="{{ route('Visitas') }}">
@endsection
@section('Titulo')
    <i class="fa-solid fa-list me-2"></i>Lista de Visitantes
@endsection
@section('Contenido')
    <div class="row justify-content-between">
        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" placeholder="Buscar" name="search"
                    id="search">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 d-flex justify-content-end">
            <button class="btn btn-secondary btn-sm mb-3" type="button" id="btnAgregar" data-bs-toggle="modal"
                data-bs-target="#modalMain">
                <i class="fa-solid fa-plus me-2"></i>Nuevo Visitante
            </button>
            <div class="modal fade" id="modalMain" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-custom">
                        <input id="id_rsdt" type="hidden" name="id_rsdt">
                        <form id="rsdtForm">
                            <div class="header">
                                <div><i class="fa-solid fa-sitemap me-2"></i><span id="modal-titulo">Nuevo Residente</span>
                                </div>
                                <i class="fa-solid fa-xmark modal-close" data-bs-dismiss="modal"></i>
                            </div>
                            <div class="body">
                                <div class="text-center" id="modal-mensaje"></div>
                                @csrf
                                <div class="d-flex flex-column mb-1">
                                    <label for="ci_rsdt" class="label-form">CI:</label>
                                    <input type="text" class="form-control form-control-sm" id="ci_rsdt"
                                        name="ci_rsdt">
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <label for="nombre_rsdt" class="label-form">Nombre:</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre_rsdt"
                                        name="nombre_rsdt">
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <label for="apellidop_rsdt" class="label-form">Apellido
                                        Paterno:</label>
                                    <input type="text" class="form-control form-control-sm" id="apellidop_rsdt"
                                        name="apellidop_rsdt">
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <label for="apellidom_rsdt" class="label-form">Apellido
                                        Materno:</label>
                                    <input type="text" class="form-control form-control-sm" id="apellidom_rsdt"
                                        name="apellidom_rsdt">
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <label for="fechanac_rsdt" class="label-form">Fecha de
                                        Nacimiento:</label>
                                    <input type="date" class="form-control form-control-sm" id="fechanac_rsdt"
                                        name="fechanac_rsdt">
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <label for="telefono_rsdt" class="label-form">Teléfono:</label>
                                    <input type="text" class="form-control form-control-sm" id="telefono_rsdt"
                                        name="telefono_rsdt">
                                </div>
                            </div>
                            <div class="footer">
                                <div id="botonesModal">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="store" id="btnCrud"
                                        class="btn btn-sm btn-outline-light">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="index-error" class="text-small text-center"></div>
    <div id="index-table">
        <div class="table-responsive rounded shadow-sm">
            <table id="tabla"
                class="table text-nowrap table-sm table-striped table-bordered text-center align-middle table-hover m-0">
            </table>
        </div>
    </div>
    <div id="seccionTotalResultados" class="mt-3 d-none">
        <nav class="row g-3 justify-content-between">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3">
                <ul id="pagination-container"
                    class="pagination pagination-sm justify-content-center justify-content-sm-start m-0">
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3">
                <div class="input-group input-group-sm justify-content-center justify-content-sm-end">
                    <label class="input-group-text border-secondary bg-gray" for="totalResultados">N° Resultados:</label>
                    <select class="form-select border-secondary page-select" id="totalResultados" name="totalResultados">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15" selected>15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
        </nav>
    </div>
    <script>
        $(document).ready(function() {
            //#region Configuraciones Iniciales
            let modalMain = $('#modalMain');
            let tituloModal = $('#modal-titulo');
            let mensajeModal = $('#modal-mensaje');
            let searchInput = $('#search');
            let btnCrud = $('#btnCrud');
            let tableIndex = $('#tabla');
            let urlIndex = $('#url-index').val();
            let urlStore = $('#url-store').val();
            let urlShow = $('#url-show').val() + '/';
            let urlUpdate = urlShow;
            let urlDelete = urlShow;
            //#endregion

            //#region Funciones Extras
            function MostrarNotificacion(clase, texto, segundos)
    {
        let aux = $("#notificacion");
        if (aux.html() != undefined)
        {
            aux.remove();
        }
        let html = `
        <div id="notificacion" class="alerta show fade alert p-0 alert-dismissible alert-${clase}">
            <div class="d-flex justify-content-between align-items-center py-1 px-2 gap-2">
                <div class="text-justify" style="font-size: 12.6px">Notificación.</div>
                <button class="btn btn-sm p-0 text-${clase}" id="btnCerrarAlerta" type="button" data-bs-dismiss="alert" data-bs-target="#notificacion">
                    <i class="fa-solid fa-xmark text-dark"></i>
                </button>
            </div>
            <hr class="m-0">
            <div class="py-1 px-2">
                <div class="text-justify alerta-text">` + texto + `</div>
            </div>
        </div>`;
        $("body").append(html);
        let alerta = $("#notificacion");
        setTimeout(function()
        {
            alerta.alert("close");
        }, segundos * 1000);
    }

            function resetAllOnModal() {
                $('#rsdtForm')[0].reset(); // Reiniciar Formulario
                $('#rsdtForm').find(':input').prop('disabled', false);
                $('#botonesModal').removeClass('opacity-0');
                tituloModal.text('Nuevo Visitante');
                mensajeModal.html('');
                btnCrud.attr('name', 'store');
                btnCrud.text('Agregar');
            }
            //#endregion

            //#region Funciones Prepare
            function prepareSelect(id) {
                tituloModal.text('Detalles sobre el Visitante');
                $('#rsdtForm').find(':input').prop('disabled', true);
                $('#botonesModal').addClass('opacity-0');
                show(id);
            }

            function prepareEdit(id) {
                tituloModal.text('Editar Visitante');
                $('#rsdtForm').find(':input').prop('disabled', false);
                show(id);
            }

            function prepareDelete(id) {
                tituloModal.text('Eliminar Visitante');
                mensajeModal.html('El siguiente visitante se eliminará a continuación,<br>¿Está seguro?');
                $('#rsdtForm').find(':input:not(button)').prop('disabled', true);
                show(id);
            }
            //#endregion

            //#region Paginación
            function generatePaginationButtons(currentPage, lastPage, url, search) {
                let paginationContainer = $('#pagination-container');
                paginationContainer.empty();

                let maxVisibleButtons = 3; // Número máximo de botones visibles en la paginación

                // Verificar si hay menos de 4 páginas en total para mostrar solo los numeros de paginación
                if (lastPage <= maxVisibleButtons) {
                    for (let i = 1; i <= lastPage; i++) {
                        let pageButton = $(
                            '<li class="page-item"><button class="page-link border-secondary pag-item">' + i +
                            '</button></li>');
                        if (i === currentPage) {
                            pageButton.addClass('active');
                        }
                        pageButton.click(function() {
                            if (currentPage !== i) {
                                index(search, url + '&page=' + i);
                            }
                        });
                        paginationContainer.append(pageButton);
                    }
                    return; // Salir de la función después de generar los botones de número de página
                }

                // Botón para ir a la primera página
                let firstPageButton = $('<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') +
                    '"><button class="page-link border-secondary pag-item">&laquo;</button></li>');
                firstPageButton.click(function() {
                    if (currentPage !== 1) {
                        index(search, url + '&page=1');
                    }
                });
                paginationContainer.append(firstPageButton);

                // Botón para ir a la página anterior
                let previousPageButton = $('<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') +
                    '"><button class="page-link border-secondary pag-item">&lt;</button></li>');
                previousPageButton.click(function() {
                    if (currentPage > 1) {
                        let prevPage = currentPage - 1;
                        index(search, url + '&page=' + prevPage);
                    }
                });
                paginationContainer.append(previousPageButton);

                // Botones para las páginas intermedias
                let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
                let endPage = Math.min(lastPage, startPage + maxVisibleButtons - 1);

                if (endPage - startPage < maxVisibleButtons - 1) {
                    startPage = Math.max(1, endPage - maxVisibleButtons + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    let pageButton = $('<li class="page-item ' + (i === currentPage ? 'active' : '') +
                        '"><button class="page-link border-secondary pag-item">' + i + '</button></li>');
                    pageButton.click(function() {
                        if (currentPage !== i) {
                            index(search, url + '&page=' + i);
                        }
                    });
                    paginationContainer.append(pageButton);
                }

                // Botón para ir a la página siguiente
                let nextPageButton = $('<li class="page-item ' + (currentPage === lastPage ? 'disabled' : '') +
                    '"><button class="page-link border-secondary pag-item">&gt;</button></li>');
                nextPageButton.click(function() {
                    if (currentPage < lastPage) {
                        let nextPage = currentPage + 1;
                        index(search, url + '&page=' + nextPage);
                    }
                });
                paginationContainer.append(nextPageButton);

                // Botón para ir a la última página
                let lastPageButton = $('<li class="page-item ' + (currentPage === lastPage ? 'disabled' : '') +
                    '"><button class="page-link border-secondary pag-item">&raquo;</button></li>');
                lastPageButton.click(function() {
                    if (currentPage !== lastPage) {
                        index(search, url + '&page=' + lastPage);
                    }
                });
                paginationContainer.append(lastPageButton);
            }
            //#endregion

            //#region Funciones CRUD
            function index(search = "", url = urlIndex + '?page=1') {
                let _token = $('meta[name="csrf-token"]').attr('content');
                let totalResultados = $('#totalResultados').val();
                let error = $('#index-error');
                let seccionTotalResultados = $('#seccionTotalResultados');
                let html = "";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        _token: _token,
                        search: search,
                        totalResultados: totalResultados
                    },
                    dataType: 'json',
                    success: function(response) {
                        tableIndex.empty();
                        if (response.data.data.length > 0) {
                            error.html('');
                            html = `
                    <thead class="table-secondary fw-semibold">
                        <tr>
                            <th>CI</th>
                            <th>NOMBRE</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>TELÉFONO</th>
                            <th width="200">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                `;
                            response.data.data.forEach(personal => {
                                html += `
                        <tr>
                            <td>${personal.ci_rsdt}</td>
                            <td>${personal.nombre_rsdt} ${personal.apellidop_rsdt} ${personal.apellidom_rsdt}</td>
                            <td>${personal.fechanac_rsdt}</td>
                            <td>${personal.telefono_rsdt}</td>
                            <td>
                                <button id='btnSelect' data-id="${personal.id_rsdt}" class='btn p-0 btn-sm btn-info text-white' type='button' data-bs-toggle='modal' data-bs-target='#modalMain'><i class='fa-solid fa-magnifying-glass-plus'></i></button>
                                <button id='btnEdit' data-id="${personal.id_rsdt}" class='btn p-0 btn-sm btn-secondary text-white' type='button' data-bs-toggle='modal' data-bs-target='#modalMain'><i class='fa-solid fa-pen-to-square'></i></button>
                                @role('Administrador')
                                <button id='btnDelete' data-id="${personal.id_rsdt}" class='btn p-0 btn-sm btn-primary' type='button' data-bs-toggle='modal' data-bs-target='#modalMain'><i class='fa-solid fa-trash'></i></button>
                                @endrole
                            </td>
                        </tr>
                    `;
                            });
                            html += `</tbody>`;
                            tableIndex.append(html);

                            // Llamar a la función para generar los botones de paginación
                            generatePaginationButtons(response.data.current_page, response.data
                                .last_page, url, search);
                            seccionTotalResultados.removeClass('d-none');
                        } else {
                            error.html('No se encontraron resultados.')
                            let paginationContainer = $('#pagination-container');
                            paginationContainer.empty();
                            seccionTotalResultados.addClass('d-none');
                        }
                    },
                    error: function(xhr, status, error) {
                        MostrarNotificacion('danger', xhr.responseText, 5);
                    }
                });
            }

            function store() {
                let formData = $('#rsdtForm').serialize();

                $.ajax({
                    url: urlStore,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.state) {
                            MostrarNotificacion('success', response.message, 5);
                            searchInput.val(response.data.ci_rsdt);
                            index(response.data.ci_rsdt);
                            modalMain.modal('hide');
                            setTimeout(function() {
                                searchInput.focus();
                            }, 700);
                        } else {
                            MostrarNotificacion('danger', response.message, 5);
                        }
                    },
                    error: function(xhr, status, error) {
                        MostrarNotificacion('danger', xhr.responseText, 5);
                    }
                });
            }

            function llenarFormulario(data) {
                let residente = data;
                $('#id_rsdt').val(residente.id_rsdt);
                $('#ci_rsdt').val(residente.ci_rsdt);
                $('#nombre_rsdt').val(residente.nombre_rsdt);
                $('#apellidop_rsdt').val(residente.apellidop_rsdt);
                $('#apellidom_rsdt').val(residente.apellidom_rsdt);
                $('#fechanac_rsdt').val(residente.fechanac_rsdt);
                $('#telefono_rsdt').val(residente.telefono_rsdt);
            }

            function show(id) {
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: urlShow + id,
                    type: 'GET',
                    data: {
                        _token: _token
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.state) {
                            llenarFormulario(response.data);
                            modalMain.modal('show');
                        } else {
                            MostrarNotificacion('danger', response.message, 5);
                        }
                    },
                    error: function(xhr, status, error) {
                        MostrarNotificacion('danger', xhr.responseText, 5);
                    }
                });
            }

            function update(id) {
                let formData = $('#rsdtForm').serialize();

                $.ajax({
                    url: urlUpdate + id,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.state) {
                            MostrarNotificacion('success', response.message, 5);
                            searchInput.val(response.data.ci_rsdt);
                            index(response.data.ci_rsdt);
                            modalMain.modal('hide');
                            setTimeout(function() {
                                searchInput.focus();
                            }, 700);
                        } else {
                            MostrarNotificacion('danger', response.message, 5);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Si hay un error en la solicitud AJAX, muestra el mensaje de error en la consola
                        MostrarNotificacion('danger', xhr.responseText, 5);
                    }
                });
            }

            function destroy(id) {
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: urlDelete + id,
                    type: 'DELETE',
                    data: {
                        _token: _token
                    },
                    success: function(response) {
                        if (response.state) {
                            MostrarNotificacion('success', response.message, 5);
                            searchInput.val('');
                            index();
                            modalMain.modal('hide');
                        } else {
                            MostrarNotificacion('danger', response.message, 5);
                        }
                    },
                    error: function(xhr, status, error) {
                        MostrarNotificacion('danger', xhr.responseText, 5);
                    }
                });
            }
            //#endregion

            //#region Interacción DOM
            //#region Funciones de Carga Inicial
            index();
            //#endregion

            //#region Busqueda
            searchInput.on('input', function() {
                index($(this).val());
            });

            $('#totalResultados').on('input', function() {
                index(searchInput.val());
            });
            //#endregion

            //#region Store
            btnCrud.click(function(e) {
                e.preventDefault();
                let action = $(this).attr('name');
                let id = $('#id_rsdt').val();
                switch (action) {
                    case "store": {
                        store();
                    }
                    break;
                    case "edit": {
                        update(id);
                    }
                    break;
                    case "delete": {
                        destroy(id);
                    }
                    break;
                }
            });
            //#endregion
            //#endregion

            //#region Activacion de botones de CRUD
            tableIndex.on('click', '#btnSelect', function() {
                let id = $(this).data('id');
                btnCrud.attr('name', 'show');
                btnCrud.text('Show');
                prepareSelect(id);
            });

            tableIndex.on('click', '#btnEdit', function() {
                let id = $(this).data('id');
                btnCrud.attr('name', 'edit');
                btnCrud.text('Editar');
                prepareEdit(id);
            });

            tableIndex.on('click', '#btnDelete', function() {
                let id = $(this).data('id');
                btnCrud.attr('name', 'delete');
                btnCrud.text('Eliminar');
                prepareDelete(id);
            });
            //#endregion

            //#region Configuracion en Modales
            $("#modalMain").on("shown.bs.modal", function() {

            });

            modalMain.on('hidden.bs.modal', function() {
                resetAllOnModal();
            });
            //#endregion
        });
    </script>
@endsection
