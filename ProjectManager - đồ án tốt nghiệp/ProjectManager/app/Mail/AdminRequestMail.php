<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmationUrl;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $confirmationUrl
     */
    public function __construct($user, $confirmationUrl)
    {
        $this->user = $user;
        $this->confirmationUrl = $confirmationUrl;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Yêu cầu xác nhận quyền admin',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.admin_request', // View bạn sẽ tạo để hiển thị email
            with: [
                'user' => $this->user,
                'confirmationUrl' => $this->confirmationUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
