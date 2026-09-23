let categoriasGlobal = [];
let modalNotificacion;
let modalVistaPrevia;
let reloadOnModalClose = false;






document.addEventListener("DOMContentLoaded", () => {
    // Inicializar modales de Bootstrap
    const notifEl = document.getElementById('notificacionModal');
    const previewEl = document.getElementById('previewModal');

    if (notifEl && previewEl) {
        modalNotificacion = new bootstrap.Modal(notifEl);
        modalVistaPrevia = new bootstrap.Modal(previewEl);

        // Evento al cerrar el modal (para recargar la página en caso de éxito)
        notifEl.addEventListener('hidden.bs.modal', function () {
            if (reloadOnModalClose) {
                window.location.reload();
            }
        });
    }

    cargarCatalogosYInicializar();

    const btnAgregar = document.getElementById("btnAgregarFila");
    if (btnAgregar) {
        btnAgregar.addEventListener("click", (e) => {
            e.preventDefault();
            
            let selects = document.querySelectorAll('#tablaDetalles tbody .select-categoria');
            let todoSeleccionado = true;
            
            selects.forEach(select => {
                if (select.value === "") {
                    todoSeleccionado = false;
                }
            });

            if (!todoSeleccionado && selects.length > 0) {
                mostrarModal("Por favor, seleccione una categoría en todas las líneas actuales antes de agregar una nueva.", "Atención", "bg-warning", "text-dark");
                return;
            }

            agregarFila();
        });
    }

    const formRecepcion = document.getElementById("formRecepcion");
    if (formRecepcion) {
        formRecepcion.addEventListener("submit", (e) => {
            e.preventDefault();
            generarVistaPrevia();
        });
    }

    const btnConfirmarGuardar = document.getElementById("btnConfirmarGuardar");
    if (btnConfirmarGuardar) {
        btnConfirmarGuardar.addEventListener("click", async () => {
            btnConfirmarGuardar.disabled = true;
            await enviarFormulario();
            btnConfirmarGuardar.disabled = false;
        });
    }
});

// Función auxiliar para mostrar el Modal de notificaciones
function mostrarModal(mensaje, titulo = 'Aviso', bgClass = 'bg-primary', textClass = 'text-white', recargar = false) {
    document.getElementById('notificacionModalBody').innerHTML = mensaje;
    document.getElementById('notificacionModalLabel').innerHTML = titulo;
    
    let header = document.getElementById('modalHeaderStatus');
    header.className = `modal-header ${bgClass} ${textClass}`;
    
    reloadOnModalClose = recargar;
    modalNotificacion.show();
}

async function cargarCatalogosYInicializar() {
    try {
        let res = await fetch('/api/v1/catalogos/categorias', {
            headers: { 'Accept': 'application/json' }
        });
        let json = await res.json();
        categoriasGlobal = json.data || [];
    } catch (e) {
        console.error("Error al cargar catálogos:", e);
        categoriasGlobal = []; 
    }
    agregarFila();
}

function agregarFila() {
    let tbody = document.querySelector("#tablaDetalles tbody");
    if (!tbody) return;
    
    let index = Date.now(); 

    let opcionesCategorias = '<option value="">Seleccione categoría...</option>';
    if (Array.isArray(categoriasGlobal)) {
        opcionesCategorias += categoriasGlobal.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('');
    }

    let tr = document.createElement("tr");
    tr.innerHTML = `
        <td>
            <select class="form-select select-categoria" name="detalles[${index}][id_categoria]" required>
                ${opcionesCategorias}
            </select>
        </td>
        <td>
            <input type="number" class="form-control input-cantidad" name="detalles[${index}][cantidad_recibida]" value="1" min="1" required>
        </td>
        <td>
            <input type="number" step="0.01" min="0" class="form-control input-peso" name="detalles[${index}][peso_subtotal]" placeholder="0.00">
        </td>
        <td class="text-center">
            <input type="hidden" name="detalles[${index}][requiere_inventario]" value="0">
            <input class="form-check-input fs-5" type="checkbox" name="detalles[${index}][requiere_inventario]" value="1" checked>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    
    let selectCategoria = tr.querySelector('.select-categoria');
    selectCategoria.addEventListener('change', function() {
        validarCategoriaUnica(this);
    });

    tr.querySelector('.input-cantidad').addEventListener('input', recalcularTotales);
    tr.querySelector('.input-peso').addEventListener('input', recalcularTotales);
    
    tr.querySelector('.btn-eliminar').addEventListener('click', function() {
        tr.remove();
        recalcularTotales();
    });

    tbody.appendChild(tr);
    recalcularTotales();
}

function validarCategoriaUnica(selectElement) {
    if (!selectElement.value) return;
    
    let selects = document.querySelectorAll('.select-categoria');
    let contador = 0;
    
    selects.forEach(s => {
        if (s.value === selectElement.value) contador++;
    });

    if (contador > 1) {
        mostrarModal("Esta categoría ya fue agregada al comprobante. Modifique la cantidad en la fila existente.", "Categoría Duplicada", "bg-danger", "text-white");
        selectElement.value = ""; 
    }
}

function recalcularTotales() {
    let totalUnidades = 0;
    let totalPeso = 0;

    document.querySelectorAll('.input-cantidad').forEach(input => {
        totalUnidades += parseInt(input.value) || 0;
    });

    document.querySelectorAll('.input-peso').forEach(input => {
        totalPeso += parseFloat(input.value) || 0;
    });

    document.getElementById('total_unidades').value = totalUnidades;
    document.getElementById('peso_total_estimado').value = totalPeso.toFixed(2);
}

function generarVistaPrevia() {
    let rows = document.querySelectorAll("#tablaDetalles tbody tr");
    if (rows.length === 0) {
        mostrarModal("Agregue al menos una línea de detalle válida.", "Formulario Incompleto", "bg-warning", "text-dark");
        return;
    }

    let formData = new FormData(document.getElementById("formRecepcion"));
    
    let fechaCruda = formData.get('fecha'); 
    let partesFecha = fechaCruda.split('-');
    let fechaFormateada = `${partesFecha[2]}/${partesFecha[1]}/${partesFecha[0]}`; 
    
    document.getElementById('preview_fecha').innerText = fechaFormateada;
    document.getElementById('preview_nombre_cedente').innerText = formData.get('cedente').toUpperCase();

    let tbodyPreview = document.getElementById('preview_detalles');
    tbodyPreview.innerHTML = '';
    
    rows.forEach((row) => {
        let selectCat = row.querySelector('.select-categoria');
        let textoCategoria = selectCat.options[selectCat.selectedIndex]?.text || '';
        let cant = row.querySelector('.input-cantidad')?.value || '0';
        let peso = row.querySelector('.input-peso')?.value || '-';

        if (selectCat.value !== "") {
            tbodyPreview.innerHTML += `
                <tr>
                    <td>${cant}</td>
                    <td class="text-start">${textoCategoria}</td>
                    <td>${peso}</td>
                </tr>
            `;
        }
    });

    document.getElementById('preview_total_unidades').innerText = document.getElementById('total_unidades').value;
    document.getElementById('preview_total_peso').innerText = document.getElementById('peso_total_estimado').value;

    modalVistaPrevia.show();
}

async function enviarFormulario() {
    let form = document.getElementById("formRecepcion");
    let formData = new FormData(form);
    
    let data = {
        fecha: formData.get('fecha'),
        cedente: formData.get('cedente'),
        peso_total_estimado: parseFloat(document.getElementById('peso_total_estimado').value) || 0,
        firmas: formData.get('firmas'),
        detalles: []
    };

    let rows = document.querySelectorAll("#tablaDetalles tbody tr");
    rows.forEach((row) => {
        let cat = row.querySelector('.select-categoria')?.value;
        let cant = row.querySelector('.input-cantidad')?.value;
        let peso = row.querySelector('.input-peso')?.value;
        let reqInv = row.querySelector('input[type="checkbox"]')?.checked ? true : false;

        if (cat && cant) {
            data.detalles.push({
                id_categoria: parseInt(cat),
                cantidad_recibida: parseInt(cant),
                peso_subtotal: peso ? parseFloat(peso) : null,
                requiere_inventario: reqInv
            });
        }
    });

    try {
        let response = await fetch('/api/v1/comprobantes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

       // Leemos como texto puro primero para evitar que explote si Laravel devuelve HTML
        let responseText = await response.text();
        let result;
        
        try {
            result = JSON.parse(responseText);
        } catch (e) {
            console.error("El servidor falló y devolvió HTML:", responseText);
            modalVistaPrevia.hide();
            mostrarModal("Error crítico en el servidor (Revisar consola o logs de Laravel).", "Error 500", "bg-danger", "text-white");
            return;
        }

        modalVistaPrevia.hide();

        if (response.ok) {
            mostrarModal("¡Comprobante registrado con éxito en el sistema!", "Operación Exitosa", "bg-success", "text-white", true);
        } else {
            mostrarModal("Error de validación: " + (result.message || JSON.stringify(result.errors)), "Error al Guardar", "bg-danger", "text-white");
        }
    } catch (error) {
        console.error("Error al enviar:", error);
        modalVistaPrevia.hide();
        mostrarModal("Ocurrió un error de red al conectar con el servidor.", "Error de Conexión", "bg-danger", "text-white");
    }
}
