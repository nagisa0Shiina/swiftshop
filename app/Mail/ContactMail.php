<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('【ShopSwift】お問い合わせが届きました')
            ->replyTo($this->contactData['email'], $this->contactData['name'])
            ->view('emails.contact');
    }
}