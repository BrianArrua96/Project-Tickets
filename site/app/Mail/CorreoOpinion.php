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
 * Clase para enviar correos electrónicos solicitando una opinión sobre un evento.
 */
class CorreoOpinion extends Mailable
{
    use Queueable, SerializesModels;
    public $event, $url;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param mixed $event La información del evento.
     * @param string $url La URL para enviar la opinión.
     */
    public function __construct($event, $url)
    {
        $this->event = $event;
        $this->url = $url;
    }

    /**
     * Obtiene el sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Que tal ha sido el evento?',
            using: [
                function (Email $email) {
                    // Cabeceras
                    $email->getHeaders()
                        ->addTextHeader('X-Message-Source', 'example.com')
                        ->add(new UnstructuredHeader('X-Mailer', 'Mailtrap PHP Client'));

                    // Variables personalizadas
                    $email->getHeaders()
                        ->add(new CustomVariableHeader('user_id', '45982'))
                        ->add(new CustomVariableHeader('batch_id', 'PSJ-12'));

                    // Categoría (debería ser solo una)
                    $email->getHeaders()
                        ->add(new CategoryHeader('Integration Test'));
                },
            ]
        );
    }

    /**
     * Obtiene la definición del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.opinionMail',
            with: [
                $this->event,
                $this->url,
            ],
        );
    }

    /**
     * Obtiene los archivos adjuntos para el mensaje.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
