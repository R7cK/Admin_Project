<div class="container-fluid">

    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" id="titulo-pagina">Crear Tarea</h1>
        <!-- Mensaje de estado para el usuario -->
        <span id="estado-guardado" class="text-muted font-italic"></span>
    </div>

    <!-- El form ya no se envía, solo agrupa los campos -->
    <form id="form-tarea" onsubmit="return false;">
        <!-- Campo oculto para simular el guardado de un ID de tarea -->
        <input type="hidden" id="tarea_id" value="">
    
        <div class="row">

            <!-- Columna Izquierda: Información de la Tarea -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Información de la Tarea</h6>
                    </div>
                    <div class="card-body">
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="tar_nom">Nombre de la Historia / Tarea</label>
                            <input type="text" name="tar_nom" class="form-control" id="tar_nom" placeholder="Ej: Como usuario, quiero poder...">
                        </div>
                        <div class="form-group">
                            <label for="tar_desc">Descripción Detallada</label>
                            <textarea class="form-control" name="tar_desc" id="tar_desc" rows="5" placeholder="Describe los criterios de aceptación y detalles funcionales."></textarea>
                        </div>
                        <!-- ... (resto de campos se mantienen igual) ... -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="solicitado_por_usuario_id">Solicitado por</label>
                                    <select class="form-control" name="solicitado_por_usuario_id" id="solicitado_por_usuario_id">
                                        <option selected disabled>-- Seleccionar un usuario --</option>
                                        <option value="1">Ricardo Chab Pool</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_creacion">Fecha de Registro</label>
                                    <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Agregar Criterios -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Criterios de Aceptación</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="criterio_desc">Descripción del Criterio</label>
                            <textarea class="form-control" id="criterio_desc" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="criterio_puntos">Puntos de Esfuerzo</label>
                            <input type="number" class="form-control" id="criterio_puntos" step="1" min="0">
                        </div>
                        <button type="button" id="btn-agregar-criterio" class="btn btn-info btn-icon-split btn-sm">
                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                            <span class="text">Agregar Criterio y Guardar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Criterios Agregados -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Criterios Agregados</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Descripción del Criterio (Haz clic para editar)</th>
                                <th width="100px">Puntos</th>
                                <th width="100px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="lista-criterios-body">
                            <!-- Los criterios se agregarán aquí dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="text-center mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar al Panel de Administrador
                    </a>
                </div>
<!-- =============================================================== -->
<!-- SCRIPT PARA LA SIMULACIÓN EN VISTA (SIN BACKEND) -->
<!-- =============================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- VARIABLES DE ESTADO (NUESTRA "BASE DE DATOS" SIMULADA) ---
    let tareaId = null; // Si es null, la tarea no se ha "guardado".
    let proximoCriterioId = 1; // Un contador para dar IDs únicos a cada criterio.

    // --- REFERENCIAS A ELEMENTOS DEL DOM ---
    const btnAgregarCriterio = document.getElementById('btn-agregar-criterio');
    const tablaCriteriosBody = document.getElementById('lista-criterios-body');
    const estadoGuardado = document.getElementById('estado-guardado');
    const tituloPagina = document.getElementById('titulo-pagina');
    
    // Función para mostrar mensajes de estado al usuario
    const mostrarEstado = (mensaje, tiempo = 3000) => {
        estadoGuardado.textContent = mensaje;
        setTimeout(() => { estadoGuardado.textContent = ''; }, tiempo);
    };

    // 1. FUNCIÓN PARA AGREGAR UN CRITERIO Y "GUARDAR" LA TAREA
    const procesarNuevoCriterio = () => {
        const criterioDescInput = document.getElementById('criterio_desc');
        const criterioPuntosInput = document.getElementById('criterio_puntos');
        const nombreTareaInput = document.getElementById('tar_nom');

        const descripcion = criterioDescInput.value.trim();
        const puntos = criterioPuntosInput.value.trim();
        const nombreTarea = nombreTareaInput.value.trim();

        // Validación: el nombre de la tarea y el primer criterio son obligatorios
        if (!tareaId && (nombreTarea === '' || descripcion === '' || puntos === '')) {
            alert('Para guardar la tarea, el Nombre de la Tarea, la Descripción del Criterio y los Puntos son obligatorios.');
            return;
        }
        if (tareaId && (descripcion === '' || puntos === '')) {
            alert('La Descripción del Criterio y los Puntos son obligatorios.');
            return;
        }
        
        // --- LÓGICA DE GUARDADO AUTOMÁTICO ---
        if (!tareaId) {
            // Es el primer criterio, así que "creamos" la tarea.
            // Simulamos obtener un ID para la tarea (podría ser un timestamp).
            tareaId = new Date().getTime(); 
            document.getElementById('tarea_id').value = tareaId;

            // Cambiamos la UI para reflejar el estado "guardado"
            tituloPagina.textContent = 'Editar Tarea';
            mostrarEstado('¡Tarea guardada exitosamente!');
        } else {
            // La tarea ya existe, solo mostramos un mensaje simple.
            mostrarEstado('Criterio agregado.');
        }

        // Añadimos la fila a la tabla con su ID simulado
        agregarFilaCriterio(descripcion, puntos, proximoCriterioId);
        proximoCriterioId++; // Incrementamos el ID para el siguiente

        // Limpiamos los campos para el siguiente criterio
        criterioDescInput.value = '';
        criterioPuntosInput.value = '';
        criterioDescInput.focus();
    };
    
    // Función auxiliar que crea la fila <tr> en la tabla
    const agregarFilaCriterio = (descripcion, puntos, criterioId) => {
        const nuevaFila = document.createElement('tr');
        // Usamos un 'data-attribute' para guardar el ID del criterio en el HTML. Es clave para editar/eliminar.
        nuevaFila.setAttribute('data-criterio-id', criterioId);
        
        nuevaFila.innerHTML = `
            <td class="editable">${descripcion}</td>
            <td class="text-center">${puntos}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-circle btn-sm btn-eliminar-criterio">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tablaCriteriosBody.appendChild(nuevaFila);
    };

    // 2. FUNCIÓN PARA EDICIÓN EN LÍNEA Y ELIMINACIÓN (usando delegación de eventos)
    tablaCriteriosBody.addEventListener('click', function(event) {
        const target = event.target;
        
        // --- Lógica para Editar ---
        if (target.classList.contains('editable') && !target.querySelector('input')) {
            const currentText = target.textContent;
            
            // Reemplazamos el texto por un campo de entrada
            target.innerHTML = `<input type="text" class="form-control form-control-sm" value="${currentText}" />`;
            const input = target.querySelector('input');
            input.focus();
            
            // Función para "guardar" el cambio
            const guardarCambio = () => {
                const newText = input.value.trim();
                // Si el texto es válido y diferente, lo actualizamos
                if (newText && newText !== currentText) {
                    target.textContent = newText;
                    mostrarEstado('Criterio actualizado.');
                } else {
                    // Si no, revertimos al texto original
                    target.textContent = currentText;
                }
            };
            
            // Eventos para salir del modo de edición
            input.addEventListener('blur', guardarCambio); // Cuando pierde el foco
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') input.blur(); // Con Enter, guarda
                if (e.key === 'Escape') target.textContent = currentText; // Con Escape, cancela
            });
        }
        
        // --- Lógica para Eliminar ---
        const btnEliminar = target.closest('.btn-eliminar-criterio');
        if (btnEliminar) {
            if (confirm('¿Estás seguro de que quieres eliminar este criterio?')) {
                const fila = btnEliminar.closest('tr');
                fila.remove();
                mostrarEstado('Criterio eliminado.');

                // Condición extra: si se eliminan todos los criterios, la tarea vuelve al estado "no guardado"
                if (tablaCriteriosBody.childElementCount === 0) {
                    tareaId = null;
                    document.getElementById('tarea_id').value = '';
                    tituloPagina.textContent = 'Crear Tarea';
                    mostrarEstado('Todos los criterios eliminados. La tarea ya no está guardada.');
                }
            }
        }
    });

    // Asignar el evento principal al botón
    btnAgregarCriterio.addEventListener('click', procesarNuevoCriterio);
});
</script>