<?php

namespace App\Controllers;

class Ajustes extends BaseController
{
    /**
     * Tu método original, no se ha modificado.
     * Muestra la página principal de Ajustes (el menú con 4 botones).
     */
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        $data = [
            'userData' => [
                'id'     => $session->get('id_usuario'),
                'nombre' => $session->get('nombre_completo'),
                'rol'    => $session->get('rol')
            ]
        ];
        helper('url');
        $show_ajustes  = view('Ajustes/ajustes_header.php', $data);
        $show_ajustes .= view('Ajustes/ajustes_body.php', $data);
        $show_ajustes .= view('Ajustes/ajustes_footer.php', $data);
        return $show_ajustes;
    }

    /**
     * Tu método original para "Configuración General".
     */
    public function generales()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        $data = [
            'userData' => [
                'id'     => $session->get('id_usuario'),
                'nombre' => $session->get('nombre_completo'),
                'rol'    => $session->get('rol')
            ]
        ];
        helper('url');
        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('ajustes/generales', $data);
        $show_page .= view('Ajustes/ajustes_footer',  $data);
        return $show_page;
    }

    /**
     * Tu método original para la gestión de Usuarios y Grupos.
     */
    public function usuarios()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        helper('url');

        $users = [
            ['id' => 1, 'codigo' => '12456', 'foto' => 'avatar.png', 'nombre' => 'Lizandra Villanueva', 'email' => 'lizandra@mail.com', 'rol' => 'Manager', 'estado' => 'Activo', 'fecha_registro' => '2025-01-15'],
            ['id' => 2, 'codigo' => '94621', 'foto' => 'avatar.png', 'nombre' => 'Antonio Banderas', 'email' => 'antonio@mail.com', 'rol' => 'Administrador', 'estado' => 'Activo', 'fecha_registro' => '2025-02-20'],
            ['id' => 3, 'codigo' => '972513', 'foto' => 'avatar.png', 'nombre' => 'Marina Escalante', 'email' => 'marina@mail.com', 'rol' => 'Manager', 'estado' => 'Inactivo', 'fecha_registro' => '2025-03-10'],
        ];
        $groups = [
            ['id' => 1, 'codigo' => 'GRP-001', 'nombre' => 'Equipo de Desarrollo', 'miembros' => 5, 'lider' => 'Lizandra Villanueva'],
            ['id' => 2, 'codigo' => 'GRP-002', 'nombre' => 'Administración de Sistemas', 'miembros' => 3, 'lider' => 'Antonio Banderas'],
        ];
        $projects = ['Actualización ERP junio 2025', 'Creación módulo ventas', 'Soporte Técnico Interno'];

        $data = [
            'userData' => $session->get('userData'),
            'resources' => [
                'users'  => $users,
                'groups' => $groups
            ],
            'filters' => [
                'user_types'  => array_values(array_unique(array_column($users, 'rol'))),
                'group_types' => [],
                'estados'     => array_values(array_unique(array_column($users, 'estado'))),
                'projects'    => $projects
            ]
        ];
        
        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('ajustes/usuarios', $data);
        $show_page .= view('Ajustes/ajustes_footer', $data);
        return $show_page;
    }
    public function masterData()
    {
        // Mantenemos la protección de la sesión
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Preparamos los datos de ejemplo para las tablas de las pestañas
        $data['roles'] = [
            ['id' => 1, 'nombre' => 'Administrador'],
            ['id' => 2, 'nombre' => 'Manager'],
            ['id' => 3, 'nombre' => 'Usuario'],
            ['id' => 4, 'nombre' => 'Auditor'],
        ];

        $data['estados_proyecto'] = [
            ['id' => 1, 'nombre' => 'Activo'],
            ['id' => 2, 'nombre' => 'Pendiente'],
            ['id' => 3, 'nombre' => 'Atrasado'],
            ['id' => 4, 'nombre' => 'Completado'],
        ];
        
        $data['prioridades'] = [
            ['id' => 1, 'nombre' => 'Alta'],
            ['id' => 2, 'nombre' => 'Media'],
            ['id' => 3, 'nombre' => 'Normal'],
        ];

                $data['tipos_tarea'] = [
            ['id' => 1, 'nombre' => 'Diseño UX/UI'],
            ['id' => 2, 'nombre' => 'Desarrollo Frontend'],
            ['id' => 3, 'nombre' => 'Desarrollo Backend'],
            ['id' => 4, 'nombre' => 'Corrección de Bug'],
        ];

        $data['tipos_costo'] = [
            ['id' => 1, 'nombre' => 'Licencias de Software'],
            ['id' => 2, 'nombre' => 'Servicios Cloud'],
            ['id' => 3, 'nombre' => 'Hardware'],
            ['id' => 4, 'nombre' => 'Consultoría Externa'],
        ];

        $data['departamentos'] = [
            ['id' => 1, 'nombre' => 'Tecnologías de la Información'],
            ['id' => 2, 'nombre' => 'Marketing Digital'],
            ['id' => 3, 'nombre' => 'Ventas'],
        ];

        // Pasamos los datos del usuario logueado para la cabecera
        $data['userData'] = $session->get('userData');
        helper('url');

        // Construimos la página con tu sistema de header/body/footer
        $show_page  = view('Ajustes/ajustes_header', $data);
        $show_page .= view('Ajustes/masterdata_body', $data); // Usamos la nueva vista como cuerpo
        $show_page .= view('Ajustes/ajustes_footer', $data);
        
        return $show_page;
    }
}