<?php

namespace App\Controllers;

class Recursos extends BaseController
{
    public function index()
    {
        $users = [
            ['id' => 1, 'codigo' => '12456', 'foto' => 'avatar.png', 'nombre' => 'Lizandra Villanueva', 'tipo' => 'Manager', 'proyecto' => 'Actualización ERP junio 2025'],
            ['id' => 2, 'codigo' => '94621', 'foto' => 'avatar.png', 'nombre' => 'Antonio Banderas', 'tipo' => 'Administrador', 'proyecto' => 'Actualización ERP junio 2025'],
            ['id' => 3, 'codigo' => '972513', 'foto' => 'avatar.png', 'nombre' => 'Marina Escalante', 'tipo' => 'Manager', 'proyecto' => 'Creación módulo ventas'],
            ['id' => 4, 'codigo' => '847291', 'foto' => 'avatar.png', 'nombre' => 'Eugenia Turron', 'tipo' => 'Administrador', 'proyecto' => 'Creación módulo ventas'],
            ['id' => 5, 'codigo' => '638125', 'foto' => 'avatar.png', 'nombre' => 'America Suicune', 'tipo' => 'Usuario', 'proyecto' => 'Creación módulo ventas'],
            ['id' => 6, 'codigo' => '11223', 'foto' => 'avatar.png', 'nombre' => 'Juan Pérez', 'tipo' => 'Usuario', 'proyecto' => 'Soporte Técnico Interno'],
            ['id' => 7, 'codigo' => '44556', 'foto' => 'avatar.png', 'nombre' => 'Ana García', 'tipo' => 'Manager', 'proyecto' => 'Soporte Técnico Interno'],
            ['id' => 8, 'codigo' => '77889', 'foto' => 'avatar.png', 'nombre' => 'Carlos Rodriguez', 'tipo' => 'Administrador', 'proyecto' => 'Actualización ERP junio 2025'],
            ['id' => 9, 'codigo' => '15975', 'foto' => 'avatar.png', 'nombre' => 'Laura Martinez', 'tipo' => 'Usuario', 'proyecto' => 'Creación módulo ventas'],
            ['id' => 10, 'codigo' => '35715', 'foto' => 'avatar.png', 'nombre' => 'Sofía Hernandez', 'tipo' => 'Manager', 'proyecto' => 'Actualización ERP junio 2025'],
            ['id' => 11, 'codigo' => '95135', 'foto' => 'avatar.png', 'nombre' => 'David López', 'tipo' => 'Usuario', 'proyecto' => 'Soporte Técnico Interno'],
        ];

        $groups = [
            ['id' => 1, 'codigo' => '00001', 'foto' => 'avatar.png', 'nombre' => 'Los Uhum!Server', 'tipo' => 'Servidor', 'proyecto' => 'Actualización ERP junio 2025'],
            ['id' => 2, 'codigo' => '00002', 'foto' => 'avatar.png', 'nombre' => 'Grupo de Administradores', 'tipo' => 'Administración', 'proyecto' => 'Actualización de base de datos'],
            ['id' => 3, 'codigo' => '00003', 'foto' => 'avatar.png', 'nombre' => 'Equipo de Desarrollo Frontend', 'tipo' => 'Desarrollo', 'proyecto' => 'Creación módulo ventas'],
            ['id' => 4, 'codigo' => '00004', 'foto' => 'avatar.png', 'nombre' => 'Mesa de Ayuda Nivel 1', 'tipo' => 'Soporte', 'proyecto' => 'Soporte Técnico Interno'],
            ['id' => 5, 'codigo' => '00005', 'foto' => 'avatar.png', 'nombre' => 'Infraestructura Cloud', 'tipo' => 'Servidor', 'proyecto' => 'Actualización ERP junio 2025'],
        ];
        
        // Preparamos los datos para los filtros
        $data['user_types'] = array_unique(array_column($users, 'tipo'));
        $data['group_types'] = array_unique(array_column($groups, 'tipo'));
        $data['projects'] = array_unique(array_merge(array_column($users, 'proyecto'), array_column($groups, 'proyecto')));
        sort($data['projects']);

        // Creamos una estructura de datos más clara para pasar a la vista
        $data_to_view = [
            'resources' => [
                'users'  => $users,
                'groups' => $groups
            ],
            'filters' => [
                'user_types'  => array_values($data['user_types']),
                'group_types' => array_values($data['group_types']),
                'projects'    => $data['projects']
            ]
        ];
        
        return view('recursos/index', $data_to_view);
    }
}