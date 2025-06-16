<?php

namespace App\Controllers;

use App\Models\Usuario;



class Registro extends BaseController
{

    public function show_registro(){
    $show_registro=view('Registro/Registro_Header.php');
    $show_registro.=view('Registro/Registro_Body.php');
    $show_registro.=view('Registro/Registro_Footer.php');
    return $show_registro;
   }

    public function guardar()
{
    // ... (las reglas de validación se quedan igual) ...
    $rules = [
         'Nombre'           => 'required|min_length[3]|max_length[100]',
            'Apellido_Paterno' => 'required|min_length[3]|max_length[100]',
            'Apellido_Materno' => 'required|min_length[3]|max_length[100]',
            'Correo'           => 'required|valid_email|is_unique[usuario.Correo]', // Asegúrate que el nombre de la tabla sea 'usuarios'
            'Password'         => 'required|min_length[8]',
            'pass_confirm'     => 'required|matches[Password]'
    ];

    if (!$this->validate($rules)) {
        // --- INICIO DE LA CORRECCIÓN ---
        
        // 1. Preparamos los datos que la vista del cuerpo necesita (los errores).
        $data['validation'] = $this->validator;

        // 2. Reconstruimos la página completa, igual que en show_registro().
        $show_registro = view('Registro/Registro_Header.php');
        // 3. Al cargar el cuerpo, le pasamos los datos con los errores.
        $show_registro .= view('Registro/Registro_Body.php', $data);
        $show_registro .= view('Registro/Registro_Footer.php');
        
        return $show_registro;
        
        // --- FIN DE LA CORRECCIÓN ---
    }
    $model = new Usuario();

          $codigo_generado = rand(100000, 999999);

   $data = [
            'Nombre'           => $this->request->getPost('Nombre'),
            'Apellido_Paterno' => $this->request->getPost('Apellido_Paterno'),
            'Apellido_Materno' => $this->request->getPost('Apellido_Materno'),
            'Codigo_User'      => $codigo_generado, // <-- Usamos el código generado
            'Correo'           => $this->request->getPost('Correo'),
            'Password'         => $this->request->getPost('Password'), // Usando texto plano como acordamos
            'rol'              => 'capturista' // O el rol que hayas definido
        ];

    $model->registrar_usuario($data);

    return redirect()->to('/login')->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
}
}