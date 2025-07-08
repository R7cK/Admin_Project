<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


<div class="data-panel">
    
    <div class="panel-header" style="display: flex; align-items: center; gap: 1rem;">
        <a href="<?= site_url('ajustes') ?>" class="btn btn-light" title="Volver a Ajustes">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0">Master Data</h2>
    </div>

    <!-- Pestañas con el nuevo estilo -->
    <ul class="nav nav-tabs chrome-tabs mt-4" id="masterDataTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab">Roles de Usuario</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="estados-tab" data-bs-toggle="tab" data-bs-target="#estados" type="button" role="tab">Estados de Proyecto</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="prioridades-tab" data-bs-toggle="tab" data-bs-target="#prioridades" type="button" role="tab">Prioridades</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tipos-tarea-tab" data-bs-toggle="tab" data-bs-target="#tipos-tarea" type="button" role="tab">Tipos de Tarea</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tipos-costo-tab" data-bs-toggle="tab" data-bs-target="#tipos-costo" type="button" role="tab">Tipos de Costo</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="departamentos-tab" data-bs-toggle="tab" data-bs-target="#departamentos" type="button" role="tab">Departamentos</button>
        </li>
    </ul>

    <div class="tab-content" id="masterDataTabsContent">
        
        <div class="tab-pane fade show active p-3" id="roles" role="tabpanel">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Nuevo Rol</button>
            </div>
            <table id="tabla-roles" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre del Rol</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($roles)): foreach($roles as $rol): ?>
                    <tr>
                        <td><?= $rol['id'] ?></td>
                        <td><?= esc($rol['nombre']) ?></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade p-3" id="estados" role="tabpanel">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Nuevo Estado</button>
            </div>
             <table id="tabla-estados" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre del Estado</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($estados_proyecto)): foreach($estados_proyecto as $estado): ?>
                    <tr>
                        <td><?= $estado['id'] ?></td>
                        <td><?= esc($estado['nombre']) ?></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade p-3" id="prioridades" role="tabpanel">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Nueva Prioridad</button>
            </div>
             <table id="tabla-prioridades" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre de la Prioridad</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($prioridades)): foreach($prioridades as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= esc($p['nombre']) ?></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane fade p-3" id="tipos-tarea" role="tabpanel">
            <div class="d-flex justify-content-end mb-3"><button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Tipo de Tarea</button></div>
            <table id="tabla-tipos-tarea" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre del Tipo de Tarea</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($tipos_tarea)): foreach($tipos_tarea as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= esc($item['nombre']) ?></td>
                        <td class="text-end"><a href="#" class="btn btn-sm btn-outline-secondary">Editar</a> <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade p-3" id="tipos-costo" role="tabpanel">
            <div class="d-flex justify-content-end mb-3"><button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Tipo de Costo</button></div>
            <table id="tabla-tipos-costo" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre del Tipo de Costo</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($tipos_costo)): foreach($tipos_costo as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= esc($item['nombre']) ?></td>
                        <td class="text-end"><a href="#" class="btn btn-sm btn-outline-secondary">Editar</a> <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade p-3" id="departamentos" role="tabpanel">
            <div class="d-flex justify-content-end mb-3"><button class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Departamento</button></div>
            <table id="tabla-departamentos" class="table table-light-theme table-striped datatable-master" style="width:100%">
                <thead><tr><th>ID</th><th>Nombre del Departamento</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    <?php if (!empty($departamentos)): foreach($departamentos as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= esc($item['nombre']) ?></td>
                        <td class="text-end"><a href="#" class="btn btn-sm btn-outline-secondary">Editar</a> <a href="#" class="btn btn-sm btn-outline-danger">Eliminar</a></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts para DataTables (jQuery y JS de DataTables) -->
<!-- Nota: jQuery es un requisito para DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar todas las tablas con la clase 'datatable-master'
        $('.datatable-master').DataTable({
            // Configuración para poner DataTables en español
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            "responsive": true,
            "autoWidth": false
        });

        // El script original para activar la funcionalidad de las pestañas de Bootstrap.
        // No es necesario modificarlo.
        var triggerTabList = [].slice.call(document.querySelectorAll('#masterDataTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        });
    });
</script>

<?= $this->endSection() ?>