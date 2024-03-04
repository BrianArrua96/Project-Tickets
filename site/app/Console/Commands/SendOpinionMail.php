<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\CorreoOpinion;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

/**
 * Comando para enviar correos electrónicos solicitando opiniones sobre eventos.
 */
class SendOpinionMail extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'send:opinion';

    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Comando para enviar el día posterior a eventos una url con petición para comentar en la página.';

    /**
     * Ejecuta el comando de consola.
     */
    public function handle()
    {
        try {
            // Obtiene la fecha de mañana
            $tomorrow = Carbon::yesterday()->format('Y-m-d');

            // Busca las sesiones del día de ayer
            $sessios = DB::table('sessios')->whereDate('data', $tomorrow)->get();

            // Si no hay sesiones, registra un mensaje de información y termina la ejecución
            if ($sessios->isEmpty()) {
                Log::info('No hay sesiones de ayer');
                return;
            }

            // Itera sobre las sesiones encontradas
            foreach ($sessios as $sessio) {
                // Obtiene el evento asociado a la sesión
                $event = DB::table('esdeveniments')->where('id', $sessio->esdeveniments_id)->first();

                // Obtiene las compras asociadas a la sesión
                $compras = DB::table('compras')->where('sessios_id', $sessio->id)->get();

                // Itera sobre las compras encontradas
                foreach ($compras as $compra) {
                    // Genera la URL firmada para la creación de opiniones
                    $url = URL::signedRoute('crearOpinion', ['event-id' => $event->id]);

                    // Envía el correo electrónico de solicitud de opinión
                    Mail::to($compra->mailComprador)->send(new CorreoOpinion($event, $url));
                }
            }

            // Registra un mensaje de información sobre el éxito del envío de correos
            Log::info('Mails de petición de opiniones enviadas correctamente.');
        } catch (Exception $e) {
            // Registra un mensaje de error si ocurre una excepción durante el proceso
            Log::error('Error al mandar los mails de petición de opiniones. Error: ' . $e->getMessage());
        }
    }
}
