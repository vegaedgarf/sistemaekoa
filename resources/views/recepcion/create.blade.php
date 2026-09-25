@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-ekoa text-white py-3">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-file-earmark-plus"></i> Nuevo Comprobante de Recepción</h4>
                </div>
                <div class="card-body p-4">
                    <form id="formRecepcion">
                        @csrf
                        
                        <!-- Sección: Datos Generales -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Fecha de Ingreso</label>
                                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-ekoa">Total de Unidades</label>
                                <input type="number" class="form-control bg-light fw-bold text-ekoa" id="total_unidades" readonly value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-ekoa">Peso Total (kg)</label>
                                <input type="number" step="0.01" class="form-control bg-light fw-bold text-ekoa" name="peso_total_estimado" id="peso_total_estimado" readonly value="0.00">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Sección: Datos del Cedente -->
                        <h5 class="fw-bold text-secondary mb-3">Datos del Cedente</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la persona o institución" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label fw-bold">Apellido *</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dni" class="form-label fw-bold">DNI</label>
                                <input type="number" class="form-control" id="dni" name="dni" placeholder="Opcional">
                            </div>
                            <div class="col-md-6">
                                <label for="cuit" class="form-label fw-bold">CUIT</label>
                                <input type="text" class="form-control" id="cuit" name="cuit" placeholder="Opcional">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mail_principal" class="form-label fw-bold">Email Principal</label>
                                <input type="email" class="form-control" id="mail_principal" name="mail_principal" placeholder="correo@ejemplo.com">
                            </div>
                            <div class="col-md-6">
                                <label for="mail_secundario" class="form-label fw-bold">Email Secundario</label>
                                <input type="email" class="form-control" id="mail_secundario" name="mail_secundario" placeholder="Opcional">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Sección: Detalle de Materiales -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-secondary mb-0">Detalle de Materiales Ingresados</h5>
                            <button type="button" class="btn btn-outline-success btn-sm fw-bold" id="btnAgregarFila">
                                <i class="bi bi-plus-circle"></i> Agregar Línea
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tablaDetalles">
                                <thead class="table-light">
                                    <tr>
                                        <th>Categoría</th>
                                        <th style="width: 130px;">Cantidad</th>
                                        <th style="width: 150px;">Peso Subtotal (kg)</th>
                                        <th style="width: 150px;" class="text-center">A Inventario?</th>
                                        <th style="width: 60px;" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se agregan dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Firmas / Observaciones</label>
                            <textarea class="form-control" name="firmas" rows="2" placeholder="Detalles de entrega..."></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-ekoa px-5 py-2 fw-bold">Generar Vista Previa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dinámico de Alertas -->
<!-- Modal de Vista Previa del Certificado -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-secondary"><i class="bi bi-printer"></i> Vista Previa del Certificado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Contenedor formateado para impresión -->
            <div class="modal-body p-5" id="certificadoPrintable" style="font-family: Arial, sans-serif; color: #000;">
                
                <!-- Nuevo Encabezado con Logotipos -->
                <div class="row mb-4 pb-3 border-bottom border-dark align-items-center">
                    <div class="col-12 text-center">
                        <img src="{{ asset('images/imagen.png') }}" alt="Programa EKOA - Universidad Nacional de La Plata" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <span>La Plata, <span id="preview_fecha" class="fw-bold"></span></span>
                    <span>N° <span class="fw-bold">A generar</span></span>
                </div>
                
                <h4 class="text-center fw-bold mb-4">CERTIFICADO DE RECEPCIÓN</h4>
                
                <table class="table table-bordered border-dark text-center align-middle" style="border-color: #000 !important;">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Cantidad</th>
                            <th style="width: 70%;">Descripción</th>
                            <th style="width: 15%;">Peso (Kg)</th>
                        </tr>
                    </thead>
                    <tbody id="preview_detalles">
                        <!-- Líneas inyectadas por JS -->
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td id="preview_total_unidades"></td>
                            <td class="text-end">TOTAL KILOS</td>
                            <td id="preview_total_peso"></td>
                        </tr>
                    </tfoot>
                </table>

                <p class="mt-4 lh-base text-justify">
                    Se certifica la recepción de los siguientes bienes entregados en carácter de cesión por parte de <strong id="preview_nombre_cedente"></strong> para ser destinados a los fines solidarios de EKOA (ambientales, sociales, educativos y culturales).
                </p>

                <p class="fw-bold mt-3">
                    El cedente declara que todos los bienes han sido adquiridos de buena fe.
                </p>

                <!-- Bloque de Firmas -->
                <div class="row mt-5 pt-3 text-center">
                    <div class="col-6">
                        <hr style="border-top: 1px solid #000; width: 80%; margin: 0 auto 10px auto;">
                        <span class="d-block">Firma Programa EKOA</span>
                        <span class="d-block">Aclaración</span>
                    </div>
                    <div class="col-6">
                        <hr style="border-top: 1px solid #000; width: 80%; margin: 0 auto 10px auto;">
                        <span class="d-block">Firma Cedente</span>
                    </div>
                </div>

                <div class="mt-5 border border-dark p-3">
                    <h6 class="fw-bold text-center mb-3">Datos de la PERSONA QUE ENTREGA el material al Programa EKOA</h6>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <strong>Nombre y Apellido:</strong> <br>
                            <span id="preview_modal_nombre" class="d-inline-block w-100 mt-2" style="border-bottom: 1px solid #000; min-height: 20px;"></span>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Email:</strong> <br>
                            <span id="preview_modal_email" class="d-inline-block w-100 mt-2" style="border-bottom: 1px solid #000; min-height: 20px;"></span>
                        </div>
                        <div class="col-6">
                            <strong>DNI/CUIT:</strong> <br>
                            <span id="preview_modal_doc" class="d-inline-block w-100 mt-2" style="border-bottom: 1px solid #000; min-height: 20px;"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between bg-light border-0">
                <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Editar Datos</button>
                <button type="button" class="btn btn-ekoa px-4 fw-bold" id="btnConfirmarGuardar">Confirmar y Grabar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dinámico de Alertas / Notificaciones -->
<div class="modal fade" id="notificacionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" id="modalHeaderStatus">
                <h5 class="modal-title fw-bold" id="notificacionModalLabel">Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificacionModalBody">
                <!-- Mensaje inyectado por JS -->
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @vite(['resources/js/comprobantes/crear.js'])
@endpush
