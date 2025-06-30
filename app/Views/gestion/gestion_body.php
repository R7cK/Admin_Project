<body class="<?= ($settings['default_theme'] ?? 'light') === 'dark' ? 'theme-dark' : 'theme-light' ?>">

<div class="main-container">
    <aside class="sidebar d-none d-lg-block">
        <h5 class="text-center my-3" style="color: var(--sidebar-header-text);">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="<?= site_url('dashboard') ?>"><i class="fas fa-home"></i> INICIO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        <h4 class="text-center py-3 m-0 flex-grow-1">Gestión de Usuarios y Grupos</h4>

        <div class="main-panel">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="view_type" id="show-users" value="users" checked>
                    <label class="btn btn-outline-secondary" for="show-users">Usuarios</label>
                    <input type="radio" class="btn-check" name="view_type" id="show-groups" value="groups">
                    <label class="btn btn-outline-secondary" for="show-groups">Grupos</label>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-download me-2"></i>Download CSV</button>
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-upload me-2"></i>Export</button>
                    <button class="btn btn-secondary btn-custom"><i class="fas fa-download me-2"></i>Import</button>
                    
                    <button id="btn-add-user" class="btn btn-add btn-custom" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus me-2"></i>Añadir Usuario</button>
                    <button id="btn-add-group" class="btn btn-add btn-custom" data-bs-toggle="modal" data-bs-target="#addGroupModal" style="display: none;"><i class="fas fa-plus me-2"></i>Añadir Grupo</button>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div id="user-table">
                <h5 class="mb-3">Todos los Usuarios</h5>
                <div class="table-responsive">
                    <table class="table project-table">
                        <thead><tr><th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Rol</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
                        <tbody>
                            <?php if (!empty($usuarios)): foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?= esc($user['Id_usuario']) ?></td>
                                <td><?= esc($user['Nombre'] . ' ' . $user['Apellido_Paterno']) ?></td>
                                <td><?= esc($user['Correo']) ?></td>
                                <td><?= esc($user['Rol']) ?></td>
                                <td><span class="badge <?= $user['Estado'] ? 'bg-success' : 'bg-secondary' ?>"><?= $user['Estado'] ? 'Activo' : 'Inactivo' ?></span></td>
                                <td class="text-end table-actions">...</td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="6" class="text-center">No hay usuarios en la base de datos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar al Panel de Administrador
                    </a>
                </div>

            </div>

            <div id="group-table" style="display: none;">
                <h5 class="mb-3">Todos los Grupos</h5>
                <div class="table-responsive">
                    <table class="table project-table">
                        <thead><tr><th>ID</th><th>Nombre del Grupo</th><th>Descripción</th><th class="text-end">Acciones</th></tr></thead>
                        <tbody>
                            <?php if (!empty($grupos)): foreach ($grupos as $group): ?>
                            <tr>
                                <td><?= esc($group['GPO_ID']) ?></td>
                                <td><?= esc($group['GPO_NOM']) ?></td>
                                <td><?= esc($group['GPO_DESC']) ?></td>
                                <td class="text-end table-actions">...</td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="4" class="text-center">No hay grupos en la base de datos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar al Panel de Administrador
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addUserForm" action="<?= site_url('/gestion/usuarios/crear') ?>" method="POST" class="needs-validation" novalidate>
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Para guardar un nuevo usuario, es necesario llenar todos los datos requeridos.
                    </div>
                    <div id="addUserErrorAlert" class="alert alert-danger" role="alert" style="display: none;">
                        No se puede continuar. Por favor, llene todos los campos obligatorios.
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="addUserNombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="addUserNombre" name="Nombre" class="form-control" required>
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="addUserPaterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" id="addUserPaterno" name="Apellido_Paterno" class="form-control" required>
                            <div class="invalid-feedback">El apellido paterno es obligatorio.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="addUserMaterno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                            <input type="text" id="addUserMaterno" name="Apellido_Materno" class="form-control" required>
                            <div class="invalid-feedback">El apellido materno es obligatorio.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="addUserCorreo" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="addUserCorreo" name="Correo" class="form-control" required>
                            <div class="invalid-feedback">Por favor, ingresa un correo válido.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="addUserCodigo" class="form-label">Código de Usuario <span class="text-danger">*</span></label>
                            <input type="number" id="addUserCodigo" name="Codigo_User" class="form-control" required>
                            <div class="invalid-feedback">El código es obligatorio.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="addUserPass" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" id="addUserPass" name="Password" class="form-control" required>
                            <div class="invalid-feedback">La contraseña es obligatoria.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="addUserRol" class="form-label">Rol</label>
                            <select name="Rol" id="addUserRol" class="form-select"><option value="administrador">Administrador</option><option value="capturista">Capturista</option></select>
                        </div>
                    </div>
                     <div class="form-group mb-3">
                         <label for="addUserEstado" class="form-label">Estado</label>
                         <select name="Estado" id="addUserEstado" class="form-select"><option value="1">Activo</option><option value="0">Inactivo</option></select>
                     </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
             <form id="addGroupForm" action="<?= site_url('/gestion/grupos/crear') ?>" method="POST" class="needs-validation" novalidate>
                <?= csrf_field() ?>
                <div class="modal-header"><h5 class="modal-title">Añadir Nuevo Grupo</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Para guardar un nuevo grupo, es necesario llenar todos los datos requeridos.
                    </div>
                    <div id="addGroupErrorAlert" class="alert alert-danger" role="alert" style="display: none;">
                        No se puede continuar. Por favor, llene todos los campos obligatorios.
                    </div>
                    <div class="mb-3">
                        <label for="addGroupName" class="form-label">Nombre del Grupo <span class="text-danger">*</span></label>
                        <input type="text" id="addGroupName" name="GPO_NOM" class="form-control" required>
                        <div class="invalid-feedback">El nombre del grupo es obligatorio.</div>
                    </div>
                    <div class="mb-3">
                        <label for="addGroupDesc" class="form-label">Descripción</label>
                        <textarea id="addGroupDesc" name="GPO_DESC" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Lógica para alternar vistas (Usuarios/Grupos) ---
    const userTable = document.getElementById('user-table');
    const groupTable = document.getElementById('group-table');
    const showUsersBtn = document.getElementById('show-users');
    const showGroupsBtn = document.getElementById('show-groups');
    const addUserBtn = document.getElementById('btn-add-user');
    const addGroupBtn = document.getElementById('btn-add-group');

    function toggleElements() {
        const isUsersView = showUsersBtn.checked;
        userTable.style.display = isUsersView ? 'block' : 'none';
        groupTable.style.display = isUsersView ? 'none' : 'block';
        addUserBtn.style.display = isUsersView ? 'inline-block' : 'none';
        addGroupBtn.style.display = isUsersView ? 'none' : 'inline-block';
    }

    showUsersBtn.addEventListener('change', toggleElements);
    showGroupsBtn.addEventListener('change', toggleElements);
    toggleElements(); // Estado inicial

    // --- Lógica para los modales ---

    // --- Modal de Añadir Usuario ---
    const addUserModal = document.getElementById('addUserModal');
    const addUserForm = document.getElementById('addUserForm');
    const addUserErrorAlert = document.getElementById('addUserErrorAlert');

    // 1. Lógica para el botón Guardar
    addUserForm.addEventListener('submit', function(event) {
        // Si el formulario no es válido
        if (!addUserForm.checkValidity()) {
            event.preventDefault(); // Previene el envío del formulario
            event.stopPropagation();
            addUserErrorAlert.style.display = 'block'; // Muestra la alerta de error
        } else {
            // Si el formulario es válido, nos aseguramos que la alerta esté oculta
            addUserErrorAlert.style.display = 'none';
        }
        // Añade la clase de Bootstrap para mostrar los mensajes de validación de cada campo
        addUserForm.classList.add('was-validated');
    });

    // 2. Lógica para el botón Cancelar (y cierre del modal)
    addUserModal.addEventListener('hidden.bs.modal', function() {
        addUserForm.reset(); // Borra todos los datos del formulario
        addUserForm.classList.remove('was-validated'); // Quita las clases de validación
        addUserErrorAlert.style.display = 'none'; // Oculta la alerta de error
    });

    // --- Modal de Añadir Grupo ---
    const addGroupModal = document.getElementById('addGroupModal');
    const addGroupForm = document.getElementById('addGroupForm');
    const addGroupErrorAlert = document.getElementById('addGroupErrorAlert');

    // 1. Lógica para el botón Guardar
    addGroupForm.addEventListener('submit', function(event) {
        if (!addGroupForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            addGroupErrorAlert.style.display = 'block';
        } else {
            addGroupErrorAlert.style.display = 'none';
        }
        addGroupForm.classList.add('was-validated');
    });

    // 2. Lógica para el botón Cancelar (y cierre del modal)
    addGroupModal.addEventListener('hidden.bs.modal', function() {
        addGroupForm.reset();
        addGroupForm.classList.remove('was-validated');
        addGroupErrorAlert.style.display = 'none';
    });
});
</script>

</body>