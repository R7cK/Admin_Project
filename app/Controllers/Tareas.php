<?php

namespace App\Controllers;

class Tareas extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $defaults = ['default_theme' => 'light']; 
        $settings = $session->get('general_settings') ?? $defaults;
        helper(['url', 'form']);

        $session_tasks = $session->get('project_tasks') ?? [];
        $default_tasks = [
            ['nombre' => 'Diseñar la interfaz de usuario del módulo de ventas', 'asignado_a' => 'Ana Pérez', 'fecha_limite' => '2025-08-30', 'estado' => 'En Progreso'],
            ['nombre' => 'Desarrollar la lógica de negocio del backend', 'asignado_a' => 'Lucas Gonzalez', 'fecha_limite' => '2025-09-15', 'estado' => 'Completada'],
        ];
        
        $tasks = array_merge($session_tasks, $default_tasks);

        $data = [
            'settings'     => $settings,
            'userData'     => $session->get('userData'),
            'nombreProyecto' => 'Actualización ERP 2025',
            'tasks'        => $tasks
        ];
        
        $show_page  = view('Tareas/tareas_header', $data);
        $show_page .= view('Tareas/tareas_body', $data);
        $show_page .= view('Tareas/tareas_footer', $data);
        return $show_page;
    }

    /**
     * Procesa los datos del nuevo formulario detallado.
     */
    public function ajax_crear()
    {
        // Solo permitir peticiones AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        // Validación (puedes hacerla más robusta con las reglas de CI4)
        $val = $this->validate([
            'tar_nom' => 'required|min_length[5]',
            'criterio_desc' => 'required'
        ]);
        if (!$val) {
             return $this->response->setJSON(['status' => 'error', 'message' => 'El nombre de la tarea es obligatorio.']);
        }

        $tareaModel = new TareaModel();
        $criterioModel = new CriterioModel();
        
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Crear la tarea principal
        $idTarea = $tareaModel->insert([
            'tar_nom' => $this->request->getPost('tar_nom'),
            'tar_desc' => $this->request->getPost('tar_desc'),
            'solicitado_por_usuario_id' => $this->request->getPost('solicitado_por_usuario_id'),
            'fecha_creacion' => $this->request->getPost('fecha_creacion'),
            // ... otros campos
        ]);

        // 2. Crear el primer criterio asociado a la tarea
        $idCriterio = $criterioModel->insert([
            'tarea_id' => $idTarea,
            'descripcion' => $this->request->getPost('criterio_desc'),
            'puntos' => $this->request->getPost('criterio_puntos')
        ]);
        
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo guardar en la base de datos.']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Tarea creada.',
            'tarea_id' => $idTarea,
            'criterio_id' => $idCriterio
        ]);
    }

    /**
     * AJAX: Agrega un nuevo criterio a una tarea existente.
     */
    public function ajax_agregar_criterio()
    {
        if (!$this->request->isAJAX()) { return $this->response->setStatusCode(403); }

        $criterioModel = new CriterioModel();
        $idCriterio = $criterioModel->insert([
            'tarea_id' => $this->request->getPost('tarea_id'),
            'descripcion' => $this->request->getPost('criterio_desc'),
            'puntos' => $this->request->getPost('criterio_puntos')
        ]);

        if ($idCriterio) {
            return $this->response->setJSON(['status' => 'success', 'criterio_id' => $idCriterio]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo agregar el criterio.']);
    }

    /**
     * AJAX: Actualiza la descripción de un criterio existente.
     */
    public function ajax_actualizar_criterio()
    {
        if (!$this->request->isAJAX()) { return $this->response->setStatusCode(403); }

        $criterioModel = new CriterioModel();
        $id = $this->request->getPost('criterio_id');
        $descripcion = $this->request->getPost('descripcion');

        if ($criterioModel->update($id, ['descripcion' => $descripcion])) {
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar.']);
    }
    
    /**
     * AJAX: Elimina un criterio.
     */
    public function ajax_eliminar_criterio()
    {
        if (!$this->request->isAJAX()) { return $this->response->setStatusCode(403); }
        
        // Recibimos JSON en lugar de form-data
        $data = $this->request->getJSON();
        $id = $data->criterio_id;

        $criterioModel = new CriterioModel();
        if ($criterioModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo eliminar.']);
    }

}
