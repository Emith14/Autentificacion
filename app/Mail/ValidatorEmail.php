<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * ValidatorEmail Mailable class.
 *
 * This class is responsible for sending an account activation email.
 */
class ValidatorEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The signed route URL for account activation.
     *
     * @var string
     */
    public $signedroute;

    /**
     * Create a new message instance.
     *
     * @param string $signedroute The signed route URL for the activation link.
     * @return void
     */
    public function __construct($signedroute)
    {
        $this->signedroute = $signedroute; // Initialize the signed route URL
    }

    /**
     * Get the message envelope.
     *
     * Defines the metadata for the email, such as the subject.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Activate Your Account' // Set the email subject
        );
    }

    /**
     * Get the message content definition.
     *
     * Defines the email content, including the view template.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.validate', // Specify the view template for the email
        );
    }

    /**
     * Get the attachments for the message.
     *
     * Specifies any attachments to include with the email. 
     * In this case, no attachments are included.
     *
     * @return array An empty array (no attachments).
     */
    public function attachments()
    {
        return []; // No attachments are included in this email
    }
}
