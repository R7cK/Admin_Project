<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProyectoModel;

class Dashboard extends BaseController
{
    /**
     * Muestra la página para seleccionar el año.
     */
    public function selectYear()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }
        $data['nombre'] = $session->get('nombre_completo');
        return view('select_year_view', $data);
    }

    /**
     * Muestra el dashboard principal.
     * Ahora es capaz de obtener el año desde un POST (inicial) o un GET (cambio de periodo).
     */
    public function index()
    {
        $session = session();
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // ----- LÓGICA MEJORADA PARA OBTENER EL AÑO -----
        $selectedYear = $this->request->getPost('anio'); // Intenta obtenerlo de un POST
        if (!$selectedYear) {
            $selectedYear = $this->request->getGet('anio'); // Si no hay POST, intenta obtenerlo de un GET
        }

        // Si después de ambos intentos no hay año, redirigir a la página de selección.
        if (!$selectedYear) {
            return redirect()->to('/select-year');
        }
        // ------------------------------------------------

        $userData = [
            'id'     => $session->get('id_usuario'),
            'nombre' => $session->get('nombre_completo'),
            'rol'    => $session->get('rol')
        ];

        $proyectoModel = new ProyectoModel();
        $query = $proyectoModel->where('anio', $selectedYear);

        if ($userData['rol'] === 'administrador') {
            $proyectos = $query->findAll();
        } else {
            $proyectos = $query->where('id_usuario_asignado', $userData['id'])->findAll();
        }
        
        $data = [
            'userData'     => $userData,
            'proyectos'    => $proyectos,
            'selectedYear' => $selectedYear // Pasamos el año a la vista para el dropdown
        ];
        
        return view('dashboard', $data);
    }
}