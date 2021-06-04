<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $order){
        $this->name = $name;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Pastelaria Daora - Detalhes do Pedido")
                ->view('emails')
                ->with(['name' => $this->name])
                ->with(['order' => $this->order]);
    }
}
