<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class TareaModel
 * 
 * Este modelo gestiona las operaciones CRUD para la tabla de tareas (dbo.TAREAS).
 */
class TareaModel extends Model
{
    /**
     * El grupo de conexión a la base de datos a utilizar, como se define en app/Config/Database.php.
     * Si usas el grupo por defecto ('default'), no necesitas esta línea.
     * Descomenta si tu conexión a SQL Server tiene un nombre de grupo específico (ej: 'sqlserver').
     */
    // protected $DBGroup = 'default';

    /**
     * La tabla principal asociada a este modelo.
     * Es importante especificar el schema (dbo) si tu configuración de base de datos no lo hace por defecto.
     * @var string
     */
    protected $table = 'dbo.TAREAS';

    /**
     * La clave primaria de la tabla.
     * @var string
     */
    protected $primaryKey = 'TAR_ID';

    /**
     * El tipo de datos que devolverán los métodos del modelo (find, findAll, etc.).
     * 'object' es generalmente más limpio para trabajar en las vistas.
     * @var string
     */
    protected $returnType = 'array';

    /**
     * Si es true, las operaciones de inserción y actualización usarán automáticamente
     * los valores de las columnas `created_at` y `updated_at`.
     * Tu tabla actual no tiene estas columnas, así que lo establecemos en `false`.
     * Si las añades, puedes cambiar esto a `true`.
     * @var bool
     */
    protected $useTimestamps = false;
    
   
    /**
     * Especifica qué campos de la tabla se pueden establecer masivamente
     * durante una operación de inserción o actualización (ej: a través de un formulario).
     * Esta es una medida de seguridad crucial para prevenir la asignación masiva de campos no deseados.
     * @var array
     */
    protected $allowedFields = [
        'PROY_ID',
        'TAR_NOM',
        'TAR_DESC',
        'TAR_FECHAINI',
        'TAR_FECHAFIN',
        'STAT_ID',
        'PRIO_ID',
        'TAR_NOTAS',
        'GPO_ID',
        'solicitado_por_usuario_id',
        'solicitado_por_puesto_id',
        'complejidad_id',
        'bitacora_pruebas'
    ];

    /**
     * Reglas de validación que se pueden usar antes de insertar o actualizar.
     * Puedes definir tus reglas aquí y llamarlas desde el controlador con $model->validate($data).
     * @var array
     */
    protected $validationRules = [
        'TAR_NOM' => 'required|min_length[5]|max_length[255]',
        'TAR_DESC' => 'permit_empty|string',
        'solicitado_por_usuario_id' => 'required|is_natural_no_zero',
        'PROY_ID' => 'permit_empty|is_natural_no_zero',
        // Agrega aquí más reglas para otros campos según sea necesario
    ];

    /**
     * Mensajes de error personalizados para las reglas de validación.
     * @var array
     */
    protected $validationMessages = [
        'TAR_NOM' => [
            'required' => 'El nombre de la tarea es obligatorio.',
            'min_length' => 'El nombre de la tarea debe tener al menos 5 caracteres.'
        ],
        'solicitado_por_usuario_id' => [
            'required' => 'Debe seleccionar un usuario solicitante.',
            'is_natural_no_zero' => 'El ID del usuario solicitante no es válido.'
        ]
    ];

    /**
     * Si deseas omitir la validación durante las inserciones o actualizaciones.
     * Por lo general, es mejor mantenerlo en `false` y realizar la validación.
     * @var bool
     */
    protected $skipValidation = false;


    // --------------------------------------------------------------------
    // MÉTODOS PERSONALIZADOS
    // --------------------------------------------------------------------
    
    /**
     * Obtiene todas las tareas con información relacionada de otras tablas (joins).
     * Este es un ejemplo de cómo podrías obtener una lista de tareas para tu página principal.
     *
     * @param int|null $projectId El ID del proyecto para filtrar las tareas.
     * @return array
     */
    public function obtenerTareasConDetalles($projectId = null)
    {
        // El constructor de consultas (Query Builder) es la forma recomendada y segura
        $builder = $this->db->table($this->table . ' t'); // 't' es un alias para la tabla TAREAS

        $builder->select('
            t.TAR_ID, 
            t.TAR_NOM, 
            t.TAR_FECHAINI,
            u.nombre_completo as solicitado_por,  
            s.STAT_NOMBRE as estado_nombre,     
            p.PRIO_NOMBRE as prioridad_nombre    
        ');

        // Realizamos los JOINs para obtener los nombres en lugar de solo los IDs
        $builder->join('dbo.USUARIO u', 'u.id = t.solicitado_por_usuario_id', 'left');
        $builder->join('dbo.ESTADOS s', 's.STAT_ID = t.STAT_ID', 'left');
        $builder->join('dbo.PRIORIDADES p', 'p.PRIO_ID = t.PRIO_ID', 'left');

        // Si se proporciona un ID de proyecto, filtramos por él
        if ($projectId) {
            $builder->where('t.PROY_ID', $projectId);
        }

        // Ordenamos los resultados
        $builder->orderBy('t.TAR_ID', 'DESC');

        // Ejecutamos la consulta y devolvemos los resultados
        return $builder->get()->getResult();
    }

      /**
     * Obtiene las tareas de un proyecto con campos calculados para el estado y los días restantes.
     * @param int $id_proyecto
     * @return array
     */
    
 public function obtenerListaTareasDeProyecto($id_proyecto)
{
    $builder = $this->db->table($this->table . ' t');
    
    // Consulta principal que selecciona todos los campos necesarios
    $builder->select("
        t.TAR_ID,
        t.TAR_NOM,
        t.TAR_FECHAFIN,
        
        -- 1. Conteo de criterios
        (SELECT COUNT(*) FROM dbo.CRITERIOS_ACEPTACION ca WHERE ca.TAREA_ID = t.TAR_ID) AS numero_criterios,
        
        -- 2. Cálculo de días restantes
        CASE 
            WHEN t.TAR_FECHAFIN IS NULL THEN NULL
            ELSE DATEDIFF(day, GETDATE(), t.TAR_FECHAFIN) 
        END AS dias_restantes,
        
        -- 3. Cálculo del estado
        CASE 
            WHEN e.STAT_NOM IN ('Completado', 'Cancelado') THEN e.STAT_NOM
            WHEN t.TAR_FECHAFIN < CAST(GETDATE() AS DATE) THEN 'Atrasado'
            ELSE e.STAT_NOM
        END AS estado_calculado
    ")
    ->join('dbo.ESTATUS e', 't.STAT_ID = e.STAT_ID', 'left') // Join para obtener el nombre del estado
    ->where('t.PROY_ID', $id_proyecto);

    // Lógica de ordenamiento por urgencia
    $orderByClause = "
        CASE
            -- Grupo 1: Tareas atrasadas (las más antiguas primero)
            WHEN t.TAR_FECHAFIN < GETDATE() AND e.STAT_NOM NOT IN ('Completado', 'Cancelado') THEN 1
            -- Grupo 2: Tareas activas (las más próximas a vencer primero)
            WHEN t.TAR_FECHAFIN >= GETDATE() AND e.STAT_NOM NOT IN ('Completado', 'Cancelado') THEN 2
            -- Grupo 3: Tareas sin fecha
            WHEN t.TAR_FECHAFIN IS NULL AND e.STAT_NOM NOT IN ('Completado', 'Cancelado') THEN 3
            -- Grupo 4: Tareas completadas o canceladas (al final)
            ELSE 4
        END ASC,
        t.TAR_FECHAFIN ASC
    ";

    // Pasamos la cláusula de ordenamiento compleja
    $builder->orderBy($orderByClause, '', false);

    return $builder->get()->getResultArray();
}
}