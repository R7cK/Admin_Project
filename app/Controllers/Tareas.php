<?php

namespace App\Controllers;


class Tareas extends BaseController
{
    public function index()
    {
        
        $data = [
            'tareas' => []
        ];

       
        echo view('Tareas/Tareas_header', $data);
        echo view('Tareas/Tareas_body', $data);
        echo view('Tareas/Tareas_footer', $data);
    }
}