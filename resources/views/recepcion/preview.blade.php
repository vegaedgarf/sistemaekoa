<!-- Botones de Acción de la Vista Previa -->
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-secondary fw-bold">Vista Previa del Certificado</h4>
        <div>
            <!-- Formulario para enviar los datos finales al controlador -->
            <form action="{{ url('/recepcion/confirmar') }}" method="POST" id="formConfirmarGuardar" class="d-inline">
                @csrf
                
                <!-- Campos ocultos con los datos del cedente -->
                <input type="hidden" name="fecha" value="{{ $fecha ?? '' }}">
                <input type="hidden" name="nombre" value="{{ $nombre ?? '' }}">
                <input type="hidden" name="apellido" value="{{ $apellido ?? '' }}">
                <input type="hidden" name="dni" value="{{ $dni ?? '' }}">
                <input type="hidden" name="cuit" value="{{ $cuit ?? '' }}">
                <input type="hidden" name="mail_principal" value="{{ $mail_principal ?? '' }}">
                <input type="hidden" name="mail_secundario" value="{{ $mail_secundario ?? '' }}">
                
                <!-- Asegúrate de pasar también los detalles de los materiales como JSON o array -->
                <input type="hidden" name="detalles" value="{{ $detalles_json ?? '' }}">
                <input type="hidden" name="firmas" value="{{ $firmas ?? '' }}">
                <input type="hidden" name="peso_total_estimado" value="{{ $peso_total_estimado ?? 0 }}">

                <button type="button" class="btn btn-outline-secondary me-2" id="btnEditar" onclick="window.history.back();">
                    <i class="bi bi-pencil"></i> Volver a Edición
                </button>
                <button type="submit" class="btn btn-ekoa fw-bold" id="btnConfirmarYGuardar">
                    <i class="bi bi-check-circle"></i> Confirmar y Guardar
                </button>
            </form>
        </div>
    </div>

    <!-- Contenedor con formato de hoja A4 -->
    <div class="card shadow border-0 mx-auto" style="max-width: 800px;">
        <div class="card-body p-5 text-dark" style="background-color: #ffffff; font-family: 'Times New Roman', serif;">
            
            <!-- Encabezado del Certificado -->
            <div class="d-flex justify-content-between mb-4 fs-5">
                <div>La Plata, <span id="previewFecha" class="fw-bold">{{ isset($fecha) ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : '....../....../......' }}</span></div>
                <div class="fw-bold">N° <span id="previewNumero">A generar</span></div>
            </div>

            <h3 class="text-center fw-bold text-decoration-underline mb-4">CERTIFICADO DE RECEPCIÓNnnn</h3>

            <!-- Tabla de Materiales -->
            <table class="table table-bordered border-dark text-center align-middle mb-4">
                <thead class="table-light border-dark">
                    <tr>
                        <th class="border-dark w-25">Cantidad</th>
                        <th class="border-dark w-50">Descripción</th>
                        <th class="border-dark w-25">Peso(Kg)</th>
                    </tr>
                </thead>
                <tbody id="previewTablaBody">
                    <!-- Si envías los detalles desde el controlador, iteraríamos aquí con un @foreach -->
                    <!-- Si lo manejas por JS, mantén las filas en blanco -->
                    <tr><td></td><td>CPU</td><td></td></tr>
                    <tr><td></td><td>Gabinete</td><td></td></tr>
                    <tr><td></td><td>Notebook/Netbook</td><td></td></tr>
                    <tr><td></td><td>Monitor</td><td></td></tr>
                    <tr><td></td><td>Mouse</td><td></td></tr>
                    <tr><td></td><td>Teclado</td><td></td></tr>
                    <tr><td><br></td><td></td><td></td></tr>
                    <tr><td><br></td><td></td><td></td></tr>
                </tbody>
                <tfoot class="border-dark fw-bold">
                    <tr>
                        <td class="border-dark text-end">TOTAL CANTIDAD</td>
                        <td class="border-dark bg-light" id="previewTotalCant"></td>
                        <td class="border-dark border-0"></td>
                    </tr>
                    <tr>
                        <td class="border-dark text-end border-0"></td>
                        <td class="border-dark text-end">TOTAL KILOS</td>
                        <td class="border-dark bg-light" id="previewTotalPeso">{{ $peso_total_estimado ?? '' }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Declaraciones y Términos -->
            <p class="fs-5 text-justify mt-4 lh-base">
                Se certifica la recepción de los siguientes bienes entregados en carácter de cesión por parte de 
                <strong id="previewCedente">{{ $nombre ?? '...........................' }} {{ $apellido ?? '' }}</strong> 
                para ser destinados a los fines solidarios de EKOA (ambientales, sociales, educativos y culturales).
            </p>

            <p class="fs-5 mt-3 mb-5">
                El cedente declara que todos los bienes han sido adquiridos de buena fe.
            </p>

            <!-- Firmas EKOA -->
            <div class="row mt-5 text-center fs-6">
                <div class="col-6">
                    <hr class="border-dark w-75 mx-auto mb-1">
                    Firma Programa EKOA
                </div>
                <div class="col-6">
                    <hr class="border-dark w-75 mx-auto mb-1">
                    Aclaración
                </div>
            </div>

            <!-- Cuadro de Datos del Cedente -->
            <div class="mt-5 p-4 border border-2 border-dark">
                <h6 class="fw-bold text-center mb-5 text-uppercase">Datos de la PERSONA QUE ENTREGA el material al Programa EKOA</h6>
                
                <div class="row text-center mt-4">
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Firma Cedente
                    </div>
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Nombre y Apellido / Institución
                        <br>
                        <span class="fw-bold" id="previewNombreCedente">{{ $nombre ?? '' }} {{ $apellido ?? '' }}</span>
                    </div>
                </div>
                
                <div class="row text-center mt-5 mb-2">
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Email
                        <br>
                        <span class="fw-bold" id="previewEmail">
                            {{ $mail_principal ?? 'No especificado' }} 
                            @if(!empty($mail_secundario)) / {{ $mail_secundario }} @endif
                        </span>
                    </div>
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        DNI/CUIT
                        <br>
                        <span class="fw-bold" id="previewDoc">
                            @if(!empty($dni)) DNI: {{ $dni }} @endif
                            @if(!empty($dni) && !empty($cuit)) | @endif
                            @if(!empty($cuit)) CUIT: {{ $cuit }} @endif
                            @if(empty($dni) && empty($cuit)) No especificado @endif
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>