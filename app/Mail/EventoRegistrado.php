<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventoRegistrado extends Mailable
{
    use Queueable, SerializesModels;

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
        return $this->from('sistemafca@uv.mx','SistemaFCA')
            ->subject('Evento: Solicitud de aprobación para "'. $this->input['nombre'] . '"')
            ->view('emails.evento-registrado')->with('input',$this->input);
    }
}
