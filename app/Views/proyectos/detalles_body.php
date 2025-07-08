

<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">
<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <h5 class="text-center text my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a>
            </div>
            <h4 class="text-center py-3 m-0">Detalles del Proyecto</h4>
            <div></div>
        </div>

        <div class="main-panel">
            <div class="panel-header" style="border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                <h2><?= esc($proyecto['nombre']) ?></h2>
                <p class="text mb-0"><?= esc($proyecto['descripcion']) ?></p>
            </div>

           <div class="container-fluid mt-4">
                <div class="row">
                    <!-- COLUMNA 1: USUARIOS -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Información de Usuarios</h5>
                                <div class="stat-card mb-4">
                                    <h6>Usuarios Asignados</h6>
                                    <p class="fs-4 fw-bold"><?= esc($total_usuarios) ?></p>
                                </div>
                                <h6>Miembros del equipo:</h6>
                                <ul>
                                    <?= $html_lista_usuarios ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- COLUMNA 2: GRUPOS -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Información de Grupos</h5>
                                <div class="stat-card mb-4">
                                    <h6>Grupos Involucrados</h6>
                                    <p class="fs-4 fw-bold"><?= esc($total_grupos) ?></p>
                                </div>
                                <h6>Grupos del proyecto:</h6>
                                <ul>
                                    <?= $html_lista_grupos ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    
                </div><!-- Fin de .row -->
                <!-- COLUMNA 3: TAREAS (CORRECTA) -->
                    <br><div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Tareas del Proyecto</h5>
                                <div class="table-responsive">
                                    <table id="tabla-tareas-proyecto" class="table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tarea</th>
                                                <th>Estado</th>
                                                <th>Vencimiento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- DataTables llenará esta sección dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div><!-- Fin de .container-fluid -->
        </div>
    </div>
</div>