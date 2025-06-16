<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Proyectos</title>
    
    <!-- CSS (igual que antes) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Pega aquí todo el CSS de la respuesta anterior, no ha cambiado */
        :root { --bg-dark: #20202d; --panel-bg: #2c2c3e; --panel-light-bg: #4a4a6a; --text-light: #e0e0e0; --text-muted: #a0a0b0; --accent-green: #28a745; --accent-teal: #17a2b8; --accent-yellow: #ffc107; --accent-red: #dc3545; --brand-purple: #8e44ad; } body { background-color: var(--bg-dark); color: var(--text-light); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } .main-container { display: flex; min-height: 100vh; } .sidebar { width: 200px; background-color: var(--bg-dark); padding: 20px 0; flex-shrink: 0; border-right: 1px solid #333; } .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--text-muted); text-decoration: none; transition: all 0.3s ease; font-weight: 500; } .sidebar-nav a:hover, .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff; border-radius: 0 30px 30px 0; margin-left: -1px; } .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; } .content-wrapper { flex-grow: 1; padding: 20px; } .main-panel { background-color: var(--panel-bg); border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); } .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; } .search-bar { background-color: #e9ecef; border: none; border-radius: 20px; padding: 10px 20px; width: 300px; } .user-profile { display: flex; align-items: center; gap: 15px; } .user-profile i { color: var(--text-muted); font-size: 1.2rem; } .user-profile img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--brand-purple); } .user-info small { color: var(--text-muted); } .actions-bar { display: flex; flex-wrap: wrap; gap: 15px; align-items: center; margin-bottom: 25px; } .btn-custom { border-radius: 8px; padding: 8px 15px; font-weight: 500; border: none; } .btn-add { background-color: var(--accent-teal); color: #fff; } .project-table { background-color: transparent; color: var(--text-light); border-collapse: separate; border-spacing: 0 10px; } .project-table thead th { background-color: transparent; border: none; color: var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.8em; cursor: pointer; } .project-table tbody tr { background-color: var(--panel-light-bg); } .project-table tbody td { border: none; padding: 15px; vertical-align: middle; } .project-table tbody tr td:first-child { border-radius: 10px 0 0 10px; } .project-table tbody tr td:last-child { border-radius: 0 10px 10px 0; } .badge-priority { padding: 6px 15px; border-radius: 20px; color: #fff; font-weight: 500; min-width: 90px; text-align: center; } .badge-normal { background-color: var(--accent-green); } .badge-media { background-color: var(--accent-yellow); color: #333; } .badge-alta { background-color: var(--accent-red); } .badge-activo { background-color: var(--accent-green); } .badge-pendiente { background-color: var(--accent-teal); } .badge-atrasado { background-color: var(--accent-red); } .table-actions a { color: var(--text-muted); font-size: 1.2rem; margin: 0 5px; } .pagination { justify-content: center; margin-top: 20px; } .pagination .page-item .page-link { background-color: var(--panel-light-bg); border: none; color: var(--text-light); margin: 0 3px; border-radius: 5px; } .pagination .page-item.active .page-link { background-color: var(--brand-purple); } .pagination .page-item.disabled .page-link { background-color: #3a3a4a; color: #6c757d; }
    </style>
</head>
<body>
    <h4 class="text-center py-3 m-0">
        <!-- Título dinámico según el rol -->
        <?= ($userData['rol'] === 'administrador') ? 'PANEL DE ADMINISTRADOR' : 'MIS PROYECTOS' ?>
    </h4>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="sidebar-nav">
                <a href="#" class="active"><i class="fas fa-home"></i> INICIO</a>
                <a href="#"><i class="fas fa-star"></i> RECURSOS</a>
                <a href="#"><i class="fas fa-tasks"></i> TAREAS</a>
                <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
                <a href="#"><i class="fas fa-cog"></i> AJUSTES</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="main-panel">
                <!-- Panel Header -->
                <div class="panel-header">
                    <div class="input-group" style="width: auto;">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-bars"></i></span>
                        <input type="text" id="searchInput" class="form-control search-bar" placeholder="Buscar proyecto">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                    </div>

                    <div class="user-profile">
                        <i class="fas fa-bell"></i>
                        <i class="fas fa-envelope"></i>
                        <img src="https://i.pravatar.cc/40?u=<?= esc($userData['id']) ?>" alt="User Avatar">
                        <div class="user-info">
                            <!-- Datos del usuario desde el controlador -->
                            <strong><?= esc($userData['nombre']) ?></strong><br>
                            <small><?= esc(ucfirst($userData['rol'])) ?></small>
                        </div>
                    </div>
                </div>

                <!-- Actions Bar -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <strong class="me-3">Fecha Actual: <?= date('d/m/Y') ?></strong>
                    </div>
                    <div class="actions-bar">
                        <button class="btn btn-secondary btn-custom" onclick="alert('Simulando descarga de CSV...')"><i class="fas fa-download me-2"></i>Download CSV</button>
                        
                        <!-- Botones solo para el administrador -->
                        <?php if ($userData['rol'] === 'administrador'): ?>
                            <button id="btn-export" class="btn btn-secondary btn-custom" onclick="alert('Simulando exportación...')"><i class="fas fa-upload me-2"></i>Export</button>
                            <button id="btn-import" class="btn btn-secondary btn-custom" onclick="alert('Simulando importación...')"><i class="fas fa-download me-2"></i>Import</button>
                            <button id="btn-add" class="btn btn-add btn-custom" onclick="alert('Abriendo formulario para añadir proyecto...')"><i class="fas fa-plus me-2"></i>Añadir Proyecto</button>
                        <?php endif; ?>

                    <div class="d-flex align-items-center">
                        <label for="periodoSelect" class="form-label me-2 mb-0"><strong>Periodo:</strong></label>
                            <select class="form-select" id="periodoSelect" style="width: 120px; background-color: var(--panel-light-bg); color: var(--text-light); border-color: #555;">
                                <?php 
                                    $currentLoopYear = date('Y');
                                    for ($i = $currentLoopYear; $i >= 2020; $i--): 
                                ?>
                                <option value="<?= $i ?>" <?= ($i == $selectedYear) ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                    </div>
                
                <!-- Projects Table -->
                <h5 class="mb-3">
                    <?= ($userData['rol'] === 'administrador') ? 'Todos los Proyectos' : 'Proyectos Asignados' ?>
                </h5>
                <div class="table-responsive">
                    <table class="table project-table">
                        <thead>
                            <tr>
                                <th data-sort="id_proyecto">No. <i class="fas fa-sort"></i></th>
                                <th data-sort="nombre">Nombre <i class="fas fa-sort"></i></th>
                                <th data-sort="prioridad">Prioridad <i class="fas fa-sort"></i></th>
                                <th data-sort="descripcion">Descripción <i class="fas fa-sort"></i></th>
                                <th data-sort="fecha_inicio">Fecha Inicio <i class="fas fa-sort"></i></th>
                                <th data-sort="fecha_fin">Fecha Fin <i class="fas fa-sort"></i></th>
                                <th data-sort="status">Status <i class="fas fa-sort"></i></th>
                                <!-- Cabecera de acciones dinámica -->
                                <th><?= ($userData['rol'] === 'administrador') ? 'Ver / Editar' : 'Ver' ?></th>
                            </tr>
                        </thead>
                        <tbody id="projectTableBody">
                            <!-- Las filas se generarán con JavaScript para mantener el filtrado dinámico -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <nav id="paginationContainer"><ul class="pagination"></ul></nav>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. OBTENER LOS DATOS DESDE PHP
        // Los datos iniciales ya están filtrados por rol en el controlador.
        // Usamos json_encode para pasar el array PHP a un objeto JavaScript.
        const allProjects = <?= json_encode($proyectos) ?>;

        // El resto del JS se encarga del filtrado, ordenamiento y paginación en el CLIENTE.
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
                 tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-4">No se encontraron proyectos para los filtros seleccionados.</td></tr>`;
                 return;
            }

            pageData.forEach(project => {
                const priorityClass = { 'Normal': 'badge-normal', 'Media': 'badge-media', 'Alta': 'badge-alta' }[project.prioridad];
                const statusClass = { 'Activo': 'badge-activo', 'Pendiente': 'badge-pendiente', 'Atrasado': 'badge-atrasado' }[project.status];
                
                // Usamos PHP para determinar si el usuario actual puede editar
                let actionsHtml = `<a href="#" onclick="alert('Viendo detalles del proyecto ${project.id_proyecto}')" title="Ver Detalles"><i class="fas fa-list-alt"></i></a>`;
                <?php if ($userData['rol'] === 'administrador'): ?>
                    actionsHtml += ` <a href="#" onclick="alert('Editando el proyecto ${project.id_proyecto}')" title="Editar Proyecto"><i class="fas fa-pencil-alt"></i></a>`;
                <?php endif; ?>

                // Formatear fechas
                const formatDate = (dateString) => {
                    if (!dateString) return '';
                    const [y, m, d] = dateString.split('-');
                    return `${d}/${m}/${y}`;
                };

                const row = `
                    <tr>
                        <td>${project.id_proyecto}</td>
                        <td>${project.nombre}</td>
                        <td><span class="badge-priority ${priorityClass}">${project.prioridad}</span></td>
                        <td>${project.descripcion}</td>
                        <td>${formatDate(project.fecha_inicio)}</td>
                        <td>${formatDate(project.fecha_fin)}</td>
                        <td><span class="badge-priority ${statusClass}">${project.status}</span></td>
                        <td class="table-actions">${actionsHtml}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }
        
        function renderPagination() { /* ... esta función no cambia, cópiala de la respuesta anterior ... */
            paginationContainer.innerHTML = ''; const totalPages = Math.ceil(currentData.length / itemsPerPage); if (totalPages <= 1) return; paginationContainer.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">‹</a></li>`; for (let i = 1; i <= totalPages; i++) { paginationContainer.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`; } paginationContainer.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">›</a></li>`;
        }

        function applyFiltersAndSort() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedYear = periodoSelect.value;
            
            // Filtramos sobre los datos ya recibidos (allProjects)
            let filteredData = allProjects.filter(p => {
                const matchesYear = p.anio == selectedYear;
                const matchesSearch = searchTerm === '' || 
                                      p.nombre.toLowerCase().includes(searchTerm) ||
                                      p.descripcion.toLowerCase().includes(searchTerm) ||
                                      p.id_proyecto.toString().includes(searchTerm);
                return matchesYear && matchesSearch;
            });

            // Ordenamiento
            filteredData.sort((a, b) => {
                let valA = a[sortState.column], valB = b[sortState.column];
                if (typeof valA === 'string') { valA = valA.toLowerCase(); valB = valB.toLowerCase(); }
                if (valA < valB) return sortState.direction === 'asc' ? -1 : 1;
                if (valA > valB) return sortState.direction === 'asc' ? 1 : -1;
                return 0;
            });
            
            currentData = filteredData;
            currentPage = 1;
            renderTable();
            renderPagination();
        }
        
        // Event Listeners (no cambian, cópialos de la respuesta anterior)
        searchInput.addEventListener('input', applyFiltersAndSort);
        periodoSelect.addEventListener('change', applyFiltersAndSort);
        sortHeaders.forEach(header => { header.addEventListener('click', () => { const column = header.getAttribute('data-sort'); if (sortState.column === column) { sortState.direction = sortState.direction === 'asc' ? 'desc' : 'asc'; } else { sortState.column = column; sortState.direction = 'asc'; } sortHeaders.forEach(h => h.querySelector('i').className = 'fas fa-sort'); const icon = header.querySelector('i'); icon.className = `fas fa-sort-${sortState.direction === 'asc' ? 'up' : 'down'}`; applyFiltersAndSort(); }); });
        paginationContainer.addEventListener('click', (e) => { e.preventDefault(); if (e.target.tagName === 'A' && !e.target.parentElement.classList.contains('disabled')) { const page = parseInt(e.target.getAttribute('data-page')); if (page) { currentPage = page; renderTable(); renderPagination(); } } });

        // Inicialización
        applyFiltersAndSort();
    });
    // (Dentro de tu <script> tag al final del archivo)

document.addEventListener('DOMContentLoaded', function () {
    // ... (todo el código JS que ya tenías para filtrar, paginar, etc.) ...

    // ----- NUEVO CÓDIGO PARA EL CAMBIO DE AÑO -----
    const periodoSelect = document.getElementById('periodoSelect');
    periodoSelect.addEventListener('change', function() {
        const selectedYear = this.value;
        // Construimos la nueva URL con el año como parámetro GET
        const newUrl = '<?= site_url('dashboard') ?>?anio=' + selectedYear;
        // Redirigimos el navegador a la nueva URL
        window.location.href = newUrl;
    });
});
    </script>
</body>
</html>