<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes del Sistema</title>
    
    <!-- CSS (Exactamente el mismo que el del dashboard) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --bg-dark: #20202d; --panel-bg: #2c2c3e; --panel-light-bg: #4a4a6a; --text-light: #e0e0e0; --text-muted: #a0a0b0; --accent-green: #28a745; --accent-teal: #17a2b8; --accent-yellow: #ffc107; --accent-red: #dc3545; --brand-purple: #8e44ad; } 
        body { background-color: var(--bg-dark); color: var(--text-light); font-family: 'Poppins', sans-serif; font-size: 0.9rem; } 
        .main-container { display: flex; min-height: 100vh; } 
        .sidebar { width: 220px; background-color: var(--bg-dark); padding: 20px 0; flex-shrink: 0; border-right: 1px solid #333; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; color: var(--text-muted); text-decoration: none; transition: all 0.3s ease; font-weight: 500; } 
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: var(--brand-purple); color: #fff; border-radius: 0 30px 30px 0; margin-left: -1px; } 
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; } 
        .offcanvas { background-color: var(--bg-dark); }
        .content-wrapper { flex-grow: 1; padding: 1rem; } 
        .main-panel { background-color: var(--panel-bg); border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); } 
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; } .user-profile { display: flex; align-items: center; gap: 15px; } .user-profile i { color: var(--text-muted); font-size: 1.2rem; } .user-profile img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--brand-purple); } .user-info small { color: var(--text-muted); }
        /* Estilos para las tarjetas de settings */
        .settings-card { display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #fff; color: #333; border-radius: 15px; padding: 2rem; text-decoration: none; transition: all 0.3s ease; height: 100%; border: 1px solid #eee; }
        .settings-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); color: var(--brand-purple); }
        .settings-card .icon { font-size: 3.5rem; margin-bottom: 1rem; line-height: 1; }
        .settings-card .title { font-weight: 500; font-size: 1.1rem; }
            /* Ajuste para mejorar la legibilidad en el formulario de configuraciones */
        .data-panel .form-label {
            color: #FFFFFF !important; /* Hace que las etiquetas principales sean blancas y brillantes */
        }

        .data-panel .text-muted {
            color: #b5b5b5 !important; /* Aclara el texto de descripción gris para que sea más legible */
        }
    </style>
</head>