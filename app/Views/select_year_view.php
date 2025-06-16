<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Periodo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(37, 37, 165); /* Mismo fondo que el dashboard */
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .selection-card {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            background-color:rgb(225, 225, 238); /* Mismo color de panel */
            border-radius: 20px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="card shadow selection-card">
        <div class="card-body">
            <h3 class="card-title text-center mb-3">¡Bienvenido, <?= esc($nombre) ?>!</h3>
            <p class="text-center text-muted mb-4">Por favor, selecciona el periodo que deseas consultar.</p>

            <form action="<?= site_url('dashboard') ?>" method="post">
                <?= csrf_field() ?> <!-- Protección CSRF -->

                <div class="mb-4">
                    <label for="anio" class="form-label fs-5">Año del Periodo</label>
                    <select class="form-select form-select-lg" id="anio" name="anio" required>
                        <?php 
                            // Generamos opciones desde el año actual hasta 2020
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= 2020; $i--): 
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Ver Proyectos</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>