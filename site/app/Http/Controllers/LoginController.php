<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador para manejar la autenticación de usuarios.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View La vista del formulario de inicio de sesión.
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Redirige al inicio de sesión del promotor.
     *
     * @return \Illuminate\View\View La vista del inicio de sesión del promotor.
     */
    public function promotorPage()
    {
        return view('homePromotor');
    }

    /**
     * Inicia sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Una redirección o una vista según el resultado de la autenticación.
     */
    public function iniciarSesion(Request $request)
    {
        // Verifica si ya existe una sesión activa
        if (session('key')) {
            return view('homePromotor');
        } else {
            // Validación de datos de entrada
            $validator = Validator::make($request->all(), [
                'usuario' => 'required',
                'password' => 'required',
            ]);

            $userName = $request->input('usuario');
            $password = $request->input('password');
            if ($validator->fails()) {
                return redirect('login')->withErrors(array('error' => 'Rellene todos los campos'));
            }

            // Busca el usuario en la base de datos
            $user = DB::table('users')->where('username', $userName)->first();

            // Obtiene el tipo de usuario
            $tipus = DB::table('users')->where('username', $userName)->value('tipus');

            // Verifica las credenciales del usuario
            if ($user && Hash::check($password, $user->password)) {
                // Establece la sesión 
                $request->session()->put('key', $userName);
                $request->session()->put('user_id', $user->id); // Almacenar el ID del usuario en la sesión

                // Redirige según el tipo de usuario
                if ($tipus == 'Promotor') {
                    return redirect()->route('homePromotor');
                } else {
                    return view('taullerAdministracio');
                }
            } else {
                return redirect('login')->withErrors(array('error' => 'Credenciales Incorrectas'));
            }
        }
    }
}
