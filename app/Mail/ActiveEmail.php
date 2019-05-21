<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;

    /**
     * ActiveEmail constructor.
     * @param $_link
     */
    public function __construct($_link)
    {
        //
        $this->link = $_link;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ActiveEmail', ['link' => $this->link]);
    }
}
