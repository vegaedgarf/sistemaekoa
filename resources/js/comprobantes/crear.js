document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRecepcion');
    const btnAgregarFila = document.getElementById('btnAgregarFila');
    const tablaDetallesBody = document.querySelector('#tablaDetalles tbody');
    
    // Inicialización de Modales de Bootstrap 5
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    const notificacionModal = new bootstrap.Modal(document.getElementById('notificacionModal'));
    
    let rowCount = 0;

    // Catálogo simulado de categorías (idealmente esto se puede consumir del endpoint GET /api/v1/catalogos/categorias)
    const categorias = [
        { id: 1, nombre: 'CPU' },
        { id: 2, nombre: 'Notebook/Netbook' },
        { id: 3, nombre: 'Monitor' },
        { id: 4, nombre: 'Periféricos (Mouse/Teclado)' },
        { id: 5, nombre: 'Componentes Internos' },
        { id: 6, nombre: 'Varios / Chatarra Electrónica' }
    ];

    // 1. GESTIÓN DINÁMICA DE FILAS
    function agregarFila() {
        rowCount++;
        let options = categorias.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('');
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select class="form-select cat-select" required>
                    <option value="">Seleccione...</option>
                    ${options}
                </select>
            </td>
            <td>
                <input type="number" class="form-control cant-input text-center" min="1" value="1" required>
            </td>
            <td>
                <input type="number" step="0.01" class="form-control peso-input text-center" placeholder="0.00">
            </td>
            <td class="text-center">
                <input class="form-check-input inv-check mt-2" type="checkbox" value="1" checked>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm btnEliminarFila"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tablaDetallesBody.appendChild(tr);
        calcularTotales();
    }

    // Delegación de eventos para la tabla
    tablaDetallesBody.addEventListener('click', function(e) {
        if (e.target.closest('.btnEliminarFila')) {
            e.target.closest('tr').remove();
            calcularTotales();
        }
    });

    tablaDetallesBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('cant-input') || e.target.classList.contains('peso-input')) {
            calcularTotales();
        }
    });

    function calcularTotales() {
        let totalCant = 0;
        let totalPeso = 0;
        
        document.querySelectorAll('.cant-input').forEach(input => {
            totalCant += parseInt(input.value) || 0;
        });
        
        document.querySelectorAll('.peso-input').forEach(input => {
            totalPeso += parseFloat(input.value) || 0;
        });

        document.getElementById('total_unidades').value = totalCant;
        document.getElementById('peso_total_estimado').value = totalPeso.toFixed(2);
    }

    // Agregar primera fila por defecto al cargar
    btnAgregarFila.addEventListener('click', agregarFila);
    agregarFila();

    // 2. GENERACIÓN DE VISTA PREVIA
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (tablaDetallesBody.children.length === 0) {
            mostrarNotificacion('Validación', 'Debe agregar al menos un material al detalle.');
            return;
        }

        // Obtener valores del formulario
        const nombre = document.getElementById('nombre').value;
        const apellido = document.getElementById('apellido').value;
        const dni = document.getElementById('dni').value;
        const cuit = document.getElementById('cuit').value;
        const email1 = document.getElementById('mail_principal').value;
        const email2 = document.getElementById('mail_secundario').value;

        // Inyectar datos al Modal
        const fechaInversa = document.getElementById('fecha').value.split('-').reverse().join('/');
        document.getElementById('preview_fecha').textContent = fechaInversa;
        document.getElementById('preview_nombre_cedente').textContent = `${nombre} ${apellido}`;
        document.getElementById('preview_modal_nombre').textContent = `${nombre} ${apellido}`;
        
        // Formateo condicional de opcionales
        document.getElementById('preview_modal_email').textContent = email1 
            ? `${email1} ${email2 ? ' / ' + email2 : ''}` 
            : 'No especificado';
            
        let docText = [];
        if(dni) docText.push(`DNI: ${dni}`);
        if(cuit) docText.push(`CUIT: ${cuit}`);
        document.getElementById('preview_modal_doc').textContent = docText.length > 0 ? docText.join(' | ') : 'No especificado';

        // Procesar tabla de materiales para la vista previa
        const previewTabla = document.getElementById('preview_detalles');
        previewTabla.innerHTML = '';
        
        document.querySelectorAll('#tablaDetalles tbody tr').forEach(row => {
            const select = row.querySelector('.cat-select');
            const catNombre = select.options[select.selectedIndex].text;
            const cant = row.querySelector('.cant-input').value;
            const peso = row.querySelector('.peso-input').value;

            previewTabla.innerHTML += `<tr>
                <td>${cant}</td>
                <td class="text-start ps-3">${catNombre}</td>
                <td>${peso || '-'}</td>
            </tr>`;
        });

        // Copiar totales
        document.getElementById('preview_total_unidades').textContent = document.getElementById('total_unidades').value;
        document.getElementById('preview_total_peso').textContent = document.getElementById('peso_total_estimado').value;

        previewModal.show();
    });

    // 3. CONFIRMAR Y GRABAR (AJAX POST)
    document.getElementById('btnConfirmarGuardar').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

        // Construir el array de detalles
        const detalles = [];
        document.querySelectorAll('#tablaDetalles tbody tr').forEach(row => {
            detalles.push({
                id_categoria: parseInt(row.querySelector('.cat-select').value),
                cantidad_recibida: parseInt(row.querySelector('.cant-input').value),
                peso_subtotal: parseFloat(row.querySelector('.peso-input').value) || null,
                requiere_inventario: row.querySelector('.inv-check').checked
            });
        });

        // Construir el Payload Principal
        const payload = {
            fecha: document.getElementById('fecha').value,
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            dni: document.getElementById('dni').value || null,
            cuit: document.getElementById('cuit').value || null,
            mail_principal: document.getElementById('mail_principal').value || null,
            mail_secundario: document.getElementById('mail_secundario').value || null,
            peso_total_estimado: parseFloat(document.getElementById('peso_total_estimado').value) || null,
            firmas: document.querySelector('textarea[name="firmas"]').value || null,
            detalles: detalles
        };

        const csrfToken = document.querySelector('input[name="_token"]').value;

        // Petición a la API de Laravel
        fetch('/api/v1/comprobantes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                // Manejar errores de validación de Laravel (422) o de servidor (500)
                throw new Error(data.message || 'Error al procesar la solicitud');
            }
            return data;
        })
        .then(data => {
            previewModal.hide();
            mostrarNotificacion('¡Éxito!', `${data.message}<br><strong>Nro de Comprobante: ${data.data.nro_comprobante}</strong>`);
            
            // Limpiar y resetear el formulario para una nueva carga
            form.reset();
            tablaDetallesBody.innerHTML = '';
            agregarFila();
            calcularTotales();
        })
        .catch(error => {
            previewModal.hide();
            mostrarNotificacion('Error', error.message);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Confirmar y Grabar';
        });
    });

    // Función auxiliar para notificaciones
    function mostrarNotificacion(titulo, mensaje) {
        document.getElementById('notificacionModalLabel').textContent = titulo;
        document.getElementById('notificacionModalBody').innerHTML = `<p class="mb-0 fs-5 text-center">${mensaje}</p>`;
        notificacionModal.show();
    }
});