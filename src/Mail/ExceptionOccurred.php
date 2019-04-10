<?php

namespace Fahedaljghine\ErrorsMail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Config;
use Illuminate\Support\Facades\Route;

class ExceptionOccurred extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     *
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.exception')
            ->subject(Config::get('app.name_ar', "ExceptionOccurred"))
            ->with(
                'route', Route::current(),
                'content', $this->content
            );
    }
}
