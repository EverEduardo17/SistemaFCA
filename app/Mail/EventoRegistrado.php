<?php

namespace App\Mail;

use Symfony\Component\Mime\Email;

class EventoRegistrado extends Email
{
    private $input = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = (new Email())
            ->from('sistemafca@uv.mx')
            ->subject('Evento: Solicitud de aprobación para "'. $this->input['nombre'] . '"')
            ->html(view('emails.evento-registrado')->with('input',$this->input)->render());

        return $email;
    }
}
