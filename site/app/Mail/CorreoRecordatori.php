<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Symfony\Component\Mime\Email;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Mailtrap\EmailHeader\CategoryHeader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;

/**
 * Clase para enviar correos electrónicos de recordatorio de eventos.
 */
class CorreoRecordatori extends Mailable
{
    use Queueable, SerializesModels;

    public $evento, $pdfContent;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param mixed $evento La información del evento.
     * @param string $pdfContent El contenido del archivo PDF a adjuntar.
     */
    public function __construct($evento, $pdfContent)
    {
        $this->evento = $evento;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Construye el mensaje de correo electrónico.
     */
    public function build()
    {
        return $this->subject('Recordatori evento')
                    ->view('mails.recordatoriMail')
                    ->attachData($this->pdfContent, 'entradas.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
