<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
use Illuminate\Http\Request;

/**
 * Controlador para administrar eventos.
 */
class AdministrarEsdevenimentsController extends Controller
{
    /**
     * Muestra la lista de eventos administrados por el usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Obtiene el ID de usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Llama a la función del modelo para obtener los eventos administrados por el usuario
        $esdeveniments = Esdeveniment::getAdminEvents($userId);

        // Pasa los eventos a la vista
        return view('administrarEsdeveniments', ['esdeveniments' => $esdeveniments]);
    }
}
