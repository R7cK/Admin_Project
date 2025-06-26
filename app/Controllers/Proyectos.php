<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\Proyecto
;
class Proyectos extends BaseController
{
     use ResponseTrait;
    /**
     * Muestra la página de detalles de un proyecto específico.
     * @param int $projectId El ID del proyecto que se va a mostrar.
     */
    public function detalles($projectId)
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Cargamos la configuración del tema y helpers
        $defaults = ['default_theme' => 'dark']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper('url');

        // ==========================================================
        // ===== DATOS ESTÁTICOS / DE EJEMPLO PARA LA VISTA =====
        // ==========================================================
        
        // Simula la información del proyecto principal
        $data['proyecto'] = [
            'id' => $projectId,
            'nombre' => 'Actualización del ERP Corporativo',
            'descripcion' => 'Migración completa del sistema ERP a la nueva versión en la nube, incluyendo módulos de finanzas, RH y logística. El objetivo es mejorar el rendimiento y la seguridad.',
            'estado' => 'Activo',
            'responsable' => 'Ricardo Chab Pool',
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-12-15'
        ];

        // Simula las estadísticas del proyecto
        $data['stats'] = [
            'total_tareas' => 25,
            'tareas_completadas' => 11,
            'costo_actual' => 18500.00,
            'presupuesto' => 50000.00,
        ];
        
        // Simula la lista de usuarios y grupos asignados
        $data['usuarios_asignados'] = ['Ricardo Chab', 'Ana García', 'Luis Hernández', 'Marina Escalante'];
        $data['grupos_asignados'] = ['Equipo de Desarrollo Backend', 'Equipo QA'];


        // Pasamos toda la información a las vistas
        $data['settings'] = $settings;
        $data['userData'] = $session->get('userData');

        // Construimos la página con un nuevo conjunto de vistas
        $show_page  = view('proyectos/detalles_header', $data);
        $show_page .= view('proyectos/detalles_body', $data);
        $show_page .= view('proyectos/detalles_footer', $data);
        
        return $show_page;
    }

        public function update()
    {
        // --- PASO 1: SEGURIDAD ---
        // Nos aseguramos de que solo un administrador pueda ejecutar esta acción.
        // Lee el rol guardado en la sesión durante el login.
        if (session()->get('rol') !== 'administrador') {
            // Si no es admin, devolvemos un error de "Acceso Prohibido" y detenemos la ejecución.
            return $this->failForbidden('No tienes permiso para realizar esta acción.');
        }

        // --- PASO 2: OBTENER Y VALIDAR LOS DATOS ---
        // Obtenemos los datos que el JavaScript envió en formato JSON.
        $json = $this->request->getJSON();
        
        // Verificamos que se haya enviado un ID de proyecto.
        $id = $json->id_proyecto ?? null;
        if (!$id) {
            return $this->fail('No se proporcionó un ID de proyecto válido.');
        }

        // --- PASO 3: PREPARAR LOS DATOS PARA LA BASE DE DATOS ---
        // Creamos un array con los datos, asegurándonos de que los nombres de las claves
        // coincidan exactamente con los nombres de las columnas en tu tabla "proyectos".
        $data = [
            'nombre'        => $json->nombre,
            'descripcion'   => $json->descripcion,
            'prioridad'     => $json->prioridad,
            'status'        => $json->status,
            'fecha_inicio'  => $json->fecha_inicio,
            'fecha_fin'     => $json->fecha_fin
            // No incluimos 'id_proyecto', 'anio' o 'id_usuario_asignado' porque no se editan en este formulario.
        ];

        // --- PASO 4: INTERACTUAR CON LA BASE DE DATOS ---
        // Creamos una instancia de nuestro modelo de proyectos.
        $proyectoModel = new ProyectoModel();

        // Usamos un bloque try-catch para manejar cualquier error inesperado de la base de datos.
        try {
            // El método update() del modelo de CodeIgniter es el que ejecuta la consulta SQL "UPDATE".
            // Le pasamos el ID del registro a actualizar y el array con los nuevos datos.
            if ($proyectoModel->update($id, $data)) {
                // Si la actualización fue exitosa, devolvemos una respuesta JSON de éxito al frontend.
                return $this->respondUpdated(['message' => 'Proyecto actualizado con éxito.']);
            } else {
                 // --- ESTA ES LA PARTE IMPORTANTE PARA DEPURAR ---
    // Obtenemos los errores de validación del modelo.
    $errors = $proyectoModel->errors();
    
    // Creamos un mensaje de error detallado.
    $errorMessage = 'No se pudo actualizar. Errores del modelo: ' . json_encode($errors);

    // Devolvemos el mensaje de error específico.
    return $this->fail($errorMessage);
            }
        } catch (\Exception $e) {
            // Si ocurre una excepción (ej. la base de datos se desconecta), la capturamos
            // y devolvemos un error genérico de servidor.
            log_message('error', '[ProyectosController] ' . $e->getMessage()); // Guardamos el error real en los logs.
            return $this->failServerError('Ocurrió un error inesperado al intentar actualizar el proyecto.');
        }
    }
}