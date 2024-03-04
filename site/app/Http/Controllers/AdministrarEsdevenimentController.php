<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador para administrar eventos.
 */
class AdministrarEsdevenimentController extends Controller
{
    /**
     * Muestra la vista para administrar un evento específico.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        // Lógica para administrar el esdeveniment
        return view('administrarEsdeveniment');
    }
}
