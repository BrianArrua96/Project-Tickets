<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador para mostrar los detalles de un evento.
 */
class DetallsEsdevenimentController extends Controller
{
    /**
     * Muestra los detalles del evento con el ID proporcionado.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        // Lógica para mostrar detalles del esdeveniment
        return view('detallsEsdeveniments');
    }
}
