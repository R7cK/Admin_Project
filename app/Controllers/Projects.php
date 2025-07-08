<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\GrupoModel;
use App\Models\ProyectoModel; // Aseguramos que el modelo de Proyecto esté importado
use Config\Database;

class Projects extends BaseController
{
    /**
     * Muestra el formulario para crear un nuevo proyecto.
     * Esta función está correcta y ya incluye la lógica del tema.
     */
    public function new()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        
        $defaults = ['default_theme' => 'dark'];
        $settings = $session->get('general_settings') ?? $defaults;

        $usuarioModel = new UsuarioModel();
        $grupoModel = new GrupoModel();
        $anio_trabajo = $session->get('anio_trabajo') ?? date('Y');

        $data = [
            'settings'      => $settings,
            'page_title'    => 'Añadir Nuevo Proyecto',
            'usuarios'      => $usuarioModel->where('Estado', 1)->findAll(),
            'grupos'        => $grupoModel->findAll(),
            'anio_trabajo'  => $anio_trabajo
        ];

        $html_output  = view('projects/header', $data);
        $html_output .= view('projects/new', $data);
        $html_output .= view('projects/footer', $data);
        
        return $html_output;
    }

    /**
     * Recibe los datos del formulario y los guarda usando el Modelo y Transacciones.
     * (Versión restaurada sin Proceso Almacenado)
     */
    public function create()
    {
        // <-- AÑADIDO: Bloque completo de validación -->
        $validation = \Config\Services::validation();

        // Reglas de validación
        $rules = [
            'nombre_proyecto' => [
                'label' => 'Nombre del Proyecto',
                'rules' => 'required|trim|is_unique[proyectos.nombre]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'Ya existe un proyecto con este nombre. Por favor, elige otro.'
                ]
            ],
            'fecha_inicio' => [
                'label' => 'Fecha de Inicio',
                'rules' => 'required|valid_date'
            ],
            // --- ¡AQUÍ ESTÁ EL CAMBIO! ---
            'fecha_fin' => [
                'label' => 'Fecha de Fin',
                // En lugar de una cadena, la regla es una función anónima.
                'rules' => ['required', 'valid_date', function($fecha_fin) {
                    $fecha_inicio = $this->request->getPost('fecha_inicio');
                    if (empty($fecha_inicio) || empty($fecha_fin)) {
                        return true; // Si una de las fechas no está, otras reglas lo capturarán.
                    }
                    return strtotime($fecha_fin) >= strtotime($fecha_inicio);
                }],
                'errors' => [
                    // El error se muestra para la regla anónima (en la posición 2 del array de reglas).
                    '2' => 'La Fecha de Fin no puede ser anterior a la Fecha de Inicio.'
                ]
            ],
            'responsable_id' => [
                'label' => 'Responsable del Proyecto',
                'rules' => 'required',
                'errors' => ['required' => 'Debes seleccionar un {field}.']
            ],
            'usuarios' => [
                'label' => 'Usuarios del Equipo',
                'rules' => 'required',
                'errors' => ['required' => 'Debes asignar al menos un usuario al equipo.']
            ]
        ];

        if (!$this->validate($rules)) {
            // Si la validación falla, redirigimos de vuelta.
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
         $db = Database::connect();
        $proyectoModel = new ProyectoModel();

        // 1. Recoger los datos del formulario
        $proyectoData = [
            'nombre'              => $this->request->getPost('nombre_proyecto'),
            'descripcion'         => $this->request->getPost('descripcion'),
            'prioridad'           => $this->request->getPost('prioridad'),
            'id_usuario_asignado' => $this->request->getPost('responsable_id'),
            'fecha_inicio'        => $this->request->getPost('fecha_inicio'),
            'fecha_fin'           => $this->request->getPost('fecha_fin'),
            'status'              => 'Activo', // El estado es 'Activo' por defecto
            'anio'                => date('Y', strtotime($this->request->getPost('fecha_inicio')))
        ];

        // Recogemos los arrays de usuarios y grupos asignados
        $usuariosAsignados = $this->request->getPost('usuarios') ?? [];
        $gruposAsignados = $this->request->getPost('grupos') ?? [];

        // 2. Iniciar una transacción para garantizar la integridad de los datos
        $db->transStart();

        // 2.1. Insertar el proyecto principal usando el Modelo
        $proyectoModel->insert($proyectoData);

        // 2.2. Obtener el ID del proyecto que acabamos de crear
        $newProjectId = $proyectoModel->getInsertID();

        // 2.3. Preparar y guardar las asignaciones en la tabla DET_GRUPOS
        $asignaciones = [];
        if (!empty($usuariosAsignados) && !empty($gruposAsignados)) {
            foreach ($usuariosAsignados as $userId) {
                foreach ($gruposAsignados as $groupId) {
                    $asignaciones[] = [
                        'PROY_ID' => $newProjectId,
                        'USU_ID'  => $userId,
                        'GPO_ID'  => $groupId
                    ];
                }
            }
        }
        
        // Si hay asignaciones, las insertamos en un solo lote
        if (!empty($asignaciones)) {
            $db->table('dbo.DET_GRUPOS')->insertBatch($asignaciones);
        }

        // 3. Finalizar la transacción
        $db->transComplete();

        // 4. Redireccionar con un mensaje de éxito o error
        if ($db->transStatus() === false) {
            // La transacción falló
            session()->setFlashdata('error', 'No se pudo crear el proyecto. La transacción falló.');
        } else {
            // La transacción fue exitosa
            session()->setFlashdata('success', '¡Proyecto creado y equipo asignado con éxito!');
        }

        return redirect()->to(base_url('/dashboard'));
    }

        public function check_name()
    {
        // Solo responde a peticiones AJAX por seguridad
        if ($this->request->isAJAX()) {
            $proyectoModel = new ProyectoModel();
            $nombre = $this->request->getJSON()->nombre_proyecto;
            
            // Busca si ya existe un proyecto con ese nombre
            $existe = $proyectoModel->where('nombre', $nombre)->first();
            
            // Retorna una respuesta JSON que el script del frontend puede leer
            return $this->response->setJSON(['existe' => ($existe !== null)]);
        }
        // Si no es una petición AJAX, no se permite el acceso.
        return $this->response->setStatusCode(403, 'Forbidden');
    }
}