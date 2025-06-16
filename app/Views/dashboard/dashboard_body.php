
<body>

<!-- Sidebar para pantallas grandes (visible en lg y superior) -->
<div class="main-container">
    <div class="sidebar d-none d-lg-block">
        <h5 class="text-center text-white my-3">AdminProject</h5>
        <nav class="sidebar-nav mt-4">
            <a href="#" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="#"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="#"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="#"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Botón Hamburguesa (visible solo en pantallas pequeñas) -->
            <button class="btn btn-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="text-center py-3 m-0 flex-grow-1">
                <?= ($userData['rol'] === 'administrador') ? 'PANEL DE ADMINISTRADOR' : 'MIS PROYECTOS' ?>
            </h4>
        </div>

        <div class="main-panel">
            <!-- Panel Header (Responsivo) -->
            <div class="panel-header flex-column flex-md-row mb-4">
                <div class="input-group w-100 w-md-auto mb-3 mb-md-0">
                    <input type="text" id="searchInput" class="form-control search-bar" placeholder="Buscar proyecto">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                </div>
                <div class="user-profile">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-envelope"></i>
                    <img src="https://i.pravatar.cc/40?u=<?= esc($userData['id']) ?>" alt="User Avatar">
                    <div class="user-info">
                        <strong><?= esc($userData['nombre']) ?></strong><br>
                        <small><?= esc(ucfirst($userData['rol'])) ?></small>
                    </div>
                    <a href="<?= site_url('logout') ?>" title="Cerrar Sesión" class="ms-3 text-danger"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </div>
            </div>

            <!-- Actions Bar (Responsiva) -->
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-lg-between mb-4 w-100">
                <div class="mb-3 mb-lg-0">
                    <strong>Fecha Actual: <?= date('d/m/Y') ?></strong>
                </div>
                <div class="actions-bar mb-3 mb-lg-0">
                    <button class="btn btn-secondary btn-custom" onclick="alert('Simulando descarga de CSV...')"><i class="fas fa-download me-2"></i>Download CSV</button>
                    <?php if ($userData['rol'] === 'administrador'): ?>
                        <button class="btn btn-secondary btn-custom" onclick="alert('Simulando exportación...')"><i class="fas fa-upload me-2"></i>Export</button>
                        <button class="btn btn-secondary btn-custom" onclick="alert('Simulando importación...')"><i class="fas fa-download me-2"></i>Import</button>
                        <button class="btn btn-add btn-custom" onclick="alert('Abriendo formulario...')"><i class="fas fa-plus me-2"></i>Añadir Proyecto</button>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center">
                    <label for="periodoSelect" class="form-label me-2 mb-0"><strong>Periodo:</strong></label>
                    <select class="form-select" id="periodoSelect" style="width: 120px; background-color: var(--panel-light-bg); color: var(--text-light); border-color: #555;">
                        <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                            <option value="<?= $i ?>" <?= ($i == $selectedYear) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <!-- Projects Table (con scroll horizontal en móvil) -->
            <h5 class="mb-3">
                <?= ($userData['rol'] === 'administrador') ? 'Todos los Proyectos' : 'Proyectos Asignados' ?>
            </h5>
            <div class="table-responsive">
                <table class="table project-table">
                    <thead>
                        <!-- ... el thead de la tabla no cambia ... -->
                        <tr>
                            <th data-sort="id_proyecto">No. <i class="fas fa-sort"></i></th>
                            <th data-sort="nombre">Nombre <i class="fas fa-sort"></i></th>
                            <th data-sort="prioridad">Prioridad <i class="fas fa-sort"></i></th>
                            <th data-sort="descripcion">Descripción <i class="fas fa-sort"></i></th>
                            <th data-sort="fecha_inicio">Fecha Inicio <i class="fas fa-sort"></i></th>
                            <th data-sort="fecha_fin">Fecha Fin <i class="fas fa-sort"></i></th>
                            <th data-sort="status">Status <i class="fas fa-sort"></i></th>
                            <th><?= ($userData['rol'] === 'administrador') ? 'Ver / Editar' : 'Ver' ?></th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        <!-- Filas generadas por JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <nav id="paginationContainer"><ul class="pagination"></ul></nav>
        </div>
    </div>
</div>

<!-- Offcanvas Sidebar para pantallas pequeñas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">AdminProject</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar-nav">
            <a href="#" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="#"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="#"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="#"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </div>
</div>


<!-- JS (Bootstrap y tu script personalizado) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Todo tu script de JavaScript anterior va aquí. No necesita cambios.
    // Pega aquí el script que maneja el filtrado, paginación y el cambio de año.
    document.addEventListener('DOMContentLoaded', function () {
        const allProjects = <?= json_encode($proyectos) ?>;
        let currentData = allProjects;
        let currentPage = 1;
        const itemsPerPage = 4;
        let sortState = { column: 'id_proyecto', direction: 'asc' };
        const tableBody = document.getElementById('projectTableBody');
        const searchInput = document.getElementById('searchInput');
        const periodoSelect = document.getElementById('periodoSelect');
        const paginationContainer = document.getElementById('paginationContainer').querySelector('.pagination');
        const sortHeaders = document.querySelectorAll('.project-table thead th[data-sort]');

        function renderTable() {
            tableBody.innerHTML = '';
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = currentData.slice(startIndex, endIndex);
            if (pageData.length === 0) {
                 tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-4">No se encontraron proyectos.</td></tr>`;
                 return;
            }
            pageData.forEach(project => {
                const priorityClass = { 'Normal': 'badge-normal', 'Media': 'badge-media', 'Alta': 'badge-alta' }[project.prioridad];
                const statusClass = { 'Activo': 'badge-activo', 'Pendiente': 'badge-pendiente', 'Atrasado': 'badge-atrasado' }[project.status];
                let actionsHtml = `<a href="#" onclick="alert('Viendo detalles del proyecto ${project.id_proyecto}')" title="Ver Detalles"><i class="fas fa-list-alt"></i></a>`;
                <?php if ($userData['rol'] === 'administrador'): ?>
                    actionsHtml += ` <a href="#" onclick="alert('Editando el proyecto ${project.id_proyecto}')" title="Editar Proyecto"><i class="fas fa-pencil-alt"></i></a>`;
                <?php endif; ?>
                const formatDate = (dateString) => { if (!dateString) return ''; const [y, m, d] = dateString.split('-'); return `${d}/${m}/${y}`; };
                const row = `<tr><td>${project.id_proyecto}</td><td>${project.nombre}</td><td><span class="badge-priority ${priorityClass}">${project.prioridad}</span></td><td>${project.descripcion}</td><td>${formatDate(project.fecha_inicio)}</td><td>${formatDate(project.fecha_fin)}</td><td><span class="badge-priority ${statusClass}">${project.status}</span></td><td class="table-actions">${actionsHtml}</td></tr>`;
                tableBody.innerHTML += row;
            });
        }
        function renderPagination() { paginationContainer.innerHTML = ''; const totalPages = Math.ceil(currentData.length / itemsPerPage); if (totalPages <= 1) return; paginationContainer.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">‹</a></li>`; for (let i = 1; i <= totalPages; i++) { paginationContainer.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`; } paginationContainer.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">›</a></li>`; }
        function applyFiltersAndSort() {
            const searchTerm = searchInput.value.toLowerCase();
            let filteredData = allProjects.filter(p => {
                return searchTerm === '' || p.nombre.toLowerCase().includes(searchTerm) || p.descripcion.toLowerCase().includes(searchTerm) || p.id_proyecto.toString().includes(searchTerm);
            });
            filteredData.sort((a, b) => { let valA = a[sortState.column], valB = b[sortState.column]; if (typeof valA === 'string') { valA = valA.toLowerCase(); valB = valB.toLowerCase(); } if (valA < valB) return sortState.direction === 'asc' ? -1 : 1; if (valA > valB) return sortState.direction === 'asc' ? 1 : -1; return 0; });
            currentData = filteredData;
            currentPage = 1;
            renderTable();
            renderPagination();
        }
        searchInput.addEventListener('input', applyFiltersAndSort);
        sortHeaders.forEach(header => { header.addEventListener('click', () => { const column = header.getAttribute('data-sort'); if (sortState.column === column) { sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc'; } else { sortState.column = column; sortState.direction = 'asc'; } sortHeaders.forEach(h => h.querySelector('i').className = 'fas fa-sort'); const icon = header.querySelector('i'); icon.className = `fas fa-sort-${sortState.direction === 'asc' ? 'up' : 'down'}`; applyFiltersAndSort(); }); });
        paginationContainer.addEventListener('click', (e) => { e.preventDefault(); if (e.target.tagName === 'A' && !e.target.parentElement.classList.contains('disabled')) { const page = parseInt(e.target.getAttribute('data-page')); if (page) { currentPage = page; renderTable(); renderPagination(); } } });
        
        // Script para el cambio de año
        periodoSelect.addEventListener('change', function() {
            const selectedYear = this.value;
            const newUrl = '<?= site_url('dashboard') ?>?anio=' + selectedYear;
            window.location.href = newUrl;
        });

        applyFiltersAndSort();
    });
</script>
</body>
