<?php

namespace App\Controllers;

// El nombre de la clase ahora es Recursos
class Recursos extends BaseController
{
    public function index()
    {
        // Datos de ejemplo para usuarios
        $data['users'] = [
            [
                'codigo' => '12456',
                'foto' => 'avatar.png',
                'nombre' => 'Lizandra Villanueva',
                'tipo' => 'Manager',
                'proyecto' => 'Actualización ERP junio 2025'
            ],
            [
                'codigo' => '94621',
                'foto' => 'avatar.png',
                'nombre' => 'Antonio Banderas',
                'tipo' => 'Administrador',
                'proyecto' => 'Actualización ERP junio 2025'
            ],
            [
                'codigo' => '972513',
                'foto' => 'avatar.png',
                'nombre' => 'Marina Escalante',
                'tipo' => 'Manager',
                'proyecto' => 'Creación módulo ventas'
            ],
        ];

        // Datos de ejemplo para grupos
        $data['groups'] = [
            [
                'codigo' => '00001',
                'foto' => 'avatar.png',
                'nombre' => 'Los Uhum!Server',
                'tipo' => 'Manager',
                'proyecto' => 'Actualización ERP junio 2025'
            ],
            [
                'codigo' => '00002',
                'foto' => 'avatar.png',
                'nombre' => 'Grupo de Administradores',
                'tipo' => 'Manager',
                'proyecto' => 'Actualización de base de datos'
            ],
        ];

        // Apuntamos a la nueva carpeta de la vista: 'recursos'
        return view('recursos/index', $data);
    }
}