<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\Proyecto;
use App\Models\ProyectoModel;
use Config\Database;
use App\Models\TareaModel;

class Proyectos extends BaseController
{
    use ResponseTrait;

    public function detalles($projectId)
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        $defaults = ['default_theme' => 'dark'];
        $settings = $session->get('general_settings') ?? $defaults;
        helper('url');

        $db = Database::connect();

        // --- 1. DATOS PRINCIPALES DEL PROYECTO (Sin cambios) ---
        $proyectoInfo = $db->table('dbo.proyectos p')
            ->select('p.id_proyecto, p.nombre, p.descripcion, p.status, p.fecha_inicio, p.fecha_fin, u.Nombre, u.Apellido_Paterno')
            ->join('dbo.usuario u', 'u.Id_usuario = p.id_usuario_asignado', 'left')
            ->where('p.id_proyecto', $projectId)
            ->get()
            ->getRowArray();

        if (!$proyectoInfo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // --- 2. ESTADÍSTICAS (Sin cambios) ---
        $total_tareas = $db->table('dbo.TAREAS')->where('PROY_ID', $projectId)->countAllResults();
        $tareas_completadas = $db->table('dbo.TAREAS t')->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID')->where('t.PROY_ID', $projectId)->where('e.STAT_NOM', 'Completado')->countAllResults();
        
        // =====================================================================
        // INICIO DEL NUEVO MÉTODO "A LA FUERZA"
        // =====================================================================

        // -- 3. OBTENER GRUPOS CON SQL PURO Y CONSTRUIR HTML --
        $sqlGrupos = "SELECT g.GPO_NOM FROM dbo.DET_GRUPOS dg JOIN dbo.GRUPOS g ON dg.GPO_ID = g.GPO_ID WHERE dg.PROY_ID = ? GROUP BY g.GPO_NOM";
        $gruposResult = $db->query($sqlGrupos, [$projectId])->getResultArray();
        
        $html_grupos = '';
        if (!empty($gruposResult)) {
            foreach ($gruposResult as $grupo) {
                $html_grupos .= '<li>' . esc($grupo['GPO_NOM']) . '</li>';
            }
        } else {
            $html_grupos = '<li class="text">No hay grupos asignados.</li>';
        }

        // -- 4. OBTENER USUARIOS CON SQL PURO Y CONSTRUIR HTML --
        $sqlUsuarios = "SELECT (u.Nombre + ' ' + u.Apellido_Paterno) as nombre_completo FROM dbo.DET_GRUPOS dg JOIN dbo.usuario u ON dg.USU_ID = u.Id_usuario WHERE dg.PROY_ID = ? GROUP BY u.Nombre, u.Apellido_Paterno";
        $usuariosResult = $db->query($sqlUsuarios, [$projectId])->getResultArray();

        $html_usuarios = '';
        if (!empty($usuariosResult)) {
            foreach ($usuariosResult as $usuario) {
                $html_usuarios .= '<li>' . esc($usuario['nombre_completo']) . '</li>';
            }
        } else {
            $html_usuarios = '<li class="text">No hay usuarios asignados.</li>';
        }
        
        // =====================================================================
        // FIN DEL NUEVO MÉTODO
        // =====================================================================

        // --- 5. OBTENER TAREAS RECIENTES (Sin cambios) ---
        
        // --- CONSTRUCCIÓN DEL ARRAY FINAL PARA LA VISTA ---
        $data['proyecto'] = $proyectoInfo;
        $data['stats'] = [
            'total_tareas' => $total_tareas, 
            'tareas_completadas' => $tareas_completadas
        ];
        // Pasamos los contadores y el HTML ya construido
        $data['total_usuarios'] = count($usuariosResult);
        $data['total_grupos'] = count($gruposResult);
        $data['html_lista_usuarios'] = $html_usuarios;
        $data['html_lista_grupos'] = $html_grupos;
        
   
        $data['settings'] = $settings;
        $data['userData'] = $session->get('userData');
        
        $show_page  = view('proyectos/detalles_header', $data);
        $show_page .= view('proyectos/detalles_body', $data);
        $show_page .= view('proyectos/detalles_footer', $data);
        return $show_page;
    }
    
    public function update()
    {
        if (session()->get('rol') !== 'administrador') {
            return $this->failForbidden('No tienes permiso para realizar esta acción.');
        }
        $json = $this->request->getJSON();
        $id = $json->id_proyecto ?? null;
        if (!$id) {
            return $this->fail('No se proporcionó un ID de proyecto válido.');
        }
        $data = [
            'nombre'        => $json->nombre,
            'descripcion'   => $json->descripcion,
            'prioridad'     => $json->prioridad,
            'status'        => $json->status,
            'fecha_inicio'  => $json->fecha_inicio,
            'fecha_fin'     => $json->fecha_fin
        ];

        $proyectoModel = new ProyectoModel();

        if ($proyectoModel->updateProjectSP($id, $data)) {
            return $this->respondUpdated(['message' => 'Proyecto actualizado con éxito mediante SP.']);
        } else {
            return $this->fail('No se pudo actualizar el proyecto mediante el procedimiento almacenado.');
        }
    }

     public function getTareasPaginadas($projectId)
    {
        // Usaremos el modelo de Tareas para aprovechar la paginación de CodeIgniter
        $model = new TareaModel(); // Necesitas crear este modelo

        // El 'tareas' en getVar('page_tareas') es un grupo de paginación
        // para no interferir con otras paginaciones en la misma página.
        $page = $this->request->getVar('page_tareas') ?? 1;
        $perPage = 5; // Tareas por página

        // Usamos el Query Builder para construir la consulta
        $query = $model->db->table('dbo.TAREAS t')
            ->select("t.TAR_NOM, e.STAT_NOM, DATEDIFF(day, GETDATE(), t.TAR_FECHAFIN) as dias_restantes")
            ->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID', 'left')
            ->where('t.PROY_ID', $projectId)
            ->orderBy('t.TAR_FECHAINI', 'DESC');

        // Obtenemos los datos paginados
        $data = [
            'tareas' => $query->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager'  => $model->pager->makeLinks($page, $perPage, $query->countAllResults(false), 'bootstrap_template', 0, 'tareas')
        ];
        
        // Devolvemos los datos en formato JSON
        return $this->respond($data);
    }

   public function ajax_get_tareas_datatable($projectId)
{
    // Verificamos que sea una petición AJAX para seguridad
    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    $db = \Config\Database::connect();
    $builder = $db->table('dbo.TAREAS t');

    // Parámetros que envía DataTables
    $draw = $this->request->getVar('draw');
    $start = $this->request->getVar('start');
    $length = $this->request->getVar('length');
    $searchValue = $this->request->getVar('search')['value'];
    $order = $this->request->getVar('order')[0] ?? null;

    // Columnas que se pueden buscar y ordenar
    $columns = ['t.TAR_NOM', 'e.STAT_NOM', null]; // null para la columna de vencimiento que es calculada

    // --- CONSTRUCCIÓN DE LA CONSULTA ---
    $builder->select("t.TAR_NOM, e.STAT_NOM, t.TAR_FECHAFIN, DATEDIFF(day, GETDATE(), t.TAR_FECHAFIN) as dias_restantes")
            ->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID', 'left')
            ->where('t.PROY_ID', $projectId);

    // --- LÓGICA DE BÚSQUEDA ---
    if (!empty($searchValue)) {
        $builder->groupStart();
        $builder->like('t.TAR_NOM', $searchValue);
        $builder->orLike('e.STAT_NOM', $searchValue);
        $builder->groupEnd();
    }

    // --- CONTEO PARA LA PAGINACIÓN ---
    // Total de registros filtrados (considerando la búsqueda)
    $recordsFiltered = $builder->countAllResults(false); // false para no resetear la consulta
    // Total de registros sin filtrar
    $totalRecordsBuilder = $db->table('dbo.TAREAS')->where('PROY_ID', $projectId);
    $recordsTotal = $totalRecordsBuilder->countAllResults();

    // --- LÓGICA DE ORDENAMIENTO ---
    if ($order && isset($columns[$order['column']])) {
        // Ordenamiento definido por el usuario al hacer clic en una columna
        $colName = $columns[$order['column']];
        if ($colName) { // Solo ordena si la columna no es calculada en PHP
            $builder->orderBy($colName, $order['dir']);
        }
    } else {
        // ORDEN POR DEFECTO PERSONALIZADO (Atrasados > Próximos a vencer > Sin fecha)
        $customSortOrder = "
            CASE 
                WHEN DATEDIFF(day, GETDATE(), t.TAR_FECHAFIN) < 0 THEN 1 
                WHEN DATEDIFF(day, GETDATE(), t.TAR_FECHAFIN) >= 0 THEN 2 
                ELSE 3 
            END ASC, 
            t.TAR_FECHAFIN ASC
        ";
        // El tercer parámetro 'false' es crucial para que CI4 no escape la consulta.
        $builder->orderBy($customSortOrder, '', false);
    }

    // --- LÍMITE PARA LA PAGINACIÓN ---
    if ($length != -1) {
        $builder->limit($length, $start);
    }

    $tareas = $builder->get()->getResultArray();

    // --- FORMATEO DE DATOS PARA LA VISTA ---
    $data = [];
    foreach ($tareas as $tarea) {
        // Lógica de vencimiento
        $vencimientoHtml = '';
        if ($tarea['STAT_NOM'] === 'Completado' || $tarea['STAT_NOM'] === 'Cancelado') {
            $vencimientoHtml = 'Tarea finalizada.';
        } elseif (is_null($tarea['dias_restantes'])) {
            $vencimientoHtml = 'Sin fecha límite.';
        } elseif ($tarea['dias_restantes'] < 0) {
            $vencimientoHtml = '<span class="text-danger fw-bold">Atrasada por ' . abs($tarea['dias_restantes']) . ' días</span>';
        } elseif ($tarea['dias_restantes'] == 0) {
            $vencimientoHtml = '<span class="text-warning fw-bold">Vence hoy</span>';
        } else {
            $vencimientoHtml = 'Vence en ' . $tarea['dias_restantes'] . ' días';
        }
        
        // Lógica de colores para el estado
        $statusColors = [
            'En Progreso' => 'bg-primary', 'Completado'  => 'bg-success', 
            'Pendiente'   => 'bg-warning text-dark', 'Atrasado'    => 'bg-danger', 
            'En Espera'   => 'bg-info', 'Cancelado'   => 'bg-secondary'
        ];
        $badgeClass = $statusColors[$tarea['STAT_NOM']] ?? 'bg-light text-dark';
        $estadoHtml = '<span class="badge ' . $badgeClass . ' rounded-pill">' . esc($tarea['STAT_NOM']) . '</span>';

        $data[] = [
            'tar_nom'     => esc($tarea['TAR_NOM']),
            'stat_nom'    => $estadoHtml,
            'vencimiento' => $vencimientoHtml
        ];
    }

    // --- RESPUESTA FINAL EN FORMATO JSON PARA DATATABLES ---
    $output = [
        'draw'            => intval($draw),
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data,
    ];

    return $this->response->setJSON($output);
}
}

