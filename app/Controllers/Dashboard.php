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
        $show_year=view('select_year_view/select_year_view_header.php', $data);
        $show_year.=view('select_year_view/select_year_view_body.php', $data);
        $show_year.=view('select_year_view/select_year_view_footer.php', $data);
        return $show_year;
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

    // ----- LÓGICA MEJORADA Y DEFINITIVA PARA OBTENER EL AÑO -----

    // Usamos getVar() que busca tanto en POST como en GET.
    $yearFromRequest = $this->request->getVar('anio');

    if ($yearFromRequest) {
        // PRIORIDAD 1: El usuario seleccionó un año activamente.
        // Usamos este año y lo guardamos en la sesión para futuras navegaciones.
        $selectedYear = $yearFromRequest;
        $session->set('selected_year', $selectedYear);
    } else {
        // PRIORIDAD 2: No hay selección activa, buscamos en la sesión.
        $selectedYear = $session->get('selected_year');
    }

    // Si después de todo no tenemos un año, es el primer acceso.
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
        
        $show_dashboard=view('dashboard/dashboard_header.php', $data);
        $show_dashboard.=view('dashboard/dashboard_body.php', $data);
        $show_dashboard.=view('dashboard/dashboard_footer.php', $data);
        return $show_dashboard;
    }
}