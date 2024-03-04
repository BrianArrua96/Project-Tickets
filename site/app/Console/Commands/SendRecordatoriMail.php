<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Sessio;
use Elibyy\TCPDF\TCPDF;
use App\Mail\CorreoRecordatori;
use App\Models\CompraEntrada;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Comando para enviar correos electrónicos de recordatorio a los compradores de eventos.
 */
class SendRecordatoriMail extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Manda emails diarios a todos los compradores de eventos, cuyos sucedan el dia posterior.';

    /**
     * Ejecuta el comando de consola.
     */
    public function handle()
    {
        try {
            // Obtiene la fecha de mañana
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');

            // Busca las sesiones programadas para mañana
            $sessios = DB::table('sessios')->whereDate('data', $tomorrow)->get();

            // Si no hay sesiones, registra un mensaje de información y termina la ejecución
            if ($sessios->isEmpty()) {
                Log::info('No hay sesiones programadas para mañana');
                return;
            }

            // Itera sobre las sesiones encontradas
            foreach ($sessios as $sessio) {
                // Obtiene las compras asociadas a la sesión
                $compras = DB::table('compras')->where('sessios_id', $sessio->id)->get();

                // Itera sobre las compras encontradas
                foreach ($compras as $compra) {
                    // Obtiene el evento asociado a la sesión
                    $evento = DB::table('esdeveniments')->where('id', $sessio->esdeveniments_id)->first();

                    // Obtiene las entradas de la compra
                    $entrades = CompraEntrada::getEntrades($compra->id);

                    // Obtiene el recinto de la sesión
                    $recinte = Sessio::getRecinteFromSessio($sessio->id);

                    // Construye la dirección del recinto
                    $lloc = $recinte->provincia . ', ' . $recinte->lloc . ', ' . $recinte->codi_postal . ', ' . $recinte->carrer . ', ' . $recinte->numero;

                    // Crea un nuevo objeto TCPDF
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $pdf->SetCreator('ShowTickt');
                    $pdf->SetTitle('Entradas');
                    $image = '<img style="text-align:center;" src="' . public_path('imagen/logo-blanco.png') . '" width="100" alt="logo">';
                    $titol = '<h1 style="font-size: 40px; text-align:center;">ShowTickt</h1>';

                    // Agrega una página al PDF
                    $pdf->AddPage('L', 'A4');
                    $y = $pdf->getY();
                    $pdf->writeHTMLCell(40, 0, '', $y, $image, 0, 0, 0, true, 'C', true);
                    $pdf->writeHTMLCell(80, 0, '', '', $titol, 0, 1, 0, true, 'C', true);

                    // Renderiza la vista de las entradas en formato HTML
                    $data = view('pdfs.entradas', ['event' => $evento, 'entrades' => $entrades, 'sessio' => $sessio->data, 'lloc' => $lloc])->render();
                    $pdf->writeHTML($data, true, false, true, false, '');
                    $pdfContent = $pdf->Output('', 'S');

                    // Envía el correo electrónico con el PDF adjunto
                    Mail::to($compra->mailComprador)->send(new CorreoRecordatori($evento, $pdfContent));
                    Log::info('Mail enviado');
                }
            };
            // Registra un mensaje de información sobre el éxito del envío de correos
            Log::info('Enviados mails de recordatorio a eventos.');
        } catch (Exception $e) {
            // Registra un mensaje de error si ocurre una excepción durante el proceso
            Log::error('Error al enviar los mails recordatorios. Error: ' . $e->getMessage());
        }
    }
}
