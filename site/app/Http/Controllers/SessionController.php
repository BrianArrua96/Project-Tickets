<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador para gestionar la sesión del usuario.
 */
class SessionController extends Controller
{
  /**
   * Cierra la sesión del usuario y redirige a la página de inicio de sesión.
   *
   * @return \Illuminate\Http\RedirectResponse Una redirección a la página de inicio de sesión.
   */
  public function out()
  {
    // Elimina la clave de sesión 'key'
    session()->forget('key');
    // Redirige a la página de inicio de sesión
    return redirect('login');
  }

  /**
   * Muestra la página de perfil del usuario.
   *
   * @return \Illuminate\View\View La vista de perfil del usuario.
   */
  public function profile()
  {
    return view('perfil');
  }

  /**
   * Muestra la página de inicio de sesión.
   *
   * @return \Illuminate\View\View La vista de inicio de sesión.
   */
  public function in()
  {
    return view('login');
  }

  /**
   * Gestiona las acciones relacionadas con la sesión del usuario.
   *
   * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
   * @return \Illuminate\Http\RedirectResponse Una redirección según la acción realizada.
   */
  public function SessionController(Request $request)
  {
    $session = $request->input('sesionOpcion');
    switch ($session) {
      case "profile":
        $this->profile();
        return view('perfil'); // Muestra la página de perfil del usuario
        break;
      case "closeSession":
        $this->out();
        return redirect('login'); // Cierra la sesión del usuario// Cierra la sesión del usuario
        break;
      case "openSession":
        $this->in();
        return redirect('login'); // Muestra la página de inicio de sesión
        break;
    }
  }
}
