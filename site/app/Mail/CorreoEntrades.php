<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Attachable;
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
 * Clase para enviar correos electrónicos con entradas adjuntas.
 */
class CorreoEntrades extends Mailable
{
    use Queueable, SerializesModels;

    public $evento, $sessio, $pdfContent;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param mixed $evento La información del evento.
     * @param mixed $sessio La información de la sesión.
     * @param mixed $pdfContent El contenido del archivo PDF adjunto.
     */
    public function __construct($evento, $sessio, $pdfContent)
    {
        $this->evento = $evento;
        $this->sessio = $sessio;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Construye el mensaje de correo electrónico.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Compra Entrades')
                    ->view('mails.entradesMail')
                    ->attachData($this->pdfContent, 'entradas.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
