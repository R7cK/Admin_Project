<?php

namespace App\Controllers;

class Ajustes extends BaseController
{
    public function index()
    {
        $session = session();

        // Proteger la página
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Preparar los datos para la vista (perfil de usuario)
        $data = [
            'userData' => [
                'id'     => $session->get('id_usuario'),
                'nombre' => $session->get('nombre_completo'),
                'rol'    => $session->get('rol')
            ]
        ];

        $show_ajustes=view('Ajustes/ajustes_header.php');
        $show_ajustes.=view('Ajustes/ajustes_body.php');
        $show_ajustes.=view('Ajustes/ajustes_footer.php');
        return $show_ajustes;
    }
}
