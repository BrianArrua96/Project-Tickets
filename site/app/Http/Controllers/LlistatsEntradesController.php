<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador para mostrar los listados de entradas.
 */
class LlistatsEntradesController extends Controller
{
    /**
     * Muestra los listados de entradas.
     *
     * @param  int  $id  El identificador del listado de entradas.
     * @return \Illuminate\View\View  La vista de los listados de entradas.
     */
    public function show($id)
    {
        // Lógica para mostrar los listados de entradas
        return view('llistatsEntrades');
    }
}
