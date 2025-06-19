<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="panel-title mb-4 text-center">RECURSOS</h1>

<div class="data-panel mb-4">
    <div class="panel-header">
        <h2 class="me-3">IDENTIFICADOR DE USUARIOS</h2>
        <a href="#" class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Usuario</a>
        <div class="input-group ms-auto" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar Usuarios...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Código Usuario</th><th colspan="2">Nombre</th><th>Tipo Usuario</th><th>Proyecto Asignado</th><th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user['codigo']) ?></td>
                    <td style="width: 50px;"><img src="<?= base_url('assets/images/avatar.jpg'. esc($user['foto'])) ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;"></td>
                    <td><?= esc($user['nombre']) ?></td>
                    <td><?= esc($user['tipo']) ?></td>
                    <td><?= esc($user['proyecto']) ?></td>
                    <td class="text-center">
                        <a href="#" class="btn btn-success btn-sm">Ver</a>
                        <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                        <a href="#" class="btn btn-warning btn-sm text-dark">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </nav>
</div>

<div class="data-panel">
    <div class="panel-header">
        <h2 class="me-3">IDENTIFICADOR DE GRUPO</h2>
        <a href="#" class="btn btn-info btn-sm text-white"><i class="fas fa-plus me-1"></i> Añadir Grupo</a>
        <div class="input-group ms-auto" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar Grupo...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Código Grupo</th><th colspan="2">Nombre</th><th>Tipo Grupo</th><th>Proyecto Asignado</th><th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= esc($group['codigo']) ?></td>
                    <td style="width: 50px;"><img src="<?= base_url('assets/images/avatar.png' . esc($group['foto'])) ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;"></td>
                    <td><?= esc($group['nombre']) ?></td>
                    <td><?= esc($group['tipo']) ?></td>
                    <td><?= esc($group['proyecto']) ?></td>
                    <td class="text-center">
                        <a href="#" class="btn btn-success btn-sm">Ver</a>
                        <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
                        <a href="#" class="btn btn-warning btn-sm text-dark">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </nav>
</div>

<?= $this->endSection() ?>