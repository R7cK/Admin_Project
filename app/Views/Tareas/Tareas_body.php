<body>

<div class="main-container">
    
    <aside class="sidebar d-none d-lg-block">
        <div class="sidebar-header">
            AdminProject
        </div>
        <nav class="sidebar-nav mt-3">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>" class="active"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="text-center py-3 m-0 flex-grow-1">
                Gestión de Tareas
            </h4>
        </div>

        <div class="main-panel">
            <div class="panel-header mb-4">
                <div class="flex-grow-1">
                    <h5 class="m-0">Proyecto: Actualización ERP 2025</h5>
                </div>
                <div class="user-profile">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-envelope"></i>
                    <img src="https://i.pravatar.cc/40?u=ricardo" alt="User Avatar">
                    <div class="user-info">
                        <strong>Ricardo Chab</strong><br>
                        <small>Administrador</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Añadir Nueva Tarea
                </button>
            </div>

            <table class="table task-table">
                <thead>
                    <tr>
                        <th>Tarea</th>
                        <th>Asignado a</th>
                        <th>Fecha Límite</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Diseñar la interfaz de usuario del módulo</td>
                        <td>Ana Pérez</td>
                        <td>30/08/2025</td>
                        <td><span class="status-badge status-en-progreso">En Progreso</span></td>
                        <td><a href="#" class="text-light"><i class="fas fa-edit"></i></a> <a href="#" class="text-light ms-2"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>Desarrollar la lógica de negocio del backend</td>
                        <td>Lucas Gonzalez</td>
                        <td>15/09/2025</td>
                        <td><span class="status-badge status-completada">Completada</span></td>
                        <td><a href="#" class="text-light"><i class="fas fa-edit"></i></a> <a href="#" class="text-light ms-2"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>Realizar pruebas de integración</td>
                        <td>Equipo QA</td>
                        <td>25/09/2025</td>
                        <td><span class="status-badge status-pendiente">Pendiente</span></td>
                        <td><a href="#" class="text-light"><i class="fas fa-edit"></i></a> <a href="#" class="text-light ms-2"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-center py-3 text-muted">No hay más tareas.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
            <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('recursos') ?>"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="<?= site_url('tareas') ?>"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>