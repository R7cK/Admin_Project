<?php

namespace App\Models;

use CodeIgniter\Model;

// El nombre de la clase debe coincidir con el nombre del archivo (PascalCase)
class Usuario extends Model
{
    protected $table = 'usuario'; // El nombre de tu tabla
    
protected $allowedFields = ['Nombre', 'Apellido_Paterno', 'Apellido_Materno', 
'Codigo_User', 'Correo', 'Password', 'rol'];
    /**
     * Verifica si el correo y la contraseña coinciden con un usuario en la BD.
     * @param string $correo El correo del usuario.
     * @param string $password La contraseña del usuario.
     * @return mixed Retorna el objeto del usuario si la combinación es correcta, de lo contrario retorna null.
     */
    public function verificar_login($correo, $password)
    {
        // Usamos el Query Builder de CI4. El método first() es más eficiente.
        // Devuelve la primera fila que encuentra o null si no hay resultados.
        return $this->where('Correo', $correo)
                    ->where('Password', $password) // <-- ¡OJO! Sigue siendo inseguro para un producto real.
                    ->first();
    }

     public function registrar_usuario($data)
    {
        return $this->insert($data);
    }
}