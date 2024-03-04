<?php

namespace App\Http\Controllers;

use App\Models\Sessio;
use Illuminate\Http\Request;

/**
 * Controlador para mostrar el listado de sesiones de un usuario.
 */
class LlistatSessionsController extends Controller
{
    /**
     * Muestra el listado de sesiones de un usuario.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP.
     * @return \Illuminate\View\View  La vista del listado de sesiones.
     */
    public function index(Request $request)
    {
        // Obtiene el usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Obtén las sesiones asociadas al usuario y ordenadas por fecha
        $sesiones = (new Sessio())->getUserSessions($userId);

        // Pasa las sesiones a la vista
        return view('llistatSessions', ['sesiones' => $sesiones]);
    }
}
