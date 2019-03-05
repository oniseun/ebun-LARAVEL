<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FastMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject,$data,$view,$plain_view ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$data,$view,$plain_view)
    {
        $this->subject = $subject ;
        $this->data = $data ;
        $this->view = $view ;
        $this->plain_view = $plain_view ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
                    ->subject($this->subject)
                    ->view($this->view)
                    ->text($this->plain_view)
                    ->with( $this->data);
    }
}
