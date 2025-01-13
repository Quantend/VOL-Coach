<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidatieMail extends Mailable
{
    use Queueable, SerializesModels;

    public $validatie;

    /**
     * Create a new message instance.
     */
    public function __construct($validatie)
    {
        $this->validatie = $validatie;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Validatie ingeleverd')
                    ->view('emails.validatie') 
                    ->with([
                        'validatie' => $this->validatie,
                    ]);
    }
}
