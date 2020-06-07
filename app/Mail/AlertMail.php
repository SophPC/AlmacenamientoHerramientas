<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alerta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alerta)
    {
        $this->alerta = $alerta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->alerta);
        return $this->markdown('alertMail');
    }
}
