<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Mime\Email;
use Mailtrap\EmailHeader\CategoryHeader;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase para enviar correos electrónicos de recuperación de contraseña.
 */
class CorreoRecuperar extends Mailable
{
    use Queueable, SerializesModels;

    public $urlRecuperacion, $usuario;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param array $datos Los datos necesarios para construir el correo de recuperación.
     */
    public function __construct($datos)
    {
        $this->urlRecuperacion = $datos['urlGenerada'];
        $this->usuario = $datos['username'];
    }

    /**
     * Define el sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperar Contraseña ShowTickt',
            using: [
                function (Email $email) {
                    // Cabezeras
                    $email->getHeaders()
                        ->addTextHeader('X-Message-Source', 'example.com')
                        ->add(new UnstructuredHeader('X-Mailer', 'Mailtrap PHP Client'));

                    // Variables personalizadas
                    $email->getHeaders()
                        ->add(new CustomVariableHeader('user_id', '45982'))
                        ->add(new CustomVariableHeader('batch_id', 'PSJ-12'));

                    // Categoría (debe ser solo una)
                    $email->getHeaders()
                        ->add(new CategoryHeader('Integration Test'));
                },
            ]
        );
    }

    /**
     * Define el contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.passwordMail',
            with: ([
                'url' => $this->urlRecuperacion,
                'name' => $this->usuario,
            ])
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
