<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\CorreoRecuperar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/**
 * Controlador para gestionar las contraseñas de los usuarios.
 */
class PasswordController extends Controller
{
    /**
     * Muestra la página para recuperar la contraseña.
     *
     * @return \Illuminate\View\View La vista para recuperar la contraseña.
     */
    public function passwordPage()
    {
        return view('recuperar');
    }

    /**
     * Muestra la página para cambiar la contraseña si el enlace de recuperación es válido.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse La vista para cambiar la contraseña o una redirección si el enlace ha caducado.
     */
    public function pagePassword(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return redirect('recuperar')->withErrors(array('error' => 'El link ha caducado, vuelva a pedirlo.'));
        } else {
            // Obtener el parámetro 'user' de la solicitud
            $userId = $request->input('user');
            return view('cambiarPassword', ['userId' => $userId]);
        }
    }
    // Función que recoje el mail escrito, confirma la existencia de esté en la bd y si existe enviará 
    //el correo a dicho mail con una url que redirige al usuario a la pantalla cambiar contraseña
    /**
     * Envia un correo electrónico al usuario con un enlace para recuperar la contraseña.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de inicio de sesión con un mensaje de éxito o error.
     */
    public function enviarCorreo(Request $request)
    {
        $email = $request->input('email');
        $user = DB::table('users')->where('email', $email)->value('email');

        if ($email == $user) {
            try {
                $username = DB::table('users')->where('email', $email)->value('name');
                $userId = DB::table('users')->where('email', $email)->value('id');
                $url = URL::temporarySignedRoute('cambiarPassword', now()->addMinutes(env('MAIL_TIME_LIMIT')), ['user' => $userId]);
                $data = ['username' => $username, 'urlGenerada' => $url];
                Mail::to($email)->send(new CorreoRecuperar($data));
                Log::info('Mail enviado exitosamente por contraseña olvidada - Usuario: ' . $username);
                return redirect('login')->withErrors(array('vali' => 'Correo enviado si su mail esta enlazado con una cuenta.'));
            } catch (Exception $e) {
                Log::error('Error en el envio de mail por contraseña olvidada - Usuario: ' . $username . ', Error:' . $e->getMessage());
            }
        } elseif ($email != $user) {
            return redirect('login')->withErrors(array('vali' => 'Correo enviado si su mail esta enlazado con una cuenta.'));
        } else {
            return redirect('recuperar')->withErrors(array('error' => 'Se ha producido un error.'));
        }
    }

    /**
     * Cambia la contraseña del usuario.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP.
     * @return \Illuminate\Http\RedirectResponse Una redirección a la página de inicio de sesión con un mensaje de éxito o error.
     */
    public function cambiarPassword(Request $request)
    {
        $password = $request->input('password');
        $user = $request->input('userId');
        if (strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
            User::where('id', $user)->update(array('password' => Hash::make($password)));
            Log::info('Contraseña de usuario ' . $user . 'cambiada correctamentea.');
            return redirect('login')->withErrors(array('vali' => 'Contraseña cambiada correctamente'));
        } else {
            return back()->withErrors(array('error' => 'La contraseña necesita al menos 8 caracteres, una mayuscula, y un simbolo'));
        }
    }
}
