<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * CodeEmail Mailable class.
 *
 * This class handles sending a verification code via email.
 */
class CodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The verification code.
     *
     * @var string
     */
    public $code;

    /**
     * Create a new message instance.
     *
     * @param string $code  The verification code to be sent.
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code; // Initialize the verification code
    }

    /**
     * Build the email message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verification Code') // Set the email subject
                    ->view('mails.codetwofactor')  // Specify the email template
                    ->with(['code' => $this->code]); // Pass the code to the template
    }
}
