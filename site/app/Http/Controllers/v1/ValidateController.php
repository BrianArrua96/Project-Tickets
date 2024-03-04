<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Clase controladora para la validación.
 */
class ValidateController extends Controller
{
  /**
   * Muestra la información recibida en la solicitud y redirige a la ruta para iniciar sesión.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Routing\Redirector
   */
  public function index(Request $request)
  {
    // Muestra la información recibida en la solicitud
    dd($request->input());

    // Redirige a la ruta para iniciar sesión
    return route('iniciarSesion');
  }
}
