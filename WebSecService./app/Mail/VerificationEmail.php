<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The verification link.
     *
     * @var string
     */
    private $link = null;

    /**
     * The user's name.
     *
     * @var string
     */
    private $name = null;

    /**
     * Create a new message instance.
     *
     * @param  string  $link
     * @param  string  $name
     * @return void
     */
    public function __construct($link, $name)
    {
        $this->link = $link;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verification',
            with: [
                'link' => $this->link,
                'name' => $this->name
            ],
        );
    }
}
