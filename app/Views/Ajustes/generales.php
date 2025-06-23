<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="data-panel">

    <div class="panel-header" style="display: flex; align-items: center; gap: 1rem;">
        <a href="<?= site_url('ajustes') ?>" class="btn btn-light" title="Volver a Ajustes">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0">Configuraciones Generales</h2>
    </div>
    <div class="row mt-4">

        <div class="col-md-6">

            <div class="mb-4">
                <label for="active_users" class="form-label">Usuarios Activos</label>
                <select id="active_users" class="form-select">
                    <option selected>Todos los Usuarios Activos</option>
                    <option>Solo Administradores</option>
                    <option>Solo Managers</option>
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label class="form-label mb-0">Añadir Nuevo Proyecto</label>
                    <small class="d-block text-muted">Permitir que se añadan nuevos agentes.</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_new_project" checked>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label class="form-label mb-0">Notificaciones</label>
                    <small class="d-block text-muted">Permitir notificaciones del sistema.</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_notifications" checked>
                </div>
            </div>

            <div class="mb-4">
                <label for="system_maintenance" class="form-label">Mantenimiento de Rutina del Sistema</label>
                <select id="system_maintenance" class="form-select">
                    <option>Diario</option>
                    <option selected>Semanal</option>
                    <option>Mensual</option>
                </select>
            </div>

        </div>

        <div class="col-md-6">

            <div class="mb-4">
                <label for="default_language" class="form-label">Idioma por Defecto del Sistema</label>
                <select id="default_language" class="form-select">
                    <option>Español</option>
                    <option selected>Inglés</option>
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label class="form-label mb-0">Avatar de Usuarios</label>
                    <small class="d-block text-muted">Mostrar avatar de los usuarios.</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_user_avatar" checked>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label class="form-label mb-0">Notificación al añadir Proyecto</label>
                    <small class="d-block text-muted">Notificar sobre un nuevo agente.</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_project_notification" checked>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label class="form-label mb-0">Feedback de Usuarios</label>
                    <small class="d-block text-muted">Permitir a los usuarios dar feedback.</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch_feedback" checked>
                </div>
            </div>

            <div class="mb-4">
                <label for="default_theme" class="form-label">Tema por Defecto para Usuarios</label>
                <select id="default_theme" class="form-select">
                    <option>Tema Oscuro</option>
                    <option selected>Tema Claro</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="knowledge_base" class="form-label">Actualización de la Base de Conocimiento</label>
                <select id="knowledge_base" class="form-select">
                    <option selected>Diario</option>
                    <option>Semanal</option>
                </select>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>