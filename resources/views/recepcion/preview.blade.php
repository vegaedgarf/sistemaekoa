<!-- Botones de Acción de la Vista Previa -->
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-secondary fw-bold">Vista Previa del Certificado</h4>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2" id="btnEditar"><i class="bi bi-pencil"></i> Volver a Edición</button>
            <button type="button" class="btn btn-ekoa fw-bold" id="btnConfirmarYGuardar"><i class="bi bi-check-circle"></i> Confirmar y Generar PDF</button>
        </div>
    </div>

    <!-- Contenedor con formato de hoja A4 -->
    <div class="card shadow border-0 mx-auto" style="max-width: 800px;">
        <div class="card-body p-5 text-dark" style="background-color: #ffffff; font-family: 'Times New Roman', serif;">
            
            <!-- Encabezado del Certificado -->
            <div class="d-flex justify-content-between mb-4 fs-5">
                <div>La Plata, <span id="previewFecha" class="fw-bold">....../....../......</span>[cite: 1]</div>
                <div class="fw-bold">N° <span id="previewNumero">....................</span>[cite: 1]</div>
            </div>

            <h3 class="text-center fw-bold text-decoration-underline mb-4">CERTIFICADO DE RECEPCIÓN[cite: 1]</h3>

            <!-- Tabla de Materiales -->
            <table class="table table-bordered border-dark text-center align-middle mb-4">
                <thead class="table-light border-dark">
                    <tr>
                        <th class="border-dark w-25">Cantidad[cite: 1]</th>
                        <th class="border-dark w-50">Descripción[cite: 1]</th>
                        <th class="border-dark w-25">Peso(Kg)[cite: 1]</th>
                    </tr>
                </thead>
                <tbody id="previewTablaBody">
                    <!-- Filas base sugeridas en el documento -->
                    <tr><td></td><td>CPU[cite: 1]</td><td></td></tr>
                    <tr><td></td><td>Gabinete[cite: 1]</td><td></td></tr>
                    <tr><td></td><td>Notebook/Netbook[cite: 1]</td><td></td></tr>
                    <tr><td></td><td>Monitor[cite: 1]</td><td></td></tr>
                    <tr><td></td><td>Mouse[cite: 1]</td><td></td></tr>
                    <tr><td></td><td>Teclado[cite: 1]</td><td></td></tr>
                    <!-- Filas en blanco para completar visualmente -->
                    <tr><td><br></td><td></td><td></td></tr>
                    <tr><td><br></td><td></td><td></td></tr>
                </tbody>
                <tfoot class="border-dark fw-bold">
                    <tr>
                        <td class="border-dark text-end">TOTAL CANTIDAD[cite: 1]</td>
                        <td class="border-dark bg-light" id="previewTotalCant"></td>
                        <td class="border-dark border-0"></td>
                    </tr>
                    <tr>
                        <td class="border-dark text-end border-0"></td>
                        <td class="border-dark text-end">TOTAL KILOS[cite: 1]</td>
                        <td class="border-dark bg-light" id="previewTotalPeso"></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Declaraciones y Términos -->
            <p class="fs-5 text-justify mt-4 lh-base">
                Se certifica la recepción de los siguientes bienes entregados en carácter de cesión por parte de <strong id="previewCedente">..................................................................................................................................</strong> para ser destinados a los fines solidarios de EKOA (ambientales, sociales, educativos y culturales)[cite: 1].
            </p>

            <p class="fs-5 mt-3 mb-5">
                El cedente declara que todos los bienes han sido adquiridos de buena fe[cite: 1].
            </p>

            <!-- Firmas EKOA -->
            <div class="row mt-5 text-center fs-6">
                <div class="col-6">
                    <hr class="border-dark w-75 mx-auto mb-1">
                    Firma Programa EKOA[cite: 1]
                </div>
                <div class="col-6">
                    <hr class="border-dark w-75 mx-auto mb-1">
                    Aclaración[cite: 1]
                </div>
            </div>

            <!-- Cuadro de Datos del Cedente -->
            <div class="mt-5 p-4 border border-2 border-dark">
                <h6 class="fw-bold text-center mb-5 text-uppercase">Datos de la PERSONA QUE ENTREGA el material al Programa EKOA[cite: 1]</h6>
                
                <div class="row text-center mt-4">
                    <div class="col-4">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Firma[cite: 1]
                    </div>
                    <div class="col-4">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Institución/Organización Cedente[cite: 1]
                    </div>
                    <div class="col-4">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Transportista[cite: 1]
                    </div>
                </div>
                
                <div class="row text-center mt-5 mb-2">
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        Email[cite: 1]
                    </div>
                    <div class="col-6">
                        <hr class="border-dark w-75 mx-auto mb-1">
                        DNI/CUIT[cite: 1]
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>