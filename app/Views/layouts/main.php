<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminProject Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --bg-dark: #20202d; 
            --panel-bg: #2c2c3e; 
            --panel-light-bg:rgb(113, 113, 214); 
            --text-light:rgb(0, 0, 0); 
            --text-muted: #a0a0b0; 
            --accent-green: #28a745; 
            --accent-teal: #17a2b8; 
            --accent-yellow: #ffc107; 
            --accent-red: #dc3545; 
            --brand-purple: #8e44ad; 
        } 
        body { 
            background-color: var(--bg-dark); 
            color: var(--text-light); 
            font-family: 'Poppins', sans-serif; 
            font-size: 0.9rem; 
        } 
        .main-container { 
            display: flex; 
            min-height: 100vh; 
        } 
        .sidebar { 
            width: 240px; 
            background-color: var(--panel-bg); 
            padding-top: 20px;
            flex-shrink: 0; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            font-weight: 600;
            font-size: 1.5rem;
            color: #fff;
        }
        .sidebar-nav a { 
            display: flex; 
            align-items: center; 
            padding: 12px 20px; 
            color: var(--text-muted); 
            text-decoration: none; 
            transition: all 0.2s ease; 
            font-weight: 500; 
            border-left: 3px solid transparent;
        } 
        .sidebar-nav a:hover {
            background-color: var(--bg-dark);
            color: #fff;
            border-left: 3px solid var(--brand-purple);
        }
        .sidebar-nav a.active { 
            background-color: var(--bg-dark);
            color: #fff; 
            border-left: 3px solid var(--brand-purple);
        } 
        .sidebar-nav a i { 
            margin-right: 15px; 
            width: 20px; 
            text-align: center; 
            font-size: 1.1rem;
        } 
        .content-wrapper { 
            flex-grow: 1; 
            padding: 2rem; 
            background-color: var(--bg-dark);
        } 
        .main-panel { 
            background-color: var(--panel-bg); 
            border-radius: 20px; 
            padding: 2.5rem; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
        } 
        /* Añadimos estilos para los elementos del formulario del mensaje anterior */
        .form-legend {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-light);
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--panel-light-bg);
            padding-bottom: 0.5rem;
        }
        .form-control, .form-select {
            background-color: var(--panel-light-bg);
            border: 1px solid #555;
            color: var(--text-light);
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--panel-light-bg);
            color: var(--text-light);
            border-color: var(--brand-purple);
            box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25);
        }
    </style>
</head>
<body>

<div class="main-container">
    
    <aside class="sidebar">
        <div class="sidebar-header">
            AdminProject
        </div>
        <nav class="sidebar-nav">
            <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-home"></i> INICIO</a>
            <a href="#"><i class="fas fa-star"></i> RECURSOS</a>
            <a href="#"><i class="fas fa-tasks"></i> TAREAS</a>
            <a href="#"><i class="fas fa-clock"></i> TIEMPO</a>
            <a href="<?= site_url('ajustes') ?>"><i class="fas fa-cog"></i> AJUSTES</a>
        </nav>
    </aside>

    <div class="content-wrapper">
        
        <?= $this->renderSection('content') ?>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>